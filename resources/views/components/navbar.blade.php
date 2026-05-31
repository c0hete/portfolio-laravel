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
        <div class="hidden md:flex space-x-7 text-[11px] font-medium items-center tracking-widest uppercase">
            <a href="/sobre-mi" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('sobre-mi*') ? 'text-cyan-400' : '' }}">Sobre mí</a>
            <a href="/proyectos" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('proyectos*') ? 'text-cyan-400' : '' }}">Proyectos</a>
            <a href="/seguridad" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('seguridad*') ? 'text-cyan-400' : '' }}">Seguridad</a>
            <a href="/stack" class="text-slate-400 hover:text-cyan-400 transition-all {{ request()->is('stack*') ? 'text-cyan-400' : '' }}">Stack</a>

            {{-- Links externos (íconos) --}}
            <span class="h-4 w-px bg-white/10"></span>
            <a href="https://github.com/c0hete" target="_blank" rel="noopener noreferrer" aria-label="GitHub" data-umami-event="github_nav" class="text-slate-500 hover:text-cyan-400 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.305-5.467-1.334-5.467-5.931 0-1.31.465-2.38 1.235-3.221-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.841 1.23 1.911 1.23 3.221 0 4.609-2.807 5.624-5.479 5.921.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
            </a>
            <a href="https://linkedin.com/in/josealvaradomazzeies" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" data-umami-event="linkedin_nav" class="text-slate-500 hover:text-cyan-400 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>

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

    <a href="/sobre-mi" class="flex flex-col items-center gap-1 {{ request()->is('sobre-mi*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Sobre mí</span>
    </a>

    <a href="/proyectos" class="flex flex-col items-center gap-1 {{ request()->is('proyectos*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Projects</span>
    </a>

    <a href="/seguridad" class="flex flex-col items-center gap-1 {{ request()->is('seguridad*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Seguridad</span>
    </a>

    <a href="/stack" class="flex flex-col items-center gap-1 {{ request()->is('stack*') ? 'text-cyan-400' : 'text-slate-500' }}">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
        </svg>
        <span class="text-[9px] font-mono uppercase tracking-widest">Stack</span>
    </a>
</div>