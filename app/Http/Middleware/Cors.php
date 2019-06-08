<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return [
             /*
             |--------------------------------------------------------------------------
             | Laravel CORS
             |--------------------------------------------------------------------------
             |
             | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
             | to accept any value.
             |
             */
            'supportsCredentials' => false,
            'allowedOrigins' => ['http://localhost:3000'],
            'allowedHeaders' => ['Content-Type', 'X-Requested-With'],
            'allowedMethods' => ['*'], //['GET', 'POST', 'PUT',  'DELETE', 'OPTIONS'],
            'exposedHeaders' => ['Authorization'],
            'maxAge' => 0,
        ];
    }
}   
