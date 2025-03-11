<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'https://front1-production.up.railway.app') // Permite peticiones de cualquier origen
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true'); // Esto es clave

              // Responder a preflight request (OPTIONS)
    if ($request->isMethod('OPTIONS')) {
        return response('', 200)->withHeaders([
            'Access-Control-Allow-Origin' => 'https://front1-production.up.railway.app',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Allow-Credentials' => 'true',
        ]);
    }

    return $response;
    }

    
}
