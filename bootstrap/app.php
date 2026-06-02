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
        // Esto hace que Laravel reconozca el HTTPS, el Host y la IP real del usuario.
        //
        // SEGURIDAD: confiar en '*' significa creer el X-Forwarded-For/-Proto de
        // CUALQUIER origen. Si el contenedor de la app fuese alcanzable sin pasar
        // por NPM, un atacante podría falsear su IP real (envenenar la telemetría
        // de baneos/visitantes). Lo correcto es confiar solo en la IP/red del
        // proxy. Se hace configurable por env (TRUSTED_PROXIES, lista separada por
        // comas, p.ej. la subred Docker de NPM) y cae a '*' si no se define, para
        // no romper el despliegue existente.
        $proxies = env('TRUSTED_PROXIES', '*');
        $middleware->trustProxies(at: $proxies === '*' ? '*' : array_map('trim', explode(',', $proxies)));

        // ✅ Mantenemos la seguridad
        $middleware->append(SecureHeadersMiddleware::class);

        // 📡 Telemetría de seguridad: cuenta los sondeos maliciosos (404 a rutas
        // de ataque tipo .env/.git/wp-admin). Solo actúa sobre respuestas 404.
        $middleware->append(BlockedProbeLogger::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
