<?php

use App\Http\Middleware\BlockedProbeLogger;
use App\Http\Middleware\SecureHeadersMiddleware;
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
        // 🛡️ CONFÍA EN EL PROXY (Nginx)
        // Esto hace que Laravel reconozca el HTTPS, el Host y la IP real del usuario
        $middleware->trustProxies(at: '*');

        // ✅ Mantenemos la seguridad
        $middleware->append(SecureHeadersMiddleware::class);

        // 📡 Telemetría de seguridad: cuenta los sondeos maliciosos (404 a rutas
        // de ataque tipo .env/.git/wp-admin). Solo actúa sobre respuestas 404.
        $middleware->append(BlockedProbeLogger::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
