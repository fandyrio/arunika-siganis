<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        $response=$next($request);
        $response->headers->set('Content-Security-Policy',
        "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data:; font-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; object-src 'none'; frame-ancestors 'none';");

        return $response;
    }
}
