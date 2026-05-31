<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Persiste los conteos de sondeos a la infraestructura (medidos desde los logs
 * de NPM por el cron del hub) en la tabla `infra_stats`.
 *
 * Por qué recibe los números como argumentos y no lee el log él mismo:
 * este comando corre DENTRO del container del portafolio, que no tiene acceso
 * al log de NPM (vive en otro container). El cron del host —que sí tiene
 * docker— hace el conteo y se lo pasa. Separación limpia: el host EXTRAE,
 * este comando CARGA (patrón ETL). Así la persistencia queda versionada y testeable.
 *
 * Uso (lo invoca el cron):
 *   php artisan infra:contar-sondeos --total=8104 --secretos=931
 */
class ContarSondeosInfra extends Command
{
    protected $signature = 'infra:contar-sondeos
        {--total= : Total de sondeos a la infraestructura (líneas del log de NPM)}
        {--secretos= : Subset de intentos a secretos (.env/.git/...)}';

    protected $description = 'Persiste los conteos de sondeos a la infra (alimenta el widget de seguridad)';

    public function handle(): int
    {
        $total = $this->option('total');
        $secretos = $this->option('secretos');

        if ($total === null || ! is_numeric($total)) {
            $this->error('Falta --total (numérico).');

            return self::FAILURE;
        }

        $now = Carbon::now();
        $rows = [
            'sondeos_total' => (int) $total,
        ];
        if ($secretos !== null && is_numeric($secretos)) {
            $rows['intentos_secretos'] = (int) $secretos;
        }

        foreach ($rows as $key => $value) {
            DB::table('infra_stats')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'measured_at' => $now, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        $this->info('infra_stats actualizado: '.json_encode($rows));

        return self::SUCCESS;
    }
}
