@extends('layouts.app')

@section('title', 'Stack Tecnológico — Infraestructura & Core')

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
                    Despliegue de nodos críticos, administración de VPNs corporativas (Wireguard) y fortificación de servicios bajo estándares de seguridad ofensiva.
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

</section>
@endsection