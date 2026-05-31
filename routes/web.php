<?php

use App\Http\Controllers\ContactController;
use App\Models\Project;
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
Route::get('/seguridad', function (ThreatStats $threats, UmamiStats $umami) {
    return view('sections.security', [
        'threats' => $threats->stats(),
        'infra' => $threats->infra(),
        'countries' => $umami->countries(),
    ]);
})->name('security');

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
