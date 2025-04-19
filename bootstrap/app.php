<?php

use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\CheckActiveSession;
use App\Http\Middleware\CheckOtpSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'active.session' => \App\Http\Middleware\CheckActiveSession::class,
            'otp.session' => \App\Http\Middleware\CheckOtpSession::class,
        ]);

        // If you have group middleware, continue appending like before
        $middleware->appendToGroup('api', JwtMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
