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

// Home: Core Identity
Route::get('/', function (ThreatStats $threats) {
    return view('sections.home', ['threats' => $threats->stats()]);
})->name('home');

// Sobre mí: perfil profesional, experiencia, educación y certificaciones
Route::get('/sobre-mi', function () {
    return view('sections.about');
})->name('about');

// Stack: Infrastructure & Ecosystem
Route::get('/stack', function (UmamiStats $umami, ThreatStats $threats) {
    return view('sections.stack', [
        'countries' => $umami->countries(),
        'threats' => $threats->stats(),
    ]);
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
        ['loc' => url('/stack'), 'priority' => '0.7', 'changefreq' => 'yearly'],
        ['loc' => url('/contacto'), 'priority' => '0.6', 'changefreq' => 'yearly'],
    ];

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
