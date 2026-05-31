@extends('layouts.app')

@section('title', 'Proyectos — José Alvarado Mazzei')
@section('description', 'Proyectos de desarrollo e infraestructura: SaaS multi-tenant en Laravel, control de asistencia biométrico, plataformas LMS (Moodle), videoconferencia (BigBlueButton) y correo corporativo (Mailcow). Software seguro y arquitecturas de alta disponibilidad.')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    
    {{-- Header de Sección: Enfoque Profesional --}}
    <header class="mb-20 border-l-2 border-cyan-500/30 pl-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-4">
            Sistemas & <span class="text-cyan-400">Proyectos Activos</span>
        </h2>
        <p class="text-slate-500 max-w-2xl leading-relaxed font-light text-sm md:text-base">
            Del desarrollo de software al despliegue seguro en producción. Cada proyecto integra
            ingeniería de aplicaciones, infraestructura de alta disponibilidad y seguridad de datos.
        </p>
    </header>

    {{-- Grid de Proyectos: Espaciado Industrial --}}
    <div class="grid md:grid-cols-2 gap-x-12 gap-y-16">
        @forelse($projects as $project)
            <x-project-card :project="$project" />
        @empty
            <div class="col-span-full py-20 border border-dashed border-white/5 flex flex-col items-center justify-center bg-white/[0.01]">
                <span class="animate-pulse font-mono text-[10px] text-slate-600 uppercase tracking-[0.3em]">
                    Sincronizando servicios con el nodo central...
                </span>
            </div>
        @endforelse
    </div>

    {{-- Footer de Sección: Metadata de Carga --}}
    <div class="mt-24 pt-8 border-t border-white/5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="font-mono text-[9px] text-slate-700 uppercase tracking-widest">Database: PostgreSQL v15</span>
            <span class="h-1 w-1 rounded-full bg-slate-800"></span>
            <span class="font-mono text-[9px] text-slate-700 uppercase tracking-widest">ORM: Eloquent</span>
        </div>
        <div class="hidden md:block">
            <span class="font-mono text-[9px] text-slate-800 uppercase">Load: 0.04s</span>
        </div>
    </div>

</section>
@endsection