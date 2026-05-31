<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Lee métricas de Umami (self-hosted) para mostrarlas en el portafolio.
 *
 * Solo expone lo que queremos mostrar (países) — NO el dashboard completo.
 * El token de Umami vive server-side (config/.env) y NUNCA llega al navegador.
 * Resultado cacheado (default 30 min) para no golpear Umami en cada visita.
 */
class UmamiStats
{
    /**
     * Países desde donde nos visitan, ordenados por cantidad.
     * Devuelve [['code' => 'CL', 'count' => 3], ...] o [] si falla.
     * La vista renderiza el código como "chip" (los emoji de bandera no rinden
     * de forma consistente en Windows/varios navegadores).
     */
    /** Cadencia de refresco de los países (minutos). Mostrada en la vista. */
    public const REFRESH_MINUTES = 10;

    public function countries(int $days = 90, bool $fresh = false): array
    {
        // Sin config → no rompe, devuelve vacío (la vista lo maneja).
        $base = config('services.umami.api_url');
        $user = config('services.umami.api_user');
        $pass = config('services.umami.api_password');
        $websiteId = config('services.umami.website_id');

        if (! $base || ! $user || ! $pass || ! $websiteId) {
            return [];
        }

        if ($fresh) {
            Cache::forget('umami.countries');
        }

        return Cache::remember('umami.countries', now()->addMinutes(self::REFRESH_MINUTES), function () use ($base, $user, $pass, $websiteId, $days) {
            try {
                $token = $this->token($base, $user, $pass);
                if (! $token) {
                    return [];
                }

                $now = (int) (microtime(true) * 1000);
                $start = $now - ($days * 86400 * 1000);

                $resp = Http::withToken($token)
                    ->timeout(8)
                    ->get("{$base}/api/websites/{$websiteId}/metrics", [
                        'type' => 'country',
                        'startAt' => $start,
                        'endAt' => $now,
                    ]);

                if (! $resp->successful()) {
                    return [];
                }

                // Umami devuelve [{"x":"CL","y":3}, ...]
                return collect($resp->json())
                    ->filter(fn ($row) => ! empty($row['x']))
                    ->map(fn ($row) => [
                        'code' => $row['x'],
                        'count' => (int) ($row['y'] ?? 0),
                    ])
                    ->sortByDesc('count')
                    ->values()
                    ->all();
            } catch (\Throwable $e) {
                Log::warning('UmamiStats: no se pudieron leer países: '.$e->getMessage());

                return [];
            }
        });
    }

    /**
     * Token de la API de Umami (cacheado aparte, vida corta).
     */
    private function token(string $base, string $user, string $pass): ?string
    {
        return Cache::remember('umami.token', now()->addHours(1), function () use ($base, $user, $pass) {
            $resp = Http::timeout(8)->post("{$base}/api/auth/login", [
                'username' => $user,
                'password' => $pass,
            ]);

            return $resp->successful() ? ($resp->json('token') ?: null) : null;
        });
    }
}
