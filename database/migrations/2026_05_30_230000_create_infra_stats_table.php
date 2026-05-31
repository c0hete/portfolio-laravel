<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Métricas de infraestructura recolectadas por un proceso externo (cron →
     * comando `infra:contar-sondeos`), que el portafolio lee server-side.
     *
     * Patrón ETL: el colector (cron en el hub) cuenta los logs de NPM y hace
     * UPSERT acá; el sitio NUNCA toca el log directamente (containers separados).
     * Almacén key/value simple: una fila por métrica.
     */
    public function up(): void
    {
        Schema::create('infra_stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // 'sondeos_total', 'intentos_secretos'
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamp('measured_at')->nullable(); // cuándo se contó (lo setea el colector)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infra_stats');
    }
};
