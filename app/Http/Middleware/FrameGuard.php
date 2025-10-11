<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FrameGuard
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Apenas em produção
        if (app()->environment('production')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);
        }
        
        return $response;
    }
}




/*namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FrameGuard
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);
        $response->headers->set('Content-Security-Policy', 'frame-ancestors \'self\'', false);
        
        return $response;
    }
}*/