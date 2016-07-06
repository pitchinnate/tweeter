<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Methods' => 'HEAD, GET, POST, PUT, PATCH, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Allow-Origin' => $_SERVER['HTTP_ORIGIN'],
        ];

        if($request->getMethod() == "OPTIONS") {
            return (new Response('OK',200,$headers));
        }

        $response = $next($request);

        foreach($headers as $key => $val) {
            $response->header($key,$val);
        }

        return $response;
    }
}
