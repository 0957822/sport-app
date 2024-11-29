<?php

// app/Http/Middleware/CheckUserAccess.php
namespace App\Http\Middleware;

use Closure;

class CheckUserAccess
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (auth()->user()->role !== 'user' && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
