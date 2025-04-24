<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsCustomer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register as route middleware here
        $middleware->alias([
            'is.customer' => IsCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Optional exception config
    })
    ->create();
