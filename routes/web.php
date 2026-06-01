<?php

use App\Http\Controllers\ContactController;
use App\Models\Project;
use App\Services\BannedIps;
use App\Services\ThreatStats;
use App\Services\UmamiStats;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Protocol Portfolio Node
|--------------------------------------------------------------------------
*/

// Home: Core Identity (hero limpio; la seguridad vive en su propia página /seguridad)
Route::get('/', function () {
    return view('sections.home');
})->name('home');

// Sobre mí: perfil profesional, experiencia, educación y certificaciones
Route::get('/sobre-mi', function () {
    return view('sections.about');
})->name('about');

// Seguridad Perimetral: telemetría de defensa en vivo + histórico + procedencia del tráfico
Route::get('/seguridad', function (ThreatStats $threats, UmamiStats $umami, BannedIps $banned) {
    return view('sections.security', [
        'threats' => $threats->stats(),
        'infra' => $threats->infra(),
        'countries' => $umami->countries(),
        'banned' => $banned->stats(),
    ]);
})->name('security');

// Endpoints JSON para el botón "↻ actualizar" de los widgets de /seguridad.
// Devuelven el dato FRESCO (saltan el cache). Sin credenciales: el contador en
// vivo sale de la DB propia; los países, de la API de Umami leída server-side.
//
// throttle:5,1 = máx 5 req/min por IP → 429 si se supera. Protege contra spam
// que martillaría la API de Umami (cada hit con fresh hace login+query) o la DB.
Route::middleware('throttle:5,1')->group(function () {
    Route::get('/api/telemetria/ataques', function (ThreatStats $threats) {
        return response()->json($threats->stats(fresh: true));
    })->name('api.ataques');

    Route::get('/api/telemetria/paises', function (UmamiStats $umami) {
        return response()->json(['countries' => $umami->countries(fresh: true)]);
    })->name('api.paises');

    Route::get('/api/telemetria/baneos', function (BannedIps $banned) {
        return response()->json($banned->stats(fresh: true));
    })->name('api.baneos');
});

// security.txt (RFC 9116): canal estándar para reportar vulnerabilidades.
// Coherente con el perfil DevSecOps. Sirve en ambas rutas que define el RFC.
Route::get('/.well-known/security.txt', function () {
    $expires = now()->addYear()->startOfDay()->toIso8601ZuluString();
    $body = "Contact: mailto:jose@alvaradomazzei.cl\n"
          ."Expires: {$expires}\n"
          ."Preferred-Languages: es, en\n"
          ."Canonical: https://alvaradomazzei.cl/.well-known/security.txt\n";

    return response($body, 200)->header('Content-Type', 'text/plain; charset=utf-8');
})->name('security-txt');

// Descarga del CV — servido por Laravel (no URL estática) con rate-limit.
// Anti-scraping: un crawler que intente bajarlo masivamente recibe 429. El PDF
// vive fuera de public en storage/app/private, así no es accesible por URL directa.
Route::get('/cv', function () {
    // En resources/ (parte del código, no en storage/ que es de www-data) para
    // que el `git reset` del deploy —que corre como master— pueda escribirlo.
    $path = resource_path('cv/cv.pdf');
    abort_unless(is_file($path), 404);

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="CV-Jose-Alvarado-Mazzei.pdf"',
        'X-Robots-Tag' => 'noindex, nofollow',
    ]);
})->middleware('throttle:10,1')->name('cv');

// Stack: Infrastructure & Ecosystem (solo el stack técnico; telemetría vive en /seguridad)
Route::get('/stack', function () {
    return view('sections.stack');
})->name('stack');

// Proyectos: Mission Critical Systems
Route::get('/proyectos', function () {
    $projects = Project::all();

    return view('sections.projects', compact('projects'));
})->name('projects.index');

// Contacto: Secure Communication Protocol
Route::get('/contacto', function () {
    return view('sections.contact');
})->name('contact.index');

// Acción de Envío (POST)
Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');

// robots.txt dinámico: en prod permite indexar; en staging/local bloquea TODO
// (que Google no indexe el entorno de pruebas). Sirve como ruta porque el archivo
// estático no conoce el entorno.
Route::get('/robots.txt', function () {
    if (app()->environment('production')) {
        $body = "User-agent: *\nAllow: /\n\nSitemap: ".url('/sitemap.xml')."\n";
    } else {
        $body = "User-agent: *\nDisallow: /\n";
    }

    return response($body, 200)->header('Content-Type', 'text/plain');
})->name('robots');

// Sitemap dinámico (se mantiene solo al agregar rutas acá)
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'monthly'],
        ['loc' => url('/sobre-mi'), 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['loc' => url('/proyectos'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => url('/seguridad'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['loc' => url('/stack'), 'priority' => '0.7', 'changefreq' => 'yearly'],
        ['loc' => url('/contacto'), 'priority' => '0.6', 'changefreq' => 'yearly'],
    ];

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
