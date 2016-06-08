<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\AccessToken;

class OauthMiddleware {
    public function handle(Request $request, Closure $next) {
        if($request->headers->has('access-token') && $request->headers->has('token-type') && $request->headers->has('uid')) {
            $user = User::where('name','=',$request->headers->get('uid'))->first();
            if($user) {
                $access_token = AccessToken::where('access_token','=',$request->headers->get('access-token'))->first();
                if($access_token) {
                    if(time() > strtotime($access_token->valid_until)) {
                        return (new Response('Access Token has expired', 400));
                    }
                } else {
                    return (new Response('Invalid Access Token', 400));
                }
            } else {
                return (new Response('User not found', 400));
            }
        } else {
            return (new Response('Invalid Access Token', 400));
        }

        return $next($request);
    }

}