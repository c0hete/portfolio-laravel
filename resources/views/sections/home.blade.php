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

{{-- Telemetría de defensa EN VIVO: sondeos maliciosos que este nodo detecta y
     rechaza, contados por el middleware BlockedProbeLogger en tiempo real.
     Solo aparece cuando ya hay datos (arranca de 0 y sube solo). --}}
@if (! empty($threats) && $threats['total'] > 0)
<section class="px-6 md:px-10 max-w-6xl mx-auto pb-24 -mt-8">
    <div class="relative overflow-hidden p-8 md:p-10 bg-red-500/[0.015] border border-red-500/10 rounded-lg">
        {{-- glow sutil de fondo --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative flex flex-col md:flex-row md:items-center gap-8 md:gap-12">
            {{-- Contador principal --}}
            <div class="shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    <span class="font-mono text-[10px] tracking-[0.25em] text-red-400/80 uppercase">Perimeter Defense · Live</span>
                </div>
                <p class="font-mono text-5xl md:text-6xl font-bold text-white tracking-tighter leading-none">{{ number_format($threats['total']) }}</p>
                <p class="font-mono text-[11px] text-slate-500 uppercase tracking-widest mt-3">sondeos maliciosos rechazados</p>
            </div>

            {{-- Descripción + desglose --}}
            <div class="md:border-l md:border-white/5 md:pl-12 space-y-4 flex-1">
                <p class="text-slate-400 text-sm md:text-base leading-relaxed max-w-xl">
                    Cada bot que escanea este nodo en busca de <span class="text-red-400/70 font-mono text-[13px]">.env</span>,
                    <span class="text-red-400/70 font-mono text-[13px]">.git</span> o paneles vulnerables
                    es detectado y rechazado. Telemetría propia, en tiempo real.
                </p>
                <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                    @if ($threats['secretos'] > 0)
                        <div class="flex items-baseline gap-2">
                            <span class="font-mono text-xl font-bold text-red-400/80">{{ number_format($threats['secretos']) }}</span>
                            <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest">robo de secretos</span>
                        </div>
                    @endif
                    <a href="/stack" class="group flex items-center gap-2 font-mono text-[11px] tracking-widest text-slate-500 hover:text-cyan-400 uppercase transition-colors">
                        Ver telemetría completa
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection