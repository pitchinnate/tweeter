<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

class TweetController extends Controller
{
    public function getIndex(Request $request)
    {
        return [
            'tweets' => $request->user()->tweets,
        ];
    }

    public function getTweet(Request $request, $id)
    {
        /** @var Tweet $tweet */
        $tweet = Tweet::findOrFail($id);
        return [
            'tweet' => $tweet->toArray(),
        ];
    }

    public function postTweet(Request $request)
    {
        $tweet = new Tweet();
        $tweet->fill($request->input('tweet',[]));
        $tweet->status = 'scheduled';
        $tweet->user_id = $request->user()->id;
        if($tweet->isInvalid()) {
            return (new Response(['errors' => $tweet->getErrors()->all()],400));
        }
        $tweet->save();
        return [
            'tweet' => $tweet->toArray(),
        ];
    }

    public function putTweet(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->fill($request->input('tweet',[]));
        if($tweet->isInvalid()) {
            return (new Response(['errors' => $tweet->getErrors()->all()],400));
        }
        $tweet->save();
        return [
            'tweet' => $tweet->toArray(),
        ];
    }

    public function deleteTweet(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->delete();
        return (new Response('',200));
    }
}
