@extends('layouts.app')

@section('content')
{{-- --}}
<section class="min-h-[75vh] flex flex-col items-start justify-center px-6 md:px-10 max-w-6xl mx-auto py-24">
    
    {{-- Indicador de sistema --}}
    <div class="inline-flex items-center space-x-4 mb-14">
        <div class="flex items-center gap-3 px-4 py-1.5 bg-cyan-500/5 border border-cyan-500/20 rounded-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
            </span>
            <span class="font-mono text-[11px] tracking-[0.2em] text-cyan-400 uppercase">System Status: Active</span>
        </div>
        <span class="font-mono text-[11px] text-slate-600 uppercase tracking-widest">Temuco, CL — Remote Ready</span>
    </div>
    
    {{-- Título --}}
    <h1 class="text-5xl md:text-7xl font-bold tracking-tighter text-white mb-10 max-w-5xl leading-[1.05]">
        Full Stack Developer <br/> 
        <span class="text-slate-500">& Infrastructure Engineer.</span>
    </h1>
    
    {{-- Descripción --}}
<p class="max-w-3xl text-lg md:text-xl text-slate-400 mb-20 leading-relaxed font-light">
    Especialista en el ecosistema <span class="text-slate-200 font-normal">PHP/Laravel</span> orientado a la construcción de sistemas de alta disponibilidad. 
    Combino la ingeniería de software de precisión con la fortificación de infraestructuras críticas, garantizando despliegues resilientes y operaciones continuas.
</p>

    {{-- Metadata & Call to Action --}}
    <div class="flex flex-col md:flex-row items-start md:items-center gap-y-10 gap-x-12 border-t border-white/5 pt-16 w-full">
        
        {{-- Metadata Refactorizada (Enfoque Arquitecto) --}}
        <div class="flex flex-wrap items-center gap-x-12 gap-y-6">
            <div class="flex flex-col gap-1.5">
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest">Core Stack</span>
                <span class="text-base text-slate-300 font-medium">Laravel & Linux Ops</span>
            </div>
            
            {{--  dominio técnico --}}
            <div class="flex flex-col gap-1.5 border-l border-white/5 pl-12">
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest">Current Focus</span>
                <span class="text-base text-slate-300 font-medium">Critical Infrastructure</span>
            </div>
            
            <div class="flex flex-col gap-1.5 border-l border-white/5 pl-12">
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest">Operating From</span>
                <span class="text-base text-slate-300 font-medium italic">Temuco, Chile</span>
            </div>
        </div>
        
        {{-- Call to Action --}}
        <div class="ml-0 md:ml-auto pt-4 md:pt-0 flex flex-wrap items-center gap-4">
            <a href="/proyectos" class="group flex items-center gap-3.5 font-mono text-[12px] tracking-widest text-cyan-500 uppercase hover:text-cyan-300 transition-colors px-6 py-3 border border-cyan-500/20 hover:border-cyan-500/50 rounded-sm bg-cyan-500/5">
                Explorar Proyectos
                <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            <a href="/sobre-mi" class="group flex items-center gap-3 font-mono text-[12px] tracking-widest text-slate-400 uppercase hover:text-slate-200 transition-colors px-6 py-3 border border-white/10 hover:border-white/30 rounded-sm">
                Sobre mí
            </a>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════════════════
     SEGURIDAD PERIMETRAL — bloque destacado en la home (ancla #seguridad).
     Tres capas honestas que miden cosas distintas:
       (1) EN VIVO: ataques a ESTE dominio, contados por BlockedProbeLogger (cache 60s).
       (2) histórico: sondeos a la IP del hub vía NPM (snapshot).
       (3) robo de secretos: subset del histórico (intentos a .env/.git, bloqueados).
     ════════════════════════════════════════════════════════════════════════ --}}
@php $sec = $infra ?? config('services.security_stats'); $th = $threats ?? null; @endphp
@if (($sec && ($sec['sondeos_total'] ?? 0) > 0) || ($th && $th['total'] > 0))
<section id="seguridad" class="px-6 md:px-10 max-w-6xl mx-auto pb-24 -mt-4 scroll-mt-24">
    <div class="relative overflow-hidden p-8 md:p-10 bg-red-500/[0.015] border border-red-500/15 rounded-lg">
        {{-- glow sutil de fondo --}}
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative">
            {{-- Encabezado --}}
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-red-400/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                <h2 class="text-slate-100 font-semibold text-base uppercase tracking-widest">Seguridad perimetral</h2>
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest hidden sm:inline">// ataques maliciosos rechazados</span>
            </div>

            <div class="grid sm:grid-cols-3 gap-8">
                {{-- (1) EN VIVO --}}
                @if ($th && $th['total'] > 0)
                    <div>
                        <div class="flex items-baseline gap-2">
                            <p class="font-mono text-4xl md:text-5xl font-bold text-red-400/90 tracking-tight">{{ number_format($th['total']) }}</p>
                            <span class="relative flex h-2 w-2 mb-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                        </div>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">ataques rechazados <span class="text-red-400/60">· en vivo</span></p>
                    </div>
                @endif

                {{-- (2) histórico infraestructura --}}
                @if ($sec && ($sec['sondeos_total'] ?? 0) > 0)
                    <div>
                        <p class="font-mono text-4xl md:text-5xl font-bold text-slate-100 tracking-tight">{{ number_format($sec['sondeos_total']) }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">a la infraestructura <span class="text-slate-600">· snapshot {{ $sec['snapshot'] }}</span></p>
                    </div>
                    {{-- (3) robo de secretos (intentos bloqueados) --}}
                    <div>
                        <p class="font-mono text-4xl md:text-5xl font-bold text-red-400/80 tracking-tight">{{ number_format($sec['intentos_secretos']) }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">intentos de robo bloqueados (<span class="text-red-400/60">.env</span> · <span class="text-red-400/60">.git</span>)</p>
                    </div>
                @endif
            </div>

            {{-- Top rutas atacadas en vivo --}}
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

            @php $desdeTxt = ($th && $th['desde']) ? ' · en vivo desde '.$th['desde'] : ''; @endphp
            <p class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8 leading-relaxed">
                // todos rechazados · ningún acceso comprometido{{ $desdeTxt }}<br>
                // defensa: NPM + block-common-exploits · middleware Laravel · secretos fuera del repo · hardening OS
            </p>
        </div>
    </div>
</section>
@endif
@endsection