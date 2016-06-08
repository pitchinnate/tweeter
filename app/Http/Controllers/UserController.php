<?php

namespace App\Http\Controllers;

use App\AccessToken;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use Thujohn\Twitter\Facades\Twitter;

class UserController extends Controller
{
    public function getLink(Request $request)
    {
        Twitter::reconfig(['token' => '', 'secret' => '']);
        $token = Twitter::getRequestToken(route('twitter.callback'));
        if (isset($token['oauth_token_secret'])) {
            $request->session()->put('oauth_state', 'start');
            $request->session()->put('oauth_request_token', $token['oauth_token']);
            $request->session()->put('oauth_request_token_secret', $token['oauth_token_secret']);
            $url = Twitter::getAuthorizeURL($token, true, true);
            return redirect($url);
        }
        return (new Response('Error',500));
    }

    public function returnOauth(Request $request)
    {
        if ($request->session()->has('oauth_request_token')) {
            $request_token = [
                'token' => $request->session()->get('oauth_request_token'),
                'secret' => $request->session()->get('oauth_request_token_secret'),
            ];
            Twitter::reconfig($request_token);
            $token = Twitter::getAccessToken($request->input('oauth_verifier',''));
            $credentials = Twitter::getCredentials();
            $user = User::where('twitter_id','=',$credentials->id)->first();
            if(!$user) {
                $user = new User([
                    'name' => $credentials->screen_name,
                    'twitter_id' => "{$credentials->id}",
                    'picture' => $credentials->profile_image_url,
                ]);
                if($user->isInvalid()) {
                    dd($user->getErrors()->all());
                    return (new Response('Error creating user account',400));
                }
                $user->save();
            } else {
                $user->name = $credentials->screen_name;
                $user->picture = $credentials->profile_image_url;
                $user->save();
            }
            $accessToken = new AccessToken([
                'user_id' => $user->id,
                'access_token' => json_encode($token),
                'valid_until' => date('Y-m-d H:i:s',strtotime('now +12 hours')),
            ]);
            $accessToken->save();
            return view('users.close',[
                'uid' => $user->name,
                'token' => sha1($accessToken->access_token),
            ]);
        }
    }
}
