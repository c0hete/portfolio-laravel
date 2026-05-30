<footer class="mt-20 py-16 border-t border-white/5 bg-[#010309]">
    {{-- Cambiamos a max-w-6xl para acercar los elementos --}}
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-start gap-12">
        
        {{-- Bloque de Identidad --}}
        <div class="space-y-4 md:max-w-sm">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/img/am-correo.png') }}" 
                     alt="AM Logo" 
                     class="h-10 w-auto opacity-50 hover:opacity-100 transition-all duration-300">
                <div class="flex flex-col">
                    {{-- Aumentamos el nombre a text-lg --}}
                    <p class="text-slate-200 font-bold text-lg tracking-tight">ALVARADO MAZZEI</p>
                    <p class="text-slate-500 font-mono text-[11px] uppercase tracking-widest">Full Stack & SysOps</p>
                </div>
            </div>
            
            {{-- Aumentamos la descripción a text-xs (12px) y mejoramos el color a slate-400 para lectura --}}
            <p class="text-slate-400 text-xs leading-relaxed pt-2">
                Arquitectura de sistemas escalables y despliegue de infraestructura crítica. 
                Enfoque en ciberseguridad y optimización de entornos distribuidos.
            </p>
        </div>
        
{{-- Enlaces de contacto y redes (lo que busca un reclutador) --}}
        <div class="flex flex-col gap-5">
            <span class="font-mono text-[10px] text-slate-600 uppercase tracking-[0.2em]">Enlaces directos</span>
            <div class="flex flex-col gap-3 text-sm">
                <a href="https://github.com/c0hete" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 text-slate-400 hover:text-cyan-400 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.305-5.467-1.334-5.467-5.931 0-1.31.465-2.38 1.235-3.221-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.841 1.23 1.911 1.23 3.221 0 4.609-2.807 5.624-5.479 5.921.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    github.com/c0hete
                </a>
                <a href="https://linkedin.com/in/josealvaradomazzeies" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 text-slate-400 hover:text-cyan-400 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    LinkedIn
                </a>
                <a href="mailto:jose@alvaradomazzei.cl" class="group flex items-center gap-3 text-slate-400 hover:text-cyan-400 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    jose@alvaradomazzei.cl
                </a>
                <a href="{{ asset('cv/CV-Jose-Alvarado-Mazzei.pdf') }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 text-cyan-400/90 hover:text-cyan-300 transition-colors font-medium">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Descargar CV (PDF)
                </a>
            </div>
        </div>
    
    {{-- Línea de Copyright Personalizada --}}
    <div class="max-w-6xl mx-auto px-6 mt-12 pt-8 border-t border-white/[0.02] flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] text-slate-600 uppercase tracking-[0.2em] font-mono">
        <span>© 2026 ALVARADO MAZZEI — SYS_CORE V2</span>
        <span class="text-slate-700">Engineered in Temuco | Built with Laravel</span>
    </div>
</footer>