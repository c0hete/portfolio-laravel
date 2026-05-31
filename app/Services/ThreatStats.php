<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Lee la telemetría de sondeos maliciosos detectados EN VIVO en este nodo
 * (tabla threat_probes, alimentada por BlockedProbeLogger).
 *
 * Análogo a UmamiStats: lectura cacheada (default 60s — el dato cambia más
 * rápido que los países) y degradación segura a vacío si la DB falla, para que
 * el widget nunca rompa la página.
 */
class ThreatStats
{
    /**
     * Estadísticas para el widget de seguridad.
     *
     * Devuelve:
     *   - total:    sondeos en vivo detectados en este dominio
     *   - secretos: subset categoría 'secret' (.env/.git/.aws...)
     *   - top:      [['pattern' => '.env', 'hits' => 12, 'category' => 'secret'], ...]
     *   - desde:    fecha del primer registro (inicio del monitoreo en vivo) o null
     *
     * Si la tabla está vacía o la DB falla → total 0 y top [] (la vista decide
     * mostrar solo el bloque histórico).
     */
    /** Cadencia de refresco del contador en vivo (segundos). Mostrada en la vista. */
    public const REFRESH_SECONDS = 30;

    public function stats(int $topLimit = 6, bool $fresh = false): array
    {
        $empty = ['total' => 0, 'secretos' => 0, 'top' => [], 'desde' => null];

        if ($fresh) {
            Cache::forget('threat.stats');
        }

        return Cache::remember('threat.stats', now()->addSeconds(self::REFRESH_SECONDS), function () use ($topLimit, $empty) {
            try {
                $rows = DB::table('threat_probes')
                    ->select('pattern', 'category', 'hits')
                    ->orderByDesc('hits')
                    ->get();

                if ($rows->isEmpty()) {
                    return $empty;
                }

                $total = (int) $rows->sum('hits');
                $secretos = (int) $rows->where('category', 'secret')->sum('hits');

                $top = $rows->take($topLimit)
                    ->map(fn ($r) => [
                        'pattern' => $r->pattern,
                        'hits' => (int) $r->hits,
                        'category' => $r->category,
                    ])
                    ->values()
                    ->all();

                $first = DB::table('threat_probes')->min('created_at');

                return [
                    'total' => $total,
                    'secretos' => $secretos,
                    'top' => $top,
                    'desde' => $first ? Carbon::parse($first)->locale('es')->isoFormat('D MMM YYYY') : null,
                ];
            } catch (\Throwable $e) {
                Log::warning('ThreatStats: no se pudieron leer los sondeos: '.$e->getMessage());

                return $empty;
            }
        });
    }

    /**
     * Sondeos a la INFRAESTRUCTURA (medidos desde los logs de NPM por el cron del
     * hub, persistidos en `infra_stats`). Distinto de stats(): aquello cuenta los
     * ataques a ESTE dominio Laravel; esto cuenta los de toda la IP del hub.
     *
     * Lee de la DB; si la tabla está vacía o falla, cae al snapshot de config
     * (`services.security_stats`) para no perder el dato histórico. Devuelve:
     *   ['sondeos_total' => N, 'intentos_secretos' => M, 'snapshot' => 'D MMM YYYY']
     */
    public function infra(): array
    {
        $fallback = [
            'sondeos_total' => (int) (config('services.security_stats.sondeos_total') ?? 0),
            'intentos_secretos' => (int) (config('services.security_stats.intentos_secretos') ?? 0),
            'snapshot' => config('services.security_stats.snapshot') ?? '—',
        ];

        return Cache::remember('threat.infra', now()->addMinutes(5), function () use ($fallback) {
            try {
                $rows = DB::table('infra_stats')->pluck('value', 'key');
                if ($rows->isEmpty() || ! $rows->has('sondeos_total')) {
                    return $fallback;
                }

                $measured = DB::table('infra_stats')->max('measured_at');

                return [
                    'sondeos_total' => (int) $rows->get('sondeos_total', 0),
                    'intentos_secretos' => (int) $rows->get('intentos_secretos', 0),
                    'snapshot' => $measured ? Carbon::parse($measured)->locale('es')->isoFormat('D MMM YYYY') : $fallback['snapshot'],
                ];
            } catch (\Throwable $e) {
                Log::warning('ThreatStats::infra: '.$e->getMessage());

                return $fallback;
            }
        });
    }
}
