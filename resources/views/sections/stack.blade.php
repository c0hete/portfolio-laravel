@extends('layouts.app')

@section('title', 'Stack Tecnológico — José Alvarado Mazzei')
@section('description', 'Stack técnico: Laravel/PHP 8.x, PostgreSQL/MySQL, Redis, Docker, Linux hardening, OpenVAS, despliegues enterprise. Ingeniería de software + operaciones de seguridad.')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-16">
    
    <header class="mb-20">
        <div class="flex items-center gap-4 mb-4">
            <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Technical <span class="text-cyan-400">Stack</span></h2>
            <span class="h-px flex-1 bg-gradient-to-r from-cyan-500/20 to-transparent"></span>
        </div>
        <p class="text-slate-500 font-mono text-xs uppercase tracking-[0.3em]">
            Hybrid Software Engineering & Security Operations.
        </p>
    </header>

    <div class="grid md:grid-cols-2 gap-x-16 gap-y-12">
        
        {{-- Bloque 01: Backend & Systems (Ajustado a nivel Senior) --}}
        <div class="space-y-8">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                <span class="font-mono text-cyan-500/50 text-xs">01</span>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Software Engineering & Data</h3>
            </div>
            
            <div class="grid gap-4">
                <x-stack-icon name="Modern PHP (8.x) / Laravel" level="senior_level" color="cyan" />
                <x-stack-icon name="SQL Architecture (Postgres/MySQL)" level="senior_architect" color="cyan" />
                <x-stack-icon name="Redis / In-Memory Systems" level="optimized" color="cyan" />
                <x-stack-icon name="Modern UI (Blade/React/Tailwind)" level="full_stack_integrated" color="cyan" />
            </div>
        </div>

        {{-- Bloque 02: Infrastructure & SecOps (Enfoque SysAdmin/Seguridad) --}}
        <div class="space-y-8">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                <span class="font-mono text-cyan-500/50 text-xs">02</span>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Infrastructure & SecOps</h3>
            </div>
            
            <div class="grid gap-4">
                <x-stack-icon name="Docker / Orchestration" level="orchestrated" color="cyan" />
                <x-stack-icon name="Linux Hardening & Perimeter Sec" level="hardened" color="cyan" />
                <x-stack-icon name="OpenVAS / Vulnerability Audit" level="audited" color="cyan" />
                <x-stack-icon name="Enterprise Deploy (BBB/Moodle)" level="enterprise_deploy" color="cyan" />
            </div>
        </div>
    </div>

    {{-- Footer Técnico: Auditoría de Entorno (Este lo tenías perfecto) --}}
    <div class="mt-24 p-8 bg-cyan-500/[0.01] border border-cyan-500/10 rounded-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2 max-w-2xl">
                <p class="font-mono text-[10px] text-slate-500 leading-relaxed uppercase tracking-tighter">
                    <span class="text-cyan-500/60 font-bold">// CAPABILITIES_REPORT:</span> 
                    Despliegue de nodos críticos, administración de VPNs corporativas (Wireguard), arquitecturas DNS y servidores de correo (Mailcow) bajo estándares de seguridad ofensiva.
                </p>
                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-tighter">
                    <span class="text-cyan-500/60 font-bold">// WORKSTATION_OS:</span> Ubuntu Server, Kali Linux, PS_CLI.
                </p>
            </div>
            <div class="px-4 py-2 border border-cyan-500/20 text-cyan-400 font-mono text-[10px] uppercase tracking-[0.2em] animate-pulse shadow-[0_0_10px_rgba(6,182,212,0.1)]">
                Verified_Node_2026
            </div>
        </div>
    </div>

    {{-- Seguridad perimetral — DOS capas honestas que miden cosas distintas:
         (1) histórico: sondeos a la IP del hub vía NPM (snapshot manual de logs).
         (2) en vivo: sondeos a ESTE dominio Laravel, contados por el middleware
             BlockedProbeLogger en tiempo real (ThreatStats). Arranca de 0 y sube. --}}
    @php $sec = config('services.security_stats'); $th = $threats ?? null; @endphp
    @if (($sec && ($sec['sondeos_total'] ?? 0) > 0) || ($th && $th['total'] > 0))
        <div class="mt-12 p-8 bg-red-500/[0.02] border border-red-500/15 rounded-lg">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-red-400/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Seguridad perimetral</h3>
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest hidden sm:inline">// sondeos maliciosos rechazados</span>
            </div>

            <div class="grid sm:grid-cols-3 gap-8">
                {{-- En vivo: detectados en este nodo por el middleware --}}
                @if ($th && $th['total'] > 0)
                    <div>
                        <div class="flex items-baseline gap-2">
                            <p class="font-mono text-4xl md:text-5xl font-bold text-red-400/80 tracking-tight">{{ number_format($th['total']) }}</p>
                            <span class="relative flex h-2 w-2 mb-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </div>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">detectados en este nodo <span class="text-red-400/50">· en vivo</span></p>
                    </div>
                @endif

                {{-- Histórico: a la infraestructura del hub vía NPM (snapshot) --}}
                @if ($sec && ($sec['sondeos_total'] ?? 0) > 0)
                    <div>
                        <p class="font-mono text-4xl md:text-5xl font-bold text-slate-100 tracking-tight">{{ number_format($sec['sondeos_total']) }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">a la infraestructura <span class="text-slate-600">· snapshot {{ $sec['snapshot'] }}</span></p>
                    </div>
                    <div>
                        <p class="font-mono text-4xl md:text-5xl font-bold text-red-400/80 tracking-tight">{{ number_format($sec['intentos_secretos']) }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">robo de secretos (<span class="text-red-400/60">.env</span> · <span class="text-red-400/60">.git</span>)</p>
                    </div>
                @endif
            </div>

            {{-- Top rutas atacadas en vivo (detalle del contador del middleware) --}}
            @if ($th && ! empty($th['top']))
                <div class="mt-8 pt-6 border-t border-red-500/10">
                    <p class="font-mono text-[10px] text-slate-600 uppercase tracking-widest mb-4">// rutas más sondeadas en este nodo</p>
                    <div class="flex flex-wrap gap-x-6 gap-y-2">
                        @foreach ($th['top'] as $probe)
                            <div class="flex items-center gap-2 font-mono text-[11px]">
                                <span class="{{ $probe['category'] === 'secret' ? 'text-red-400/70' : 'text-slate-400' }}">{{ $probe['pattern'] }}</span>
                                <span class="text-slate-600">×{{ number_format($probe['hits']) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <p class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8 leading-relaxed">
                // todos rechazados · ningún acceso comprometido@if ($th && $th['desde']) · en vivo desde {{ $th['desde'] }}@endif<br>
                // defensa: NPM + block-common-exploits · middleware Laravel · secretos fuera del repo · hardening OS
            </p>
        </div>
    @endif

    {{-- Telemetría en vivo: países desde donde visitan este nodo (Umami self-hosted).
         Solo se muestra si hay datos (en local/sin tráfico no aparece). --}}
    @if (! empty($countries))
        @php $maxCount = max(array_column($countries, 'count')) ?: 1; @endphp
        <div class="mt-12">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </span>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Telemetría del nodo</h3>
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest">// visitas por país · últimos 90 días</span>
            </div>

            <div class="grid sm:grid-cols-2 gap-x-12 gap-y-3 max-w-3xl">
                @foreach (array_slice($countries, 0, 10) as $c)
                    <div class="flex items-center gap-4">
                        <span class="font-mono text-[11px] font-semibold text-cyan-300/90 shrink-0 w-9 text-center px-1.5 py-1 bg-cyan-500/5 border border-cyan-500/20 rounded">{{ $c['code'] }}</span>
                        <div class="flex-1 h-1.5 bg-slate-800/60 rounded-full overflow-hidden">
                            <div class="h-full bg-cyan-500/60 rounded-full" style="width: {{ max(4, round($c['count'] / $maxCount * 100)) }}%"></div>
                        </div>
                        <span class="font-mono text-[11px] text-cyan-400/70 w-8 text-right shrink-0">{{ $c['count'] }}</span>
                    </div>
                @endforeach
            </div>

            <p class="font-mono text-[9px] text-slate-700 uppercase tracking-widest mt-6">
                // datos propios · Umami self-hosted en infraestructura del nodo · sin cookies
            </p>
        </div>
    @endif

</section>
@endsection