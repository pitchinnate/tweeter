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
                $access_token_count = AccessToken::where('user_id','=',$user->id)
                    ->where('access_token_sha1','=',$request->headers->get('access-token'))->count();
                if($access_token_count == 0) {
                    return (new Response('Invalid Access Token', 400));
                }
            } else {
                return (new Response('User not found', 400));
            }
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