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
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
            'Access-Control-Allow-Origin' => '*',
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
