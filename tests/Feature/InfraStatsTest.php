<?php

namespace Tests\Feature;

use App\Services\ThreatStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InfraStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_comando_persiste_los_conteos(): void
    {
        $this->artisan('infra:contar-sondeos', ['--total' => 8104, '--secretos' => 931])
            ->assertSuccessful();

        $this->assertSame(8104, (int) DB::table('infra_stats')->where('key', 'sondeos_total')->value('value'));
        $this->assertSame(931, (int) DB::table('infra_stats')->where('key', 'intentos_secretos')->value('value'));
    }

    public function test_el_comando_es_idempotente_actualiza_no_duplica(): void
    {
        $this->artisan('infra:contar-sondeos', ['--total' => 100])->assertSuccessful();
        $this->artisan('infra:contar-sondeos', ['--total' => 200])->assertSuccessful();

        $this->assertSame(1, DB::table('infra_stats')->where('key', 'sondeos_total')->count());
        $this->assertSame(200, (int) DB::table('infra_stats')->where('key', 'sondeos_total')->value('value'));
    }

    public function test_el_comando_falla_sin_total(): void
    {
        $this->artisan('infra:contar-sondeos')->assertFailed();
    }

    public function test_threat_stats_infra_lee_la_db(): void
    {
        Cache::flush();
        DB::table('infra_stats')->insert([
            ['key' => 'sondeos_total', 'value' => 8104, 'measured_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'intentos_secretos', 'value' => 931, 'measured_at' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        $infra = (new ThreatStats)->infra();

        $this->assertSame(8104, $infra['sondeos_total']);
        $this->assertSame(931, $infra['intentos_secretos']);
    }

    public function test_threat_stats_infra_cae_a_config_si_la_tabla_vacia(): void
    {
        Cache::flush();
        config(['services.security_stats.sondeos_total' => 8091, 'services.security_stats.intentos_secretos' => 927]);

        $infra = (new ThreatStats)->infra();

        // Sin filas en infra_stats → usa el fallback de config (histórico).
        $this->assertSame(8091, $infra['sondeos_total']);
        $this->assertSame(927, $infra['intentos_secretos']);
    }
}
