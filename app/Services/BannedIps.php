<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Lee el historial de IPs baneadas por fail2ban (tabla `banned_ips`, alimentada
 * por el cron del hub vía `infra:registrar-baneos`) para el widget de seguridad.
 *
 * Cacheado y con degradación segura: si la tabla está vacía o la DB falla,
 * devuelve estructura vacía y la vista oculta el cuadro.
 */
class BannedIps
{
    public const REFRESH_MINUTES = 5;

    /**
     * Devuelve:
     *   - total:    cantidad de IPs distintas baneadas (histórico)
     *   - paises:   cantidad de países distintos
     *   - recientes: [['ip' => '78.83.x.x', 'country' => 'BG', 'hits' => 2], ...]
     */
    public function stats(int $limit = 8, bool $fresh = false): array
    {
        $empty = ['total' => 0, 'paises' => 0, 'recientes' => []];

        if ($fresh) {
            Cache::forget('banned.ips');
        }

        return Cache::remember('banned.ips', now()->addMinutes(self::REFRESH_MINUTES), function () use ($limit, $empty) {
            try {
                $total = (int) DB::table('banned_ips')->count();
                if ($total === 0) {
                    return $empty;
                }

                $paises = (int) DB::table('banned_ips')->whereNotNull('country')->distinct()->count('country');

                $recientes = DB::table('banned_ips')
                    ->orderByDesc('banned_at')
                    ->limit($limit)
                    ->get()
                    ->map(fn ($r) => [
                        'ip' => $r->ip_masked,
                        'country' => $r->country,
                        'hits' => (int) $r->hits,
                    ])
                    ->all();

                return ['total' => $total, 'paises' => $paises, 'recientes' => $recientes];
            } catch (\Throwable $e) {
                Log::warning('BannedIps: '.$e->getMessage());

                return $empty;
            }
        });
    }
}
