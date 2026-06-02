@extends('layouts.app')

@section('title', 'Seguridad Perimetral — José Alvarado Mazzei')
@section('description', 'Telemetría de seguridad en vivo: ataques maliciosos detectados y rechazados en este nodo (sondeos a .env/.git, paneles, exploits), histórico de la infraestructura y procedencia del tráfico. DevSecOps en producción.')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-16">

    <header class="mb-12">
        <div class="flex items-center gap-4 mb-4">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Seguridad <span class="text-red-400">Perimetral</span></h1>
            <span class="h-px flex-1 bg-gradient-to-r from-red-500/20 to-transparent"></span>
        </div>
        <p class="text-slate-500 font-mono text-xs uppercase tracking-[0.3em]">
            Defensa activa · Telemetría en tiempo real.
        </p>
    </header>

    @php $th = $threats ?? null; @endphp

    {{-- Dos columnas en desktop para aprovechar el ancho y evitar scroll:
         izquierda = defensa perimetral; derecha = procedencia del tráfico. --}}
    <div class="grid lg:grid-cols-2 gap-8 items-start">

        {{-- ════ Columna izquierda: SONDEOS RECHAZADOS (EN VIVO · este dominio) ════
             TODO de una sola fuente ($th = ThreatStats::stats, BlockedProbeLogger):
             total + secretos (subset 'secret') + rutas top — misma ventana, mismos
             números (los secretos cuadran con las rutas .env/.git de abajo). --}}
        @if ($th && $th['total'] > 0)
            <div class="relative overflow-hidden p-8 bg-red-500/[0.015] border border-red-500/15 rounded-lg h-full">
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-red-400/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        <h2 class="text-slate-100 font-semibold text-sm uppercase tracking-widest">Sondeos rechazados</h2>
                        {{-- Botón actualizar (el contador en vivo lee la DB propia) --}}
                        <button type="button" data-refresh="ataques" title="Actualizar ahora"
                                class="ml-auto flex items-center gap-1.5 font-mono text-[9px] text-slate-500 hover:text-red-400/80 uppercase tracking-widest transition-colors">
                            <svg data-refresh-icon class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                            ↻
                        </button>
                    </div>
                    {{-- Ventana temporal EXPLÍCITA: todo lo de esta tarjeta comparte esta fuente y ventana --}}
                    <p class="font-mono text-[10px] text-slate-600 uppercase tracking-widest mb-8">
                        // este dominio · en vivo{{ ($th['desde']) ? ' desde '.$th['desde'] : '' }}
                    </p>

                    {{-- Métricas: total y robo de secretos — AMBAS del mismo live, coherentes entre sí --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <div class="flex items-baseline gap-2">
                                <p data-ataques-total class="font-mono text-3xl md:text-4xl font-bold text-red-400/90 tracking-tight">{{ number_format($th['total']) }}</p>
                                <span class="relative flex h-2 w-2 mb-1">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                            </div>
                            <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">ataques rechazados</p>
                            <p data-ataques-stamp class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-1">// actualiza cada {{ \App\Services\ThreatStats::REFRESH_SECONDS }}s</p>
                        </div>

                        @if ($th['secretos'] > 0)
                            <div>
                                <p data-ataques-secretos class="font-mono text-3xl md:text-4xl font-bold text-red-400/80 tracking-tight">{{ number_format($th['secretos']) }}</p>
                                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">intentos de robo de secretos (<span class="text-red-400/60">.env</span> · <span class="text-red-400/60">.git</span> · …)</p>
                            </div>
                        @endif
                    </div>

                    @if (! empty($th['top']))
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

                    <p class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8 leading-relaxed">
                        // todos rechazados · ningún acceso comprometido<br>
                        // defensa: reverse proxy + block-common-exploits · middleware Laravel · secretos fuera del repo · hardening OS
                    </p>
                </div>
            </div>
        @endif

        {{-- ════ Columna derecha: TELEMETRÍA DEL NODO (procedencia del tráfico) ════ --}}
        @if (! empty($countries))
            @php $maxCount = max(array_column($countries, 'count')) ?: 1; @endphp
            <div class="p-8 border border-white/5 rounded-lg h-full">
                <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">Telemetría del nodo</h2>
                    <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest hidden sm:inline">// visitas · 90 días</span>
                    <button type="button" data-refresh="paises" title="Actualizar ahora"
                            class="ml-auto flex items-center gap-1.5 font-mono text-[9px] text-slate-500 hover:text-cyan-400 uppercase tracking-widest transition-colors">
                        <svg data-refresh-icon class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                        ↻
                    </button>
                </div>

                <div class="grid gap-y-3">
                    @foreach (array_slice($countries, 0, 10) as $c)
                        @php
                            $cc = strtolower($c['code']);
                            // Bandera SVG servida desde el propio sitio (self → no toca CSP).
                            // Fallback al chip con el código ISO si falta el SVG.
                            $hasFlag = is_file(public_path("assets/flags/{$cc}.svg"));
                        @endphp
                        <div class="flex items-center gap-4">
                            @if ($hasFlag)
                                <img src="{{ asset("assets/flags/{$cc}.svg") }}" alt="{{ $c['code'] }}"
                                     width="24" height="18" loading="lazy"
                                     class="w-6 h-[18px] shrink-0 rounded-[2px] ring-1 ring-white/10 object-cover">
                            @else
                                <span class="font-mono text-[11px] font-semibold text-cyan-300/90 shrink-0 w-9 text-center px-1.5 py-1 bg-cyan-500/5 border border-cyan-500/20 rounded">{{ $c['code'] }}</span>
                            @endif
                            <span class="font-mono text-[10px] text-slate-500 w-6 shrink-0">{{ $c['code'] }}</span>
                            <div class="flex-1 h-1.5 bg-slate-800/60 rounded-full overflow-hidden">
                                <div class="h-full bg-cyan-500/60 rounded-full" style="width: {{ max(4, round($c['count'] / $maxCount * 100)) }}%"></div>
                            </div>
                            <span class="font-mono text-[11px] text-cyan-400/70 w-8 text-right shrink-0">{{ $c['count'] }}</span>
                        </div>
                    @endforeach
                </div>

                <p data-paises-stamp class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8">// actualiza cada {{ \App\Services\UmamiStats::REFRESH_MINUTES }} min</p>
                <p class="font-mono text-[9px] text-slate-700 uppercase tracking-widest mt-1">
                    // datos propios · Umami self-hosted · sin cookies
                </p>
            </div>
        @endif

    </div>

    {{-- Nota: la tarjeta "snapshot de infraestructura" (ThreatStats::infra) se retiró
         el 2026-06-01. Contaba las líneas del log actual de NPM (fallback_http_access
         + .gz), que se rota y purga → el número BAJABA entre corridas (ej. 8.776 →
         2.907), dañando la credibilidad. El live de este dominio (threat_probes) y las
         IPs baneadas (banned_ips, upsert por hash) SÍ son acumulativos y confiables.
         Para reintroducirla habría que hacer el cron acumulativo (sumar deltas en DB sin
         recontar el log). Ver deploy/contar-sondeos-infra.sh. --}}

    {{-- ════ IPs baneadas por fail2ban (historial geolocalizado) ════
         Alimentado por el cron registrar-baneos.sh → tabla banned_ips.
         IP enmascarada (no se guarda completa). Solo aparece si hay datos. --}}
    @if (! empty($banned) && $banned['total'] > 0)
        <div class="mt-8 p-8 border border-white/5 rounded-lg">
            <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-8">
                <svg class="w-5 h-5 text-red-400/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                <h2 class="text-slate-200 font-semibold text-sm uppercase tracking-widest">IPs bloqueadas</h2>
                <span class="font-mono text-[10px] text-slate-600 uppercase tracking-widest hidden sm:inline">// fail2ban · jail sshd</span>
                <button type="button" data-refresh="baneos" title="Actualizar ahora"
                        class="ml-auto flex items-center gap-1.5 font-mono text-[9px] text-slate-500 hover:text-red-400/80 uppercase tracking-widest transition-colors">
                    <svg data-refresh-icon class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    ↻
                </button>
            </div>

            {{-- Resumen --}}
            <div class="flex flex-wrap gap-x-12 gap-y-4 mb-8">
                <div>
                    <p data-baneos-total class="font-mono text-3xl md:text-4xl font-bold text-red-400/90 tracking-tight">{{ number_format($banned['total']) }}</p>
                    <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">IPs bloqueadas</p>
                </div>
                @if ($banned['paises'] > 0)
                    <div>
                        <p class="font-mono text-3xl md:text-4xl font-bold text-slate-100 tracking-tight">{{ number_format($banned['paises']) }}</p>
                        <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">países de origen</p>
                    </div>
                @endif
            </div>

            {{-- Lista de IPs recientes con bandera --}}
            <div class="grid sm:grid-cols-2 gap-x-12 gap-y-2.5">
                @foreach ($banned['recientes'] as $b)
                    @php
                        $cc = strtolower($b['country'] ?? '');
                        $hasFlag = $cc && is_file(public_path("assets/flags/{$cc}.svg"));
                    @endphp
                    <div class="flex items-center gap-3 font-mono text-[11px]">
                        @if ($hasFlag)
                            <img src="{{ asset("assets/flags/{$cc}.svg") }}" alt="{{ strtoupper($cc) }}"
                                 width="20" height="15" loading="lazy"
                                 class="w-5 h-[15px] shrink-0 rounded-[2px] ring-1 ring-white/10 object-cover">
                        @else
                            <span class="w-5 h-[15px] shrink-0 rounded-[2px] bg-slate-800 flex items-center justify-center text-[7px] text-slate-500">{{ strtoupper($cc) ?: '??' }}</span>
                        @endif
                        <span class="text-slate-300 flex-1">{{ $b['ip'] }}</span>
                        @if ($b['hits'] > 1)
                            <span class="text-slate-600">×{{ $b['hits'] }}</span>
                        @endif
                        <span class="text-red-400/50 uppercase tracking-widest text-[9px]">bloqueada</span>
                    </div>
                @endforeach
            </div>

            <p data-baneos-stamp class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8">// actualiza cada {{ \App\Services\BannedIps::REFRESH_MINUTES }} min</p>
            <p class="font-mono text-[9px] text-slate-700 uppercase tracking-widest mt-1">
                // fuerza bruta SSH detectada y bloqueada · IP enmascarada · geolocalización self-hosted
            </p>
        </div>
    @endif

</section>
@endsection
