<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // CSP mais permissivo em desenvolvimento
        if (app()->environment('production')) {
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' https:",
                "style-src 'self' 'unsafe-inline' https:",
                "img-src 'self' data: blob: https:",
                "connect-src 'self' https:",
                "font-src 'self' https:",
                "object-src 'none'",
                "frame-ancestors 'self'",
            ];
        } else {
            // Desenvolvimento - mais permissivo
            $csp = [
                "default-src * 'unsafe-inline' 'unsafe-eval'",
                "script-src * 'unsafe-inline' 'unsafe-eval'",
                "style-src * 'unsafe-inline'",
                "img-src * data: blob:",
            ];
        }
        
        $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        
        return $response;
    }
}


/*
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https:",
            "style-src 'self' 'unsafe-inline' https: https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https:",
            "connect-src 'self' https:",
            "font-src 'self' https:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
            "upgrade-insecure-requests"
        ];
        
        $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        
        return $response;
    }
}*/