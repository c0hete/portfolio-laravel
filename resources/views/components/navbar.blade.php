<nav class="border-b border-white/5 bg-[#020617]/80 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
        
        {{-- Identidad de Marca --}}
        <a href="/" class="font-mono tracking-tight group flex items-center gap-3 w-auto">
            <img src="{{ asset('assets/img/am-correo.png') }}" 
                 alt="AM Logo" 
                 class="h-9 md:h-10 w-auto animate-neon-pulse transition-all duration-300 group-hover:opacity-100 group-hover:brightness-125 group-hover:drop-shadow-[0_0_10px_rgba(6,182,212,0.6)]">
                 
            {{-- Textos (Se ocultan en móviles muy pequeños para dar espacio) --}}
            <div class="hidden xs:flex items-center gap-2">
                <span class="text-slate-100 font-bold text-sm">ALVARADO MAZZEI</span>
                <span class="text-slate-600 font-light">/</span>
                <span class="text-cyan-500/90 uppercase text-[10px] tracking-widest font-semibold">SysOps</span>
                <span class="animate-pulse w-1.5 h-4 bg-cyan-500/50"></span>
            </div>
        </a>
        
        {{-- Navegación Escritorio (Se oculta en móvil) --}}
        <div class="hidden md:flex space-x-8 text-[11px] font-medium items-center tracking-widest uppercase">
            <a href="/proyectos" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('proyectos*') ? 'text-cyan-400' : '' }}">Proyectos</a>
            <a href="/stack" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('stack*') ? 'text-cyan-400' : '' }}">Infraestructura</a>
            <a href="{{ route('contact.index') }}" class="px-4 py-2 border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-500/60 transition-all rounded-sm">
                CONTACT_SYS
            </a>
        </div>

        {{-- Botón Contacto Móvil (Solo icono para ahorrar espacio arriba) --}}
        {{-- Botón Contacto Móvil (CORREGIDO) --}}
        <div class="flex md:hidden items-center justify-center">
            <a href="{{ route('contact.index') }}" 
               class="group p-2.5 border border-cyan-500/20 bg-cyan-500/5 rounded-sm 
                      hover:border-cyan-500/50 hover:bg-cyan-500/10 transition-all duration-300
                      flex items-center justify-center w-10 h-10 aspect-square">
                
                {{-- Icono de Mail con viewBox y tamaño forzado --}}
                <svg class="w-5 h-5 text-cyan-500 transition-transform group-hover:scale-110" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke="currentColor" 
                     stroke-width="1.5">
                    <path stroke-linecap="round" 
                          stroke-linejoin="round" 
                          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
            </a>
        </div>
    </div>
</nav>

{{-- BARRA INFERIOR MÓVIL (Tab Bar) --}}
<div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-[#020617]/95 backdrop-blur-lg border-t border-white/10 py-3 px-8 flex justify-around items-center shadow-[0_-10px_25px_rgba(0,0,0,0.5)]">
    
    <a href="/" class="flex flex-col items-center gap-1 {{ request()->is('/') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Home</span>
    </a>

    <a href="/proyectos" class="flex flex-col items-center gap-1 {{ request()->is('proyectos*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Projects</span>
    </a>

    <a href="/stack" class="flex flex-col items-center gap-1 {{ request()->is('stack*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Stack</span>
    </a>
</div>