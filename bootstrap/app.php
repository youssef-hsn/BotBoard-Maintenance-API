<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    // Routing Configuration
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Middleware Configuration
    ->withMiddleware(function ($middleware) {
    })
    ->withExceptions(function ($exceptions) {
        $exceptions->map(\Illuminate\Auth\AuthenticationException::class, function ($e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        });

        $exceptions->map(\Illuminate\Validation\ValidationException::class, function ($e) {
            return response()->json(['errors' => $e->errors()], 422);
        });
    })
    ->create();