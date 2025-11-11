<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.json' => \App\Http\Middleware\EnsureAuthenticatedJson::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (\Throwable $e, Request $request) {
        if ($e instanceof ValidationException) {
            return response()->json([
                'error'   => true,
                'message' => 'Validation failed',
                'fields'  => $e->errors(),
            ], 422);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'error'   => true,
                'message' => 'Resource not found',
            ], 404);
        }

        $status = $e instanceof HttpExceptionInterface
            ? $e->getStatusCode()
            : 500;

        return response()->json([
            'error'   => true,
            'message' => $e->getMessage(),
        ], $status);
    });

    })->create();
