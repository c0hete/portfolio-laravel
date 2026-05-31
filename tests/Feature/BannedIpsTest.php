<?php

namespace Tests\Feature;

use App\Services\BannedIps;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BannedIpsTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_comando_registra_baneos(): void
    {
        $json = json_encode([
            ['ip_masked' => '78.83.x.x', 'ip_hash' => 'hash-bg-1', 'country' => 'BG', 'jail' => 'sshd', 'banned_at' => '2026-05-31 18:00:00'],
            ['ip_masked' => '45.12.x.x', 'ip_hash' => 'hash-cn-1', 'country' => 'CN', 'jail' => 'sshd', 'banned_at' => '2026-05-31 18:05:00'],
        ]);

        $this->artisan('infra:registrar-baneos', ['--json' => $json])->assertSuccessful();

        $this->assertSame(2, DB::table('banned_ips')->count());
        $this->assertSame('BG', DB::table('banned_ips')->where('ip_hash', 'hash-bg-1')->value('country'));
    }

    public function test_baneo_reincidente_suma_hits_no_duplica(): void
    {
        $row = fn ($at) => json_encode([['ip_masked' => '78.83.x.x', 'ip_hash' => 'hash-bg-1', 'country' => 'BG', 'banned_at' => $at]]);

        $this->artisan('infra:registrar-baneos', ['--json' => $row('2026-05-31 18:00:00')])->assertSuccessful();
        $this->artisan('infra:registrar-baneos', ['--json' => $row('2026-05-31 19:00:00')])->assertSuccessful();

        $this->assertSame(1, DB::table('banned_ips')->count());
        $this->assertSame(2, (int) DB::table('banned_ips')->where('ip_hash', 'hash-bg-1')->value('hits'));
    }

    public function test_no_se_guarda_la_ip_completa(): void
    {
        // El comando recibe ya enmascarado; verificamos que lo persistido no es una IP completa.
        $json = json_encode([['ip_masked' => '78.83.x.x', 'ip_hash' => 'h1', 'country' => 'BG']]);
        $this->artisan('infra:registrar-baneos', ['--json' => $json])->assertSuccessful();

        $stored = DB::table('banned_ips')->value('ip_masked');
        $this->assertStringContainsString('x.x', $stored);
        $this->assertStringNotContainsString('249', $stored); // ningún octeto real completo
    }

    public function test_service_agrega_total_paises_y_recientes(): void
    {
        Cache::flush();
        DB::table('banned_ips')->insert([
            ['ip_masked' => '78.83.x.x', 'ip_hash' => 'a', 'country' => 'BG', 'jail' => 'sshd', 'hits' => 2, 'banned_at' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['ip_masked' => '45.12.x.x', 'ip_hash' => 'b', 'country' => 'CN', 'jail' => 'sshd', 'hits' => 1, 'banned_at' => now()->subHour(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        $stats = (new BannedIps)->stats();

        $this->assertSame(2, $stats['total']);
        $this->assertSame(2, $stats['paises']);
        $this->assertCount(2, $stats['recientes']);
    }

    public function test_service_vacio_si_no_hay_baneos(): void
    {
        Cache::flush();
        $stats = (new BannedIps)->stats();
        $this->assertSame(0, $stats['total']);
        $this->assertSame([], $stats['recientes']);
    }
}
