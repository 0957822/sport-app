<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Cache\RateLimiter;

class LoginController extends Controller
{
    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function login()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Check rate limiting
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Remember me token with secure settings
        $remember = $request->boolean('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                // Regenerate session securely
                $request->session()->regenerate();

                // Get authenticated user
                $user = Auth::user();

                // Increment login count
                $user->increment('login_count');
                $user->save();

                // Clear login attempts
                $this->clearLoginAttempts($request);

                // Set secure cookie settings if remember me is selected
                if ($remember) {
                    $rememberTokenCookie = Auth::guard()->getCookieJar()->forever(
                        Auth::guard()->getRecallerName(),
                        Auth::guard()->getRecallerCookie()
                    );

                    $rememberTokenCookie->secure(config('session.secure'));
                    $rememberTokenCookie->httpOnly(true);
                    $rememberTokenCookie->sameSite('lax');
                }

                // Set last login timestamp
                $user->update(['last_login' => now()]);

                // Redirect to profile page
                return redirect()->route('profile')
                    ->with('login_success', true);
            }
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Increment failed attempts
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts, $this->decayMinutes
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter->hit(
            $this->throttleKey($request), $this->decayMinutes * 60
        );
    }

    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter->clear($this->throttleKey($request));
    }

    protected function throttleKey(Request $request)
    {
        return mb_strtolower($request->input('email')) . '|' . $request->ip();
    }

    protected function fireLockoutEvent(Request $request)
    {
        event(new \Illuminate\Auth\Events\Lockout($request));
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(429);
    }
}
