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
        <article class="group bg-slate-900/40 border border-slate-800 p-8 rounded-2xl hover:border-emerald-500/30 transition-all shadow-2xl">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-emerald-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-mono py-1 px-2 bg-slate-800 text-slate-400 rounded border border-slate-700">BIOMETRÍA & DT</span>
            </div>
            
            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors">VANADIO</h3>
            <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                Sistema de Control de Asistencia con integración de dispositivos biométricos. Cumplimiento estricto con la Dirección del Trabajo (DT) y firma digital de registros.
            </p>
            
            <div class="flex flex-wrap gap-2 mt-auto">
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">Laravel 11</span>
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">React</span>
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">PostgreSQL</span>
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">SHA-256 Hashing</span>
            </div>
        </article>

        <article class="group bg-slate-900/40 border border-slate-800 p-8 rounded-2xl hover:border-blue-500/30 transition-all shadow-2xl">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-blue-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[10px] font-mono py-1 px-2 bg-slate-800 text-slate-400 rounded border border-slate-700">SII & LOGÍSTICA</span>
            </div>
            
            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">Farmaplace</h3>
            <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                Plataforma de gestión farmacéutica con facturación electrónica integrada (SII). Control de stock inteligente por lote y gestión de recetas retenidas.
            </p>
            
            <div class="flex flex-wrap gap-2 mt-auto">
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">PHP 8.2</span>
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">API REST</span>
                <span class="text-[10px] px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-400">Facturación SII</span>
            </div>
        </article>
    </div>
</section>
@endsection