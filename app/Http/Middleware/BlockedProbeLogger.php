<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Telemetría de seguridad EN VIVO: cuenta sondeos maliciosos que llegan a este
 * nodo (alvaradomazzei.cl) y terminan en 404 porque la ruta no existe.
 *
 * Filosofía:
 *  - Solo cuenta lo que es claramente un patrón de ataque (.env, .git, wp-admin,
 *    exploits...). Un 404 normal de la app (typo del visitante) NO se cuenta.
 *  - Persiste un CONTADOR AGREGADO por patrón (tabla threat_probes), no una fila
 *    por hit → escritura barata, tabla acotada aunque un bot insista.
 *  - Defensivo: si la DB falla, el sitio NO se cae (try/catch). El conteo es
 *    telemetría, nunca debe romper la respuesta al usuario.
 *  - Privacidad (repo público L2): NO se guarda la IP del atacante.
 */
class BlockedProbeLogger
{
    /**
     * Patrones de ataque. La clave es la etiqueta que se muestra/agrupa; el valor
     * es la categoría. 'secret' = intento de robar credenciales; 'probe' = escaneo.
     * El match es por substring case-insensitive sobre el path (sin query string).
     *
     * @var array<string, string>
     */
    private const PATTERNS = [
        // --- Robo de secretos / credenciales ---
        '.env' => 'secret',
        '.git' => 'secret',
        '.aws' => 'secret',
        '.ssh' => 'secret',
        'id_rsa' => 'secret',
        'credentials' => 'secret',
        '.htpasswd' => 'secret',
        'wp-config' => 'secret',
        'config.json' => 'secret',
        'docker-compose' => 'secret',

        // --- Escaneo / fingerprinting de CMS y paneles ---
        'wp-admin' => 'probe',
        'wp-login' => 'probe',
        'xmlrpc.php' => 'probe',
        'phpmyadmin' => 'probe',
        'phpunit' => 'probe',
        'eval-stdin' => 'probe',
        '/vendor/' => 'probe',
        '/cgi-bin/' => 'probe',
        '/shell' => 'probe',
        '.php' => 'probe', // PHP suelto: este sitio es Blade, ninguna ruta termina en .php
    ];

    /**
     * Rutas/prefijos legítimos del sitio. Un 404 dentro de este espacio (ej. un
     * typo del visitante) NO se considera ataque. Es la allowlist que evita
     * contar 404 normales de la app.
     *
     * @var array<int, string>
     */
    private const ALLOW_PREFIXES = [
        'build/',        // assets compilados por Vite
        'assets/',       // imágenes/logos
        'storage/',      // archivos públicos servidos por Laravel
        '.well-known/',  // ACME, security.txt, etc. — legítimo
        'favicon',       // favicon.ico / favicon.png
        'apple-touch',   // apple-touch-icon.png
        'robots.txt',
        'sitemap.xml',
        'up',            // health check de Laravel
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo nos interesan los 404: una ruta que existe y respondió 200/302/etc.
        // no es un sondeo fallido. Los patrones de ataque a este sitio Blade
        // siempre caen en 404 (no hay .env, ni wp-admin, ni .php).
        if ($response->getStatusCode() === 404) {
            $this->record($request->path());
        }

        return $response;
    }

    /**
     * Si el path matchea un patrón de ataque (y no es ruta legítima), incrementa
     * su contador. Todo dentro de try/catch: la telemetría nunca rompe la request.
     */
    private function record(string $path): void
    {
        $path = '/'.ltrim($path, '/');
        $lower = strtolower($path);

        // Allowlist: 404 dentro del espacio legítimo del sitio → no es ataque.
        foreach (self::ALLOW_PREFIXES as $prefix) {
            if (str_starts_with(ltrim($lower, '/'), $prefix)) {
                return;
            }
        }

        // Primer patrón que matchee gana (orden: secretos antes que .php genérico).
        // '.php' se ancla al FINAL del path (no substring): así un path legítimo
        // que contenga ".php" en medio —p. ej. un segmento o parámetro de ruta—
        // no se cuenta como sondeo. El resto siguen siendo match por substring.
        $matched = null;
        $category = null;
        foreach (self::PATTERNS as $pattern => $cat) {
            $hit = $pattern === '.php'
                ? str_ends_with($lower, '.php')
                : str_contains($lower, $pattern);

            if ($hit) {
                $matched = $pattern;
                $category = $cat;
                break;
            }
        }

        if ($matched === null) {
            return; // 404 que no matchea ningún patrón de ataque → se ignora.
        }

        try {
            $now = Carbon::now();
            $affected = DB::table('threat_probes')
                ->where('pattern', $matched)
                ->update([
                    'hits' => DB::raw('hits + 1'),
                    'last_path' => mb_substr($path, 0, 512),
                    'last_seen_at' => $now,
                    'updated_at' => $now,
                ]);

            if ($affected === 0) {
                DB::table('threat_probes')->insert([
                    'pattern' => $matched,
                    'category' => $category,
                    'hits' => 1,
                    'last_path' => mb_substr($path, 0, 512),
                    'last_seen_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        } catch (\Throwable $e) {
            // DB caída / migración aún no corrida / race en el insert único:
            // la telemetría es best-effort, nunca debe afectar al visitante.
            Log::warning('BlockedProbeLogger: no se pudo registrar el sondeo: '.$e->getMessage());
        }
    }
}
