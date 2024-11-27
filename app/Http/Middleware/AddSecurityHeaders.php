<?php

namespace App\Http\Middleware;

use Closure;

class AddSecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline';");
        return $response;
    }
}
