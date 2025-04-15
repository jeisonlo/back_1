<?php
/*
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
   // In App\Http\Middleware\Cors.php
public function handle(Request $request, Closure $next)
{
    $response = $next($request);
    
    // Add these headers to all responses
    $response->headers->set('Access-Control-Allow-Origin', 'https://front1-production.up.railway.app');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    $response->headers->set('Access-Control-Allow-Credentials', 'true');
    
    // Respond to preflight requests
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
*/