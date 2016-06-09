<?php

namespace App\Http\Middleware;

use App\Tweet;
use Closure;
use Illuminate\Http\Response;

class TweetAccess
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
        $tweet = Tweet::findOrFail($request->id);
        if($tweet->user_id !== $request->user()->id) {
            return (new Response(['errors'=>['Access Denied']]));
        }
        return $next($request);
    }
}
