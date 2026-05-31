<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Contadores agregados de sondeos maliciosos detectados EN ESTE NODO.
     *
     * Una fila por patrón de ataque (no una fila por hit) → la escritura es un
     * increment barato y la tabla no crece sin control aunque un bot insista.
     * NO se guarda IP del atacante (repo público L2: dato personal innecesario).
     */
    public function up(): void
    {
        Schema::create('threat_probes', function (Blueprint $table) {
            $table->id();
            $table->string('pattern')->unique();        // etiqueta del patrón: '.env', '.git', 'wp-admin'...
            $table->string('category')->default('probe'); // 'secret' (.env/.git/.aws...) | 'probe' (escaneo)
            $table->unsignedBigInteger('hits')->default(0);
            $table->string('last_path', 512)->nullable(); // último path crudo que matcheó (para detalle)
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threat_probes');
    }
};
