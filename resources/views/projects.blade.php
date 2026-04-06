@extends('layouts.app')

@section('title', 'Proyectos — Búnker Digital')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-16">
    <header class="mb-16">
        <h2 class="text-4xl font-bold text-white mb-4">Sistemas de <span class="text-emerald-400">Misión Crítica</span></h2>
        <p class="text-slate-400 max-w-2xl leading-relaxed">
            Arquitecturas diseñadas para la alta disponibilidad, cumplimiento normativo y seguridad de datos.
        </p>
    </header>

    <div class="grid md:grid-cols-2 gap-8">
        @forelse($projects as $project)
            <x-project-card :project="$project" />
        @empty
            <p class="text-slate-500 italic">Sincronizando con la base de datos del búnker...</p>
        @endforelse
    </div>
</section>
@endsection