<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio — En Desarrollo</title>

    <!-- SEO básico -->
    <meta name="description" content="Portafolio profesional de José Alvarado. Sitio actualmente en desarrollo.">
    <link rel="canonical" href="https://alvaradomazzei.cl">

    <!-- Content Security Policy (válido para <meta>) -->
    <meta http-equiv="Content-Security-Policy"
          content="
            default-src 'self';
            img-src 'self' data:;
            style-src 'self' 'unsafe-inline';
            font-src 'self' data:;
            script-src 'self';
            connect-src 'self';
            base-uri 'self';
            form-action 'self';
          ">

    <!-- Privacidad -->
    <meta name="referrer" content="no-referrer">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico">

    <!-- Vite (ÚNICA forma correcta) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-200 flex items-center justify-center min-h-screen">

    <main class="text-center space-y-6 px-4">
        <h1 class="text-4xl font-bold">🚧 Sitio en desarrollo</h1>

        <p class="text-lg text-gray-400 leading-relaxed">
            Estoy construyendo mi nuevo portafolio profesional.<br>
            Muy pronto estará disponible.
        </p>

        <div class="mt-6">
            <a href="mailto:jose@alvaradomazzei.cl"
               class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold transition">
                Contactarme
            </a>
        </div>
    </main>

</body>
</html>
