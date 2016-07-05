<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\AccessToken;

class OauthMiddleware {
    public function handle(Request $request, Closure $next) {
        if($request->headers->has('access-token')) {
            /** @var AccessToken $access_token */
            $access_token = AccessToken::where('access_token_sha1','=',$request->headers->get('access-token'))
                ->first();
            if(!$access_token) {
                return (new Response('Invalid Access Token', 400));
            }
            $user = $access_token->user;
        } else {
            return (new Response('Invalid Access Token', 400));
        }
        $sendUser = function() use ($user) {
            return $user;
        };
        $request->setUserResolver($sendUser);

        return $next($request);
    }

}