@props(['project'])

<article class="group relative flex flex-col h-full bg-[#030712]/50 border border-white/5 p-6 md:p-8 transition-all duration-300 hover:border-cyan-500/30 hover:bg-[#030712]/80">
    
    {{-- Efecto de Iluminación Sutil (Mantenemos) --}}
    <div class="absolute -right-px -top-px w-32 h-32 bg-cyan-500/5 blur-3xl group-hover:bg-cyan-500/10 transition-all duration-500 pointer-events-none"></div>

    {{-- CABECERA ADAPTATIVA: Ajuste de espaciado y alineación --}}
    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start gap-y-6 sm:gap-x-4 mb-10">
        
{{-- LOGO AREA: Color fijo en móvil, interacción hover en escritorio --}}
        <div class="h-12 md:h-16 w-full sm:w-auto flex items-center justify-start overflow-hidden">
            @if($project->logo)
                <img src="{{ asset($project->logo) }}" 
                     alt="{{ $project->title }} Logo" 
                     {{-- Clases de lógica condicional --}}
                     class="max-w-full h-12 md:h-16 w-auto object-contain transition-all duration-500
                            {{-- Estado Base (Móvil): Color total y Opacidad total --}}
                            opacity-100 grayscale-0 
                            {{-- Estado Desktop (md): Regresa a Gris y Atenuado --}}
                            md:opacity-70 md:grayscale 
                            {{-- Interacción Desktop: Se activa al pasar el mouse --}}
                            md:group-hover:opacity-100 md:group-hover:grayscale-0">
            @else
                <div class="font-mono text-xs text-slate-700 tracking-tighter uppercase italic">
                    [no_asset_found]
                </div>
            @endif
        </div>

        {{-- STATUS & CATEGORY (Mantenemos lógica adaptativa) --}}
        <div class="flex flex-col items-start sm:items-end gap-2.5">
            <span class="font-mono text-[10px] md:text-[11px] px-3 py-1 bg-cyan-500/5 text-cyan-400 border border-cyan-500/20 uppercase tracking-[0.2em] whitespace-nowrap rounded-sm">
                {{ $project->category }}
            </span>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </span>
                <span class="font-mono text-[9px] md:text-[10px] text-slate-500 uppercase tracking-widest">stable_release</span>
            </div>
        </div>
    </div>
    
    {{-- CUERPO: Título y Metadata --}}
    <div class="relative z-10 mb-5">
        <h2 class="text-2xl md:text-3xl font-bold text-slate-100 tracking-tight group-hover:text-cyan-400 transition-colors">
            {{ $project->title }}
        </h2>
        {{-- Role Line --}}
        <div class="mt-2.5 font-mono text-[10px] md:text-[11px] text-slate-500 uppercase tracking-widest flex items-center gap-2 border-b border-white/5 pb-5">
            <span class="text-cyan-500/40">ROLE::</span>
            <span class="text-slate-300 font-medium">{{ $project->role }}</span>
        </div>
    </div>

    {{-- DESCRIPCIÓN --}}
    <p class="relative z-10 text-slate-400 text-sm md:text-base leading-relaxed mb-12 font-light max-w-prose">
        {{ $project->description }}
    </p>
    
    {{-- FOOTER: Stack Tecnológico - LEGUIBILIDAD MEJORADA --}}
    {{-- Ajustamos espaciado superior y gap, y aumentamos tamaño de fuente --}}
    <div class="relative z-10 flex flex-wrap gap-x-6 gap-y-3 mt-auto pt-8 border-t border-white/5">
        @foreach($project->stack as $tech)
            {{-- Fuente aumentada de text-[9px] a text-[11px] md:text-xs --}}
            <span class="font-mono text-[11px] md:text-xs text-slate-600 hover:text-cyan-400/70 transition-colors cursor-default whitespace-nowrap">
                <span class="text-cyan-500/20">#</span>{{ strtolower($tech) }}
            </span>
        @endforeach
    </div>

    {{-- LINK ACCIÓN --}}
    @if($project->url)
        <a href="{{ $project->url }}" target="_blank" class="absolute bottom-6 right-8 text-slate-700 hover:text-cyan-400 transition-all hover:scale-110 p-2 bg-slate-950/50 rounded-full border border-white/5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
            </svg>
        </a>
    @endif
</article>