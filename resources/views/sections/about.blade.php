@extends('layouts.app')

@section('title', 'Sobre mí — José Alvarado Mazzei')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-16 md:py-24">

    {{-- ========================= PERFIL ========================= --}}
    <header class="mb-20">
        <div class="flex items-center gap-4 mb-6">
            <span class="font-mono text-cyan-500/50 text-xs">//</span>
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">
                José <span class="text-cyan-400">Alvarado Mazzei</span>
            </h1>
        </div>
        <p class="font-mono text-[11px] text-slate-500 uppercase tracking-[0.25em] mb-10">
            Full Stack Developer & Infrastructure Engineer · Temuco, CL · Remote
        </p>
        <p class="max-w-3xl text-lg text-slate-300 leading-relaxed font-light">
            Desarrollador Full Stack con <span class="text-slate-100 font-normal">3+ años</span> en el
            ecosistema <span class="text-slate-100 font-normal">Laravel/PHP</span>, en transición hacia
            <span class="text-slate-100 font-normal">DevSecOps</span>. Combino desarrollo de software con
            administración de infraestructura Linux en producción y prácticas de seguridad aplicada:
            CI/CD con SCA y secret scanning, hardening, análisis de vulnerabilidades y arquitectura cloud segura.
        </p>
        <p class="max-w-3xl text-base text-slate-400 leading-relaxed mt-5 font-light">
            Soy responsable único del ciclo completo de la infraestructura de mi empresa actual —diseño, despliegue,
            seguridad y operación— y mantengo proyectos públicos verificables que demuestran la integración de
            seguridad en todo el SDLC.
        </p>

        {{-- Acciones rápidas --}}
        <div class="flex flex-wrap items-center gap-4 mt-10">
            <a href="{{ asset('cv/CV-Jose-Alvarado-Mazzei.pdf') }}" target="_blank" rel="noopener noreferrer"
               class="group flex items-center gap-3 font-mono text-[12px] tracking-widest text-cyan-400 uppercase px-6 py-3 border border-cyan-500/30 hover:border-cyan-500/60 hover:bg-cyan-500/10 transition-all rounded-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Descargar CV
            </a>
            <a href="{{ route('contact.index') }}"
               class="font-mono text-[12px] tracking-widest text-slate-400 uppercase px-6 py-3 border border-white/10 hover:border-white/30 hover:text-slate-200 transition-all rounded-sm">
                Contactar
            </a>
        </div>
    </header>

    {{-- ========================= EXPERIENCIA ========================= --}}
    <div class="mb-20">
        <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-10">
            <span class="font-mono text-cyan-500/50 text-xs">01</span>
            <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Experiencia</h2>
        </div>

        <div class="space-y-12">
            {{-- Energiza — Tech Lead --}}
            <div class="relative pl-8 border-l border-white/10">
                <span class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-cyan-500 ring-4 ring-cyan-500/10"></span>
                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-3">
                    <h3 class="text-lg text-white font-semibold">Encargado de Área Informática / Tech Lead</h3>
                    <span class="font-mono text-[10px] text-slate-500 uppercase tracking-widest whitespace-nowrap">Ene 2025 — Presente</span>
                </div>
                <p class="font-mono text-[11px] text-cyan-500/60 uppercase tracking-widest mb-4">Energiza SpA · Remoto</p>
                <ul class="space-y-2 text-sm text-slate-400 leading-relaxed font-light max-w-3xl">
                    <li>· Responsable único de la infraestructura y continuidad operativa: <span class="text-slate-300">8 VPS en 3 regiones</span> (~40 vCPU, ~106 GB RAM, ~3.4 TB).</li>
                    <li>· Implementé análisis de vulnerabilidades con OpenVAS/Greenbone: <span class="text-slate-300">0 hallazgos Critical/High/Medium/Low</span> en el host principal.</li>
                    <li>· Hardening del SDLC: security headers (HSTS/CSP), gestión de secretos, hash SHA-256, RBAC, fail2ban, firewall.</li>
                    <li>· Lideré la certificación del sistema Vanadio ante la Dirección del Trabajo (Resolución 38 Exenta).</li>
                    <li>· Respaldos en 3 capas con cifrado GPG AES-256; <span class="text-slate-300">60+ días de uptime</span> continuo.</li>
                </ul>
            </div>

            {{-- Energiza — Full Stack --}}
            <div class="relative pl-8 border-l border-white/10">
                <span class="absolute -left-[5px] top-1.5 h-2.5 w-2.5 rounded-full bg-slate-600 ring-4 ring-white/5"></span>
                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1 mb-3">
                    <h3 class="text-lg text-white font-semibold">Desarrollador Full Stack</h3>
                    <span class="font-mono text-[10px] text-slate-500 uppercase tracking-widest whitespace-nowrap">Ene 2023 — Ene 2025</span>
                </div>
                <p class="font-mono text-[11px] text-cyan-500/60 uppercase tracking-widest mb-4">Energiza SpA · Remoto</p>
                <ul class="space-y-2 text-sm text-slate-400 leading-relaxed font-light max-w-3xl">
                    <li>· Aplicaciones empresariales en Laravel: control de asistencia, permisos, RBAC y reportería.</li>
                    <li>· APIs REST para sincronización de dispositivos biométricos; integración de lectores HID DigitalPersona vía SDK en C# .NET.</li>
                    <li>· Dashboards administrativos multi-empresa y despliegue en infraestructura Linux/cloud.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ========================= EDUCACIÓN ========================= --}}
    <div class="mb-20">
        <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-10">
            <span class="font-mono text-cyan-500/50 text-xs">02</span>
            <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Educación</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="p-6 bg-slate-900/40 border border-slate-800 rounded-lg">
                <p class="font-mono text-[10px] text-cyan-500/60 uppercase tracking-widest mb-2">En curso · 2026</p>
                <h3 class="text-slate-100 font-semibold mb-1">Ingeniería en Ciberseguridad</h3>
                <p class="text-slate-500 text-sm">INACAP — alumno regular</p>
            </div>
            <div class="p-6 bg-slate-900/40 border border-slate-800 rounded-lg">
                <p class="font-mono text-[10px] text-cyan-500/60 uppercase tracking-widest mb-2">Titulado · Ene 2026</p>
                <h3 class="text-slate-100 font-semibold mb-1">Técnico de Nivel Superior — Analista Programador</h3>
                <p class="text-slate-500 text-sm">INACAP — Ranking 4° de 71 · Nota 6.4/7.0</p>
            </div>
        </div>
    </div>

    {{-- ========================= CERTIFICACIONES ========================= --}}
    <div class="mb-20">
        <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-10">
            <span class="font-mono text-cyan-500/50 text-xs">03</span>
            <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Certificaciones</h2>
        </div>
        <div class="grid sm:grid-cols-2 gap-x-12 gap-y-4 max-w-4xl">
            @foreach ([
                ['Claude Code in Action', 'Anthropic · 2025'],
                ['AI Fluency: Framework & Foundations', 'Anthropic · 2025'],
                ['Infraestructura TI Segura (144h)', 'INACAP · 2026'],
                ['Desarrollador Full Stack (144h)', 'INACAP · 2026'],
                ['Desarrollo de Aplicaciones Iniciales (162h)', 'INACAP · 2026'],
                ['EF SET — Inglés Nivel C2', '2022'],
            ] as [$cert, $issuer])
                <div class="flex items-start gap-3 py-2 border-b border-white/[0.03]">
                    <span class="text-cyan-500/40 font-mono text-xs mt-0.5">▹</span>
                    <div>
                        <p class="text-slate-200 text-sm font-medium leading-snug">{{ $cert }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-0.5">{{ $issuer }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ========================= CTA CONTRATACIÓN ========================= --}}
    <div class="p-8 md:p-10 bg-cyan-500/[0.02] border border-cyan-500/15 rounded-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </span>
                <span class="font-mono text-[11px] text-cyan-400 uppercase tracking-[0.2em]">Disponible para nuevos proyectos</span>
            </div>
            <p class="text-slate-400 text-sm leading-relaxed max-w-xl">
                Busco roles remotos en <span class="text-slate-200">Full Stack (Laravel/PHP)</span>,
                <span class="text-slate-200">DevOps/DevSecOps</span> o <span class="text-slate-200">Backend</span>.
                Chile, LATAM o contractor internacional.
            </p>
        </div>
        <a href="{{ route('contact.index') }}"
           class="shrink-0 group flex items-center gap-3 font-mono text-[12px] tracking-widest text-cyan-400 uppercase px-6 py-3 border border-cyan-500/40 hover:bg-cyan-500/10 hover:border-cyan-500 transition-all rounded-sm">
            Hablemos
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

</section>
@endsection
