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
                        <span class="text-lg leading-none shrink-0">{{ $c['flag'] }}</span>
                        <span class="font-mono text-xs text-slate-400 w-8 shrink-0">{{ $c['code'] }}</span>
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