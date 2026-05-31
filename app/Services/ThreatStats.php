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
    public function stats(int $topLimit = 6): array
    {
        $empty = ['total' => 0, 'secretos' => 0, 'top' => [], 'desde' => null];

        return Cache::remember('threat.stats', now()->addSeconds(60), function () use ($topLimit, $empty) {
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
}
