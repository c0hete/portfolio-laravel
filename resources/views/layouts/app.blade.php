<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Título y descripción (cada vista puede sobreescribir con sus propias secciones) --}}
    @php
        $metaTitle = trim($__env->yieldContent('title', 'José Alvarado Mazzei — Full Stack Developer & DevSecOps'));
        $metaDescription = trim($__env->yieldContent('description', 'Desarrollador Full Stack (Laravel/PHP) en transición a DevSecOps. CI/CD con seguridad integrada, hardening de infraestructura Linux y arquitectura cloud segura. Temuco, Chile — remoto.'));
        $canonical = url()->current();
        $ogImage = asset('assets/img/am-correo.png');
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="author" content="José Alvarado Mazzei">
    {{-- En staging/local NO indexar (evita contenido duplicado y que el entorno de
         pruebas aparezca en Google). Solo producción es indexable. --}}
    @if (app()->environment('production'))
        <meta name="robots" content="index, follow, max-image-preview:large">
    @else
        <meta name="robots" content="noindex, nofollow">
    @endif
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Open Graph (LinkedIn, WhatsApp, Facebook) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="José Alvarado Mazzei">
    <meta property="og:locale" content="es_CL">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="Logo AM — José Alvarado Mazzei">

    {{-- Twitter / X Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/am-correo.png') }}?v=2">

    {{-- JSON-LD Schema.org: le dice a Google que esto es una Persona/profesional.
         Se genera con json_encode (no JSON literal) para que las claves @context/@type
         no choquen con las directivas de Blade. --}}
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'José Alvarado Mazzei',
            'url' => 'https://alvaradomazzei.cl',
            'image' => $ogImage,
            'jobTitle' => 'Full Stack Developer & DevSecOps Engineer',
            'email' => 'mailto:jose@alvaradomazzei.cl',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Temuco',
                'addressRegion' => 'La Araucanía',
                'addressCountry' => 'CL',
            ],
            'alumniOf' => [
                '@type' => 'CollegeOrUniversity',
                'name' => 'Universidad Tecnológica de Chile INACAP',
            ],
            'knowsAbout' => ['Laravel', 'PHP', 'DevSecOps', 'CI/CD', 'Docker', 'Linux', 'AWS', 'Ciberseguridad', 'PostgreSQL', 'MySQL'],
            'sameAs' => [
                'https://github.com/c0hete',
                'https://linkedin.com/in/josealvaradomazzeies',
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Analytics Umami (privacy-first, sin cookies). Solo se carga si está
         configurado el website ID en el .env — así no rompe si Umami no está arriba. --}}
    @if (config('services.umami.website_id') && config('services.umami.src'))
        <script defer src="{{ config('services.umami.src') }}"
                data-website-id="{{ config('services.umami.website_id') }}"></script>
    @endif
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