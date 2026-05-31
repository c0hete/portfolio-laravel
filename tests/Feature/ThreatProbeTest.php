<?php

namespace Tests\Feature;

use App\Services\ThreatStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThreatProbeTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_sondeo_a_secreto_incrementa_el_contador(): void
    {
        $this->get('/.env')->assertNotFound();

        $row = DB::table('threat_probes')->where('pattern', '.env')->first();
        $this->assertNotNull($row, 'El sondeo a .env debió registrarse');
        $this->assertSame('secret', $row->category);
        $this->assertSame(1, (int) $row->hits);
    }

    public function test_sondeos_repetidos_acumulan_en_la_misma_fila(): void
    {
        $this->get('/wp-login.php')->assertNotFound();
        $this->get('/wp-login.php')->assertNotFound();
        $this->get('/wp-login.php')->assertNotFound();

        $rows = DB::table('threat_probes')->where('pattern', 'wp-login')->get();
        $this->assertCount(1, $rows, 'Debe haber UNA sola fila por patrón (contador agregado)');
        $this->assertSame(3, (int) $rows->first()->hits);
    }

    public function test_un_404_legitimo_no_se_cuenta_como_ataque(): void
    {
        // Ruta inexistente pero sin patrón de ataque (typo de un visitante real).
        $this->get('/proyecto-que-no-existe')->assertNotFound();

        $this->assertSame(0, DB::table('threat_probes')->count());
    }

    public function test_una_ruta_legitima_no_dispara_el_contador(): void
    {
        // La home existe y responde 200 → nunca debe contarse.
        $this->get('/')->assertOk();

        $this->assertSame(0, DB::table('threat_probes')->count());
    }

    public function test_threat_stats_agrega_total_y_secretos(): void
    {
        Cache::flush();
        DB::table('threat_probes')->insert([
            ['pattern' => '.env', 'category' => 'secret', 'hits' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['pattern' => 'wp-admin', 'category' => 'probe', 'hits' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $stats = (new ThreatStats)->stats();

        $this->assertSame(8, $stats['total']);
        $this->assertSame(5, $stats['secretos']);
        $this->assertSame('.env', $stats['top'][0]['pattern']); // ordenado por hits desc
    }
}
