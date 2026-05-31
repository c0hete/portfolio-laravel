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
     * Devuelve [['code' => 'CL', 'flag' => '🇨🇱', 'count' => 3], ...] o [] si falla.
     */
    public function countries(int $days = 90): array
    {
        // Sin config → no rompe, devuelve vacío (la vista lo maneja).
        $base = config('services.umami.api_url');
        $user = config('services.umami.api_user');
        $pass = config('services.umami.api_password');
        $websiteId = config('services.umami.website_id');

        if (! $base || ! $user || ! $pass || ! $websiteId) {
            return [];
        }

        return Cache::remember('umami.countries', now()->addMinutes(30), function () use ($base, $user, $pass, $websiteId, $days) {
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
                        'flag' => $this->flag($row['x']),
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

    /**
     * Emoji de bandera a partir del código ISO de 2 letras (CL → 🇨🇱).
     */
    private function flag(string $code): string
    {
        $code = strtoupper($code);
        if (strlen($code) !== 2 || ! ctype_alpha($code)) {
            return '🌐';
        }
        // Cada letra → regional indicator symbol (offset 0x1F1E6 desde 'A').
        $a = mb_ord($code[0]) - 65 + 0x1F1E6;
        $b = mb_ord($code[1]) - 65 + 0x1F1E6;

        return mb_chr($a).mb_chr($b);
    }
}
