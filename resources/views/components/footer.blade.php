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
        
        {{-- Metadata del Sistema --}}
        {{-- Aumentamos a text-xs (12px) y mejoramos los espacios (gap) --}}
        <div class="grid grid-cols-2 gap-x-16 gap-y-6 font-mono text-xs text-slate-500 uppercase tracking-tighter">
            <div class="flex flex-col text-left">
                <span class="text-slate-600 mb-1">Environment</span>
                <span class="text-slate-300">Production v2.1</span>
            </div>
            <div class="flex flex-col text-left">
                <span class="text-slate-600 mb-1">Region</span>
                <span class="text-slate-300">AM-Temuco / CL</span>
            </div>
            <div class="flex flex-col text-left">
                <span class="text-slate-600 mb-1">Stack</span>
                <span class="text-slate-300">Modern PHP 8.x / Docker</span>
            </div>
            <div class="flex flex-col text-left">
                <span class="text-slate-600 mb-1">Status</span>
                <span class="text-cyan-500/80 font-bold shadow-cyan-500/20 drop-shadow-md">System Online</span>
            </div>
        </div>
    </div>
    
    {{-- Línea de Copyright Personalizada --}}
    <div class="max-w-6xl mx-auto px-6 mt-12 pt-8 border-t border-white/[0.02] flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] text-slate-600 uppercase tracking-[0.2em] font-mono">
        <span>© 2026 ALVARADO MAZZEI — SYS_CORE V2</span>
        <span class="text-slate-700">Engineered in Temuco | Built with Laravel</span>
    </div>
</footer>