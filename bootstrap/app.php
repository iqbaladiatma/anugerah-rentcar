<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'secure.upload' => \App\Http\Middleware\SecureFileUpload::class,
            'enhanced.upload' => \App\Http\Middleware\EnhancedFileUploadSecurity::class,
            'error.handling' => \App\Http\Middleware\ErrorHandlingMiddleware::class,
            'performance' => \App\Http\Middleware\PerformanceMonitoringMiddleware::class,
            'profile.complete' => \App\Http\Middleware\EnsureProfileCompleted::class,
        ]);
        
        // Add error handling middleware to web group
        $middleware->web(append: [
            \App\Http\Middleware\ErrorHandlingMiddleware::class,
        ]);
        
        // Add performance monitoring middleware (only in non-production or when explicitly enabled)
        if (env('ENABLE_PERFORMANCE_MONITORING', false) || env('APP_DEBUG', false)) {
            $middleware->web(append: [
                \App\Http\Middleware\PerformanceMonitoringMiddleware::class,
            ]);
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Register custom exception reporting
        $exceptions->report(function (\Throwable $e) {
            $handler = app(\App\Exceptions\Handler::class);
            $handler->report($e);
        });
        
        // Register custom exception rendering
        $exceptions->render(function (\App\Exceptions\BusinessLogicException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Business rule violation',
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        });
        
        $exceptions->render(function (\App\Exceptions\DataIntegrityException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Data integrity error',
                    'message' => 'A data consistency issue occurred. Please try again.',
                ], 500);
            }
            return back()->withErrors([
                'error' => 'A data consistency issue occurred. Please refresh and try again.'
            ])->withInput();
        });
        
        $exceptions->render(function (\App\Exceptions\ExternalServiceException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'External service unavailable',
                    'message' => 'A required service is temporarily unavailable.',
                    'retry_after' => $e->getRetryAfter(),
                ], 503);
            }
            return back()->withErrors([
                'error' => 'A required service is temporarily unavailable. Please try again later.'
            ])->withInput();
        });
    })->create();
