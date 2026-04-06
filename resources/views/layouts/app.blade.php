<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'José Alvarado — Backend & Infra')</title>

    <meta name="description" content="Portafolio profesional de José Alvarado Mazzei, Senior PHP Developer e Ingeniero en Ciberseguridad[cite: 1, 2, 61, 62].">
    <link rel="canonical" href="https://alvaradomazzei.cl">
    <meta name="referrer" content="no-referrer">
    
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; font-src 'self' data:; script-src 'self'; connect-src 'self'; base-uri 'self'; form-action 'self';">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-200 selection:bg-blue-500/30">

    <nav class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <span class="font-mono text-blue-400 group">
                <span class="text-slate-500">&lt;</span>alvarado-mazzei<span class="text-slate-500">/&gt;</span>
            </span>
            <div class="space-x-6 text-sm font-medium">
                <a href="#" class="hover:text-blue-400 transition">Proyectos</a>
                <a href="#" class="hover:text-blue-400 transition">Stack</a>
                <a href="mailto:jose@alvaradomazzei.cl" class="px-4 py-2 bg-blue-600 rounded-md hover:bg-blue-700 transition">Contacto</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

<footer class="py-8 text-center text-slate-500 text-xs">
    © 2026 — Diseñado con Laravel & Docker bajo estándares de Ciberseguridad.
</footer>

</body>
</html>