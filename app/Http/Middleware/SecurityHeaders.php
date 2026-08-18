<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Evita que la app se cargue en un iframe (clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // El navegador no debe adivinar el tipo de contenido
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Activa protección XSS en navegadores antiguos
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Solo enviar referrer en el mismo origen
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // No exponer el servidor ni la versión de PHP
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Fuerza HTTPS si la app está en producción
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
