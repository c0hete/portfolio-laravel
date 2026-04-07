<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SecureHeadersMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ Mantenemos la seguridad
        $middleware->append(SecureHeadersMiddleware::class);

        // 🪓 Eliminamos el tracking del Hub para evitar errores de inyección
        // $middleware->append(App\Http\Middleware\TrackPageViews::class); 
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();