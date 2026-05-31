<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Historial de IPs baneadas por fail2ban en el hub, alimentado por un cron
     * (comando `infra:registrar-baneos`) que lee la DB de fail2ban, geolocaliza
     * con la base GeoIP local del host y persiste acá.
     *
     * La IP se guarda ENMASCARADA (ej. 78.83.x.x) — no se almacena la IP
     * completa de terceros (privacidad). Una fila por IP+jail (upsert).
     */
    public function up(): void
    {
        Schema::create('banned_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_masked', 64);          // '78.83.x.x' (IPv4) o prefijo IPv6
            $table->string('ip_hash', 64)->unique();   // hash de la IP real → dedupe sin guardar la IP
            $table->string('country', 2)->nullable();  // código ISO ('BG', 'CN', ...)
            $table->string('jail', 32)->default('sshd');
            $table->unsignedInteger('hits')->default(1); // veces baneada
            $table->timestamp('banned_at')->nullable();  // último baneo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banned_ips');
    }
};
