@extends('layouts.app')

@section('content')
{{-- Agrandamos el contenedor y el espaciado vertical --}}
<section class="min-h-[75vh] flex flex-col items-start justify-center px-10 max-w-7xl mx-auto py-24">
    
    {{-- Agrandamos el indicador de sistema --}}
    <div class="inline-flex items-center space-x-4 mb-14">
        <div class="flex items-center gap-3 px-4 py-1.5 bg-cyan-500/5 border border-cyan-500/20 rounded-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
            </span>
            <span class="font-mono text-[11px] tracking-[0.2em] text-cyan-400 uppercase">System Status: Active</span>
        </div>
        <span class="font-mono text-[11px] text-slate-600 uppercase tracking-widest">Node: vmi-2929444.cl</span>
    </div>
    
    {{-- Título: Agrandamos la fuente significativamente --}}
    <h1 class="text-5xl md:text-7xl font-bold tracking-tighter text-white mb-10 max-w-4xl leading-[1.05]">
        Arquitectura de Sistemas & <br/> 
        <span class="text-slate-500">Ingeniería de Contraparte.</span>
    </h1>
    
    {{-- Descripción: Agrandamos el texto y el espaciado --}}
    <p class="max-w-3xl text-lg md:text-xl text-slate-400 mb-20 leading-relaxed font-light">
        Especialista en desarrollo <span class="text-slate-200 font-normal">Backend Senior (PHP/Laravel)</span> y diseño de infraestructura escalable. 
        Enfoque integral en la automatización de despliegues, seguridad ofensiva y administración de entornos críticos bajo estándares de ciberseguridad.
    </p>

    {{-- Metadata & Call to Action: Corregimos el desborde --}}
    <div class="flex flex-col md:flex-row items-start md:items-center gap-y-10 gap-x-12 border-t border-white/5 pt-16 w-full">
        <div class="flex flex-wrap items-center gap-x-10 gap-y-4">
            <div class="flex flex-col gap-1.5">
                <span class="font-mono text-[11px] text-slate-600 uppercase tracking-tight">Specialization</span>
                <span class="text-base text-slate-300 font-medium">Cybersecurity & Infra</span>
            </div>
            <div class="flex flex-col gap-1.5">
                <span class="font-mono text-[11px] text-slate-600 uppercase tracking-tight">Current Focus</span>
                <span class="text-base text-slate-300 font-medium">Distributed Systems</span>
            </div>
            <div class="flex flex-col gap-1.5">
                <span class="font-mono text-[11px] text-slate-600 uppercase tracking-tight">Operating From</span>
                <span class="text-base text-slate-300 font-medium italic">Temuco, Chile</span>
            </div>
        </div>
        
        {{-- Botón: Ahora tiene espacio propio y se ve mejor --}}
        <div class="ml-0 md:ml-auto pt-4 md:pt-0">
            <a href="/proyectos" class="group flex items-center gap-3.5 font-mono text-[12px] tracking-widest text-cyan-500 uppercase hover:text-cyan-300 transition-colors px-6 py-3 border border-cyan-500/20 hover:border-cyan-500/50 rounded-sm bg-cyan-500/5">
                Explorar Proyectos
                <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection