<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\AddSecurityHeaders::class,
    ];

    protected $routeMiddleware = [
        // ... other middleware
        'user.access' => \App\Http\Middleware\CheckUserAccess::class,
    ];
}
