@extends('layouts.app')

@section('content')
<section class="min-h-[80vh] flex flex-col items-center justify-center text-center px-4">
    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs mb-6">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
        </span>
        <span>Sistema en desarrollo — VMI Online</span>
    </div>
    
    <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-white mb-6">
        Construyendo el <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Búnker Digital</span>
    </h1>
    
    <p class="max-w-2xl text-lg text-slate-400 mb-10 leading-relaxed">
        Especialista en Backend PHP/Laravel [cite: 5, 10] y Arquitectura de Infraestructura. 
        Actualmente operando plataformas de alta disponibilidad y finalizando Ingeniería en Ciberseguridad[cite: 7, 36, 61].
    </p>

    <div class="flex flex-wrap justify-center gap-4">
        <div class="px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-sm font-mono">
            <span class="text-emerald-400">status:</span> deploying_assets
        </div>
        <div class="px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-sm font-mono">
            <span class="text-blue-400">location:</span> Santiago, CL 
        </div>
    </div>
</section>
@endsection