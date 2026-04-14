<nav class="border-b border-white/5 bg-[#020617]/80 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        
{{-- Identidad de Marca: Logo + Textos --}}
<a href="/" class="font-mono tracking-tight group flex items-center gap-3 w-auto">
    {{-- Carga del Logo con animación de neón permanente --}}
    <img src="{{ asset('assets/img/am-correo.png') }}" 
         alt="AM Logo" 
         class="h-10 w-auto animate-neon-pulse transition-all duration-300 group-hover:brightness-150">
         
    {{-- Bloque de texto opcional que ya tenías --}}
    <div class="hidden sm:flex items-center gap-2">
        <span class="text-slate-100 font-bold text-sm">ALVARADO MAZZEI</span>
        <span class="text-slate-600 font-light">/</span>
        <span class="text-cyan-500/90 uppercase text-[10px] tracking-widest font-semibold">Full Stack & SysOps</span>
        <span class="animate-pulse w-1.5 h-4 bg-cyan-500/50"></span>
    </div>
</a>
        
        {{-- Navegación --}}
        <div class="hidden md:flex space-x-8 text-[11px] font-medium items-center tracking-widest uppercase">
            <a href="/proyectos" class="text-slate-400 hover:text-cyan-400 transition-all">Proyectos</a>
            <a href="/stack" class="text-slate-400 hover:text-cyan-400 transition-all">Infraestructura</a>
            <a href="{{ route('contact.index') }}" class="px-4 py-2 border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-500/60 transition-all rounded-sm text-[11px] font-medium tracking-widest uppercase shadow-[0_0_10px_rgba(6,182,212,0.05)] hover:shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                CONTACT_SYS
            </a>
        </div>
    </div>
</nav>