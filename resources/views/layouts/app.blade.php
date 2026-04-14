<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Título de la pestaña --}}
    <title>@yield('title', 'Alvarado Mazzei — Full Stack & Infrastructure Engineer')</title>

    {{-- Meta tags para Redes Sociales (WhatsApp, LinkedIn, Twitter) --}}
    <meta property="og:title" content="Alvarado Mazzei — Full Stack & Infrastructure Engineer">
    <meta name="description" content="Especialista en Laravel y Linux Ops enfocado en infraestructuras críticas y sistemas distribuidos.">
    <meta property="og:description" content="Especialista en Laravel y Linux Ops enfocado en infraestructuras críticas y sistemas distribuidos.">
    <meta property="og:url" content="https://alvaradomazzei.cl/">
    <meta property="og:type" content="website">
    
    {{-- Opcional: Si tienes una imagen para el preview (puedes usar tu logo AM) --}}
    <meta property="og:image" content="{{ asset('assets/img/am-correo.png') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/am-correo.png') }}?v=2">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#020617] text-slate-400 font-sans antialiased overflow-x-hidden">

    {{-- CAPA DE FONDO --}}
    <div class="fixed inset-0 -z-10 h-full w-full bg-[#020617]">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-20"></div>
    </div>

    <x-navbar />

    <main class="min-h-screen relative pt-8">
        @yield('content')
    </main>

    <x-footer />
</body>
</html>