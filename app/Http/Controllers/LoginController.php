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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Add rate limiting
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Remember me token with secure settings
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session securely
            $request->session()->regenerate();

            // Clear login attempts
            $this->clearLoginAttempts($request);

            // If remember me was selected, ensure secure cookie settings
            if ($remember) {
                $rememberTokenCookie = Auth::guard()->getCookieJar()->forever(
                    Auth::guard()->getRecallerName(),
                    Auth::guard()->getRecallerCookie()
                );

                $rememberTokenCookie->secure(config('session.secure'));
                $rememberTokenCookie->httpOnly(true);
                $rememberTokenCookie->sameSite('lax');
            }

            return redirect()->intended('/dashboard');
        }

        // Increment failed attempts
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
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
