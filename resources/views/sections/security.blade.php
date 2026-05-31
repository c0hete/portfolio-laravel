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

    @php $sec = $infra ?? config('services.security_stats'); $th = $threats ?? null; @endphp

    {{-- Dos columnas en desktop para aprovechar el ancho y evitar scroll:
         izquierda = defensa perimetral; derecha = procedencia del tráfico. --}}
    <div class="grid lg:grid-cols-2 gap-8 items-start">

        {{-- ════ Columna izquierda: SONDEOS RECHAZADOS ════
             (1) EN VIVO (BlockedProbeLogger) · (2) histórico infra (cron→infra_stats)
             (3) robo de secretos (subset del histórico). --}}
        @if (($sec && ($sec['sondeos_total'] ?? 0) > 0) || ($th && $th['total'] > 0))
            <div class="relative overflow-hidden p-8 bg-red-500/[0.015] border border-red-500/15 rounded-lg h-full">
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-5 h-5 text-red-400/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        <h2 class="text-slate-100 font-semibold text-sm uppercase tracking-widest">Sondeos rechazados</h2>
                    </div>

                    {{-- Métricas: 1 col en móvil, 3 en sm; dentro de la columna queda compacto --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @if ($th && $th['total'] > 0)
                            <div>
                                <div class="flex items-baseline gap-2">
                                    <p class="font-mono text-3xl md:text-4xl font-bold text-red-400/90 tracking-tight">{{ number_format($th['total']) }}</p>
                                    <span class="relative flex h-2 w-2 mb-1">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                </div>
                                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">ataques rechazados <span class="text-red-400/60">· en vivo</span></p>
                            </div>
                        @endif

                        @if ($sec && ($sec['sondeos_total'] ?? 0) > 0)
                            <div>
                                <p class="font-mono text-3xl md:text-4xl font-bold text-slate-100 tracking-tight">{{ number_format($sec['sondeos_total']) }}</p>
                                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">a la infraestructura <span class="text-slate-600">· snapshot {{ $sec['snapshot'] }}</span></p>
                            </div>
                            <div>
                                <p class="font-mono text-3xl md:text-4xl font-bold text-red-400/80 tracking-tight">{{ number_format($sec['intentos_secretos']) }}</p>
                                <p class="font-mono text-[10px] text-slate-500 uppercase tracking-widest mt-2">intentos de robo bloqueados (<span class="text-red-400/60">.env</span> · <span class="text-red-400/60">.git</span>)</p>
                            </div>
                        @endif
                    </div>

                    @if ($th && ! empty($th['top']))
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

                    @php $desdeTxt = ($th && $th['desde']) ? ' · en vivo desde '.$th['desde'] : ''; @endphp
                    <p class="font-mono text-[9px] text-slate-600 uppercase tracking-widest mt-8 leading-relaxed">
                        // todos rechazados · ningún acceso comprometido{{ $desdeTxt }}<br>
                        // defensa: NPM + block-common-exploits · middleware Laravel · secretos fuera del repo · hardening OS
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

                <p class="font-mono text-[9px] text-slate-700 uppercase tracking-widest mt-8">
                    // datos propios · Umami self-hosted · sin cookies
                </p>
            </div>
        @endif

    </div>
</section>
@endsection
