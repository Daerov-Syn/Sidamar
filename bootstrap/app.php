<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO,
        );

        // Daftarkan alias middleware
        $middleware->alias([
            'admin' => EnsureAdmin::class,
        ]);

        // Security headers untuk semua request web
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

// Arahkan storage ke /tmp/storage saat di lingkungan serverless Vercel
if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || env('VERCEL') || !is_writable(storage_path())) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
