@props(['project'])

@php
    $isEmerald = str_contains(strtolower($project->category), 'biometría');
    $accentColor = $isEmerald ? 'emerald' : 'blue';
@endphp

<article class="group relative bg-slate-900/40 border border-slate-800 p-8 rounded-2xl hover:border-{{ $accentColor }}-500/30 transition-all duration-500 shadow-2xl flex flex-col h-full overflow-hidden">
    
    {{-- Resplandor de fondo --}}
    <div class="absolute -right-16 -top-16 w-48 h-48 bg-{{ $accentColor }}-500/10 blur-[100px] group-hover:bg-{{ $accentColor }}-500/20 transition-all duration-700 pointer-events-none"></div>

    {{-- CABECERA: Logo con Redirección Integrada --}}
    <div class="relative z-20 flex justify-between items-start mb-6">
        
        {{-- CONTENEDOR DE LOGO + LINK --}}
        @if($project->url)
            <a href="{{ $project->url }}" target="_blank" class="relative group/logo block">
                <div class="w-32 h-20 flex items-center justify-start transition-all duration-500 group-hover/logo:scale-105">
                    @if($project->logo)
                        <img src="{{ asset($project->logo) }}" 
                             alt="{{ $project->title }} Logo" 
                             class="max-w-full max-h-full object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.05)]">
                    @else
                         {{-- Icono genérico si no hay logo --}}
                         <div class="w-16 h-16 flex items-center justify-center bg-{{ $accentColor }}-500/10 rounded-2xl border border-{{ $accentColor }}-500/20 text-{{ $accentColor }}-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                         </div>
                    @endif

                    {{-- Mini Badge de Redirección sobre el logo --}}
                    <div class="absolute -right-2 -bottom-1 p-1.5 bg-slate-950 border border-slate-800 rounded-lg text-slate-500 group-hover/logo:text-{{ $accentColor }}-400 group-hover/logo:border-{{ $accentColor }}-500/50 transition-all shadow-xl opacity-0 group-hover/logo:opacity-100 transform translate-y-2 group-hover/logo:translate-y-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </div>
                </div>
            </a>
        @else
            {{-- Logo estático si no hay URL --}}
            <div class="w-32 h-20 flex items-center justify-start opacity-50">
                <img src="{{ asset($project->logo) }}" class="max-w-full max-h-full object-contain grayscale">
            </div>
        @endif

        {{-- Tag de Categoría --}}
        <div class="flex flex-col items-end">
            <span class="text-[9px] font-mono py-1 px-3 bg-slate-950 text-{{ $accentColor }}-400 rounded-full border border-{{ $accentColor }}-500/20 uppercase tracking-widest shadow-lg">
                {{ $project->category }}
            </span>
        </div>
    </div>
    
    {{-- CUERPO: Título y Rol --}}
    <div class="relative z-10 mb-4">
        <h2 class="text-2xl font-black text-white group-hover:text-{{ $accentColor }}-400 transition-colors uppercase tracking-tight leading-tight">
            {{ $project->title }}
        </h2>
        <div class="flex items-center gap-2 mt-1">
            <span class="w-6 h-[1px] bg-{{ $accentColor }}-500/50"></span>
            <p class="text-slate-400 text-[10px] font-mono font-bold uppercase tracking-[0.2em]">
                {{ $project->role }}
            </p>
        </div>
    </div>

    {{-- DESCRIPCIÓN --}}
    <p class="relative z-10 text-slate-400 text-sm mb-8 leading-relaxed font-light">
        {{ $project->description }}
    </p>
    
    {{-- FOOTER: Tecnologías --}}
    <div class="relative z-10 flex flex-wrap gap-2 mt-auto">
        @foreach($project->stack as $tech)
            <span class="text-[8px] font-bold px-2 py-1 bg-slate-950 border border-slate-800 rounded text-slate-500 uppercase tracking-tighter">
                {{ $tech }}
            </span>
        @endforeach
    </div>
</article>