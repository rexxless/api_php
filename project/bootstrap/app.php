<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'message' => 'Login failed',
            ], 403);
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        });

        $exceptions->renderable(function (ValidationException $e) {
            $errors = collect($e->errors())->mapWithKeys(
                fn ($messages, $field) => [$field => 'Validation error']
            );

            return response()->json(
                ['message' => 'Validation error'] + $errors->all(),
                422
            );
        });

        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'message' => 'Method not allowed',
            ], 405);
        });
    })
    ->create();
