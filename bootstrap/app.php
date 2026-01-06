<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);
        
        $middleware->alias([
            'api.auth' => \App\Http\Middleware\ApiAuthentication::class,
            'api.subscription' => \App\Http\Middleware\ApiSubscriptionAuth::class,
            'ip.rate.limit' => \App\Http\Middleware\IpRateLimit::class,
            'web.rate.limit' => \App\Http\Middleware\WebRateLimit::class,
            'api.rate.limit' => \App\Http\Middleware\ApiRateLimit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
