@extends('layouts.app')

@section('title', 'Stack Tecnológico — Infraestructura & Core')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-16">
    
    {{-- Header: Definición del Ecosistema --}}
    <header class="mb-20">
        <div class="flex items-center gap-4 mb-4">
            <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Technical <span class="text-cyan-400">Stack</span></h2>
            <span class="h-px flex-1 bg-gradient-to-r from-cyan-500/20 to-transparent"></span>
        </div>
        <p class="text-slate-500 font-mono text-xs uppercase tracking-[0.3em]">
            Layered infrastructure & distributed development ecosystem.
        </p>
    </header>

    <div class="grid md:grid-cols-2 gap-x-16 gap-y-12">
        
        {{-- Bloque 01: Core Development --}}
        <div class="space-y-8">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                <span class="font-mono text-cyan-500/50 text-xs">01</span>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Backend & Data Core</h3>
            </div>
            
            <div class="grid gap-6">
                <x-stack-icon name="PHP 8.2 / Laravel" level="production_ready" color="cyan" />
                <x-stack-icon name="PostgreSQL (JSONB & Indexing)" level="high_concurrency" color="cyan" />
                <x-stack-icon name="Redis / In-Memory Cache" level="optimized" color="cyan" />
            </div>
        </div>

        {{-- Bloque 02: Infrastructure & Ops --}}
        <div class="space-y-8">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4">
                <span class="font-mono text-cyan-500/50 text-xs">02</span>
                <h3 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">DevOps & Cybersec</h3>
            </div>
            
            <div class="grid gap-6">
                <x-stack-icon name="Docker / Containerization" level="orchestrated" color="cyan" />
                <x-stack-icon name="Nginx Proxy Manager" level="edge_security" color="cyan" />
                <x-stack-icon name="Linux Hardening (Fail2ban)" level="hardened" color="cyan" />
            </div>
        </div>

    </div>

    {{-- Footer Técnico: Auditoría de Entorno --}}
    <div class="mt-24 p-6 bg-cyan-500/[0.02] border border-cyan-500/10 rounded-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <p class="font-mono text-[10px] text-slate-500 leading-relaxed max-w-xl">
                <span class="text-cyan-500/60 font-bold">// TECH_AUDIT:</span> 
                Este stack está optimizado para entornos de alta disponibilidad, priorizando el aislamiento de procesos mediante contenedores y la integridad de datos mediante transacciones atómicas.
            </p>
            <div class="px-3 py-1 border border-cyan-500/30 text-cyan-400 font-mono text-[9px] uppercase tracking-widest">
                verified_env
            </div>
        </div>
    </div>

</section>
@endsection