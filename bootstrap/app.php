<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

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
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'error' => 'Unauthenticated.',
                'message' => "JWT Token Missing Or Invalid.",
            ], 401);
        });
        $exceptions->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'error' => 'Validation Error.',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        });
    })
    ->create();