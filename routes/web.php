<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('home'); });
Route::get('/stack', function () { return view('stack'); });
Route::get('/proyectos', function () { return view('projects'); });
