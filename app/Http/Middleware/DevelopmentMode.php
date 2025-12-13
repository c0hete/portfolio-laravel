<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DevelopmentMode
{
    public function handle(Request $request, Closure $next)
    {
        // Permitir algunos paths necesarios
        $allowed = [
            'build/',        // assets compilados
            'favicon.ico',   // icono
            'health',        // chequeo opcional
        ];

        foreach ($allowed as $path) {
            if ($request->is($path . '*')) {
                return $next($request);
            }
        }

        // Mostrar solo la vista welcome
        return response()->view('welcome');
    }
}
