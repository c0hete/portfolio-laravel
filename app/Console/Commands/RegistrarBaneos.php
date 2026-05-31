<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Persiste en `banned_ips` los baneos de fail2ban detectados en el hub.
 *
 * Recibe un JSON con las filas ya procesadas (IP enmascarada + hash + país),
 * porque este comando corre DENTRO del container del portafolio, que no tiene
 * acceso ni a la DB de fail2ban (root del host) ni a la base GeoIP. El cron del
 * host hace EXTRAE+geolocaliza+enmascara; este comando solo CARGA (patrón ETL).
 *
 * Uso (lo invoca el cron):
 *   php artisan infra:registrar-baneos --json='[{"ip_masked":"78.83.x.x","ip_hash":"...","country":"BG","jail":"sshd","banned_at":"2026-05-31 18:27:00"}]'
 */
class RegistrarBaneos extends Command
{
    protected $signature = 'infra:registrar-baneos {--json= : Array JSON de baneos}';

    protected $description = 'Persiste el historial de IPs baneadas por fail2ban (alimenta el widget de seguridad)';

    public function handle(): int
    {
        $raw = $this->option('json');
        if (! $raw) {
            $this->error('Falta --json.');

            return self::FAILURE;
        }

        $rows = json_decode($raw, true);
        if (! is_array($rows)) {
            $this->error('--json no es un array válido.');

            return self::FAILURE;
        }

        $now = Carbon::now();
        $n = 0;
        foreach ($rows as $r) {
            if (empty($r['ip_hash']) || empty($r['ip_masked'])) {
                continue;
            }

            // 'bans' = count REAL de baneos de fail2ban para esa IP. Se SETEA
            // (no se incrementa): el cron es idempotente, refleja el estado de
            // fail2ban en cada corrida sin inflar el número con cada pasada.
            $bans = max(1, (int) ($r['bans'] ?? 1));

            DB::table('banned_ips')->updateOrInsert(
                ['ip_hash' => $r['ip_hash']],
                [
                    'ip_masked' => $r['ip_masked'],
                    'country' => $r['country'] ?? null,
                    'jail' => $r['jail'] ?? 'sshd',
                    'hits' => $bans,
                    'banned_at' => $r['banned_at'] ?? $now,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
            $n++;
        }

        // Retención: limpiar baneos no vistos hace más de 90 días (higiene, como
        // hacen CrowdSec/AbuseIPDB). El histórico reciente se mantiene acumulado.
        $purgados = DB::table('banned_ips')
            ->where('banned_at', '<', $now->copy()->subDays(90))
            ->delete();

        $this->info("banned_ips: {$n} procesado(s)".($purgados ? ", {$purgados} purgado(s) (>90d)" : '').'.');

        return self::SUCCESS;
    }
}
