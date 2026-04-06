<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project; // Importante para que Laravel sepa dónde buscar los proyectos

Route::get('/', function () { 
    return view('home'); 
});

Route::get('/stack', function () { 
    return view('stack'); 
});

Route::get('/proyectos', function () { 
    // Extraemos todos los sistemas de misión crítica de la DB
    $projects = Project::all(); 

    // Pasamos la variable a la vista para que el @forelse funcione
    return view('projects', compact('projects')); 
});