<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'José Alvarado — Backend & Infra')</title>

    <meta name="description" content="Portafolio profesional de José Alvarado Mazzei, Senior PHP Developer e Ingeniero en Ciberseguridad.">
    <link rel="canonical" href="https://alvaradomazzei.cl">
    
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; font-src 'self' data:; script-src 'self'; connect-src 'self';">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-200 selection:bg-blue-500/30 font-sans antialiased">

    <nav class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="font-mono text-blue-400 group">
                <span class="text-slate-500">&lt;</span>alvarado-mazzei<span class="text-slate-500">/&gt;</span>
            </a>
            <div class="space-x-6 text-sm font-medium flex items-center">
                <a href="/proyectos" class="hover:text-blue-400 transition">Proyectos</a>
                <a href="/stack" class="hover:text-blue-400 transition">Stack</a>
                <a href="mailto:jose@alvaradomazzei.cl" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow-lg shadow-blue-900/20">Contacto</a>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="py-12 border-t border-slate-900 text-center text-slate-500 text-xs">
        <p>© 2026 — Diseñado con Laravel & Docker bajo estándares de Ciberseguridad.</p>
        <p class="mt-2 font-mono opacity-50">Temuco, Chile</p>
    </footer>

</body>
</html>