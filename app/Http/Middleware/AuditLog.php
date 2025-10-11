<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuditLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Apenas log em produção para não sobrecarregar em desenvolvimento
        if (app()->environment('production') && auth()->check()) {
            Log::channel('audit')->info('User activity', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
        }
        
        return $response;
    }
}


/*class AuditLog
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (auth()->check()) {
            Log::channel('audit')->info('User activity', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'input' => $this->sanitizeInput($request->all()),
            ]);
        }
        
        return $response;
    }
    
    protected function sanitizeInput($input)
    {
        $sensitiveFields = ['password', 'password_confirmation', 'credit_card', 'cvv', 'token'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($input[$field])) {
                $input[$field] = '***REDACTED***';
            }
        }
        
        return $input;
    }
}*/