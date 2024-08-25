<?php

namespace App\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Origin' => $request->header('Origin', '*'),
            'Access-Control-Allow-Methods' => $request->header('Access-Control-Request-Method', '*'),
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers', '*'),
        ];
        $response = $request->method() == 'OPTIONS' ? response('') : $next($request);
        return $response->withHeaders($headers);
    }
}
