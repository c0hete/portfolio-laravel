<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes - Protocol Portfolio Node
|--------------------------------------------------------------------------
*/

// Home: Core Identity
Route::get('/', function () { 
    return view('sections.home'); 
})->name('home');

// Stack: Infrastructure & Ecosystem
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