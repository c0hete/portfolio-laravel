<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Seguridad general
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('X-XSS-Protection', '0'); // Moderno, evita comportamiento obsoleto

        // HSTS (solo HTTPS)
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=63072000; includeSubDomains; preload'
            );
        }

// Content Security Policy (definitiva, por header HTTP)
	$csp = "default-src 'self'; "
	 . "img-src 'self' data:; "
     	 . "style-src 'self' 'unsafe-inline'; "
     	 . "font-src 'self' data:; "
    	 . "script-src 'self'; "
    	 . "connect-src 'self'; "
    	 . "base-uri 'self'; "
    	 . "form-action 'self'; "
    	 . "frame-ancestors 'none';";

	$response->headers->set('Content-Security-Policy', $csp);

        	return $response;
    	}
}
