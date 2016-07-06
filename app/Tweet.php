<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use Thujohn\Twitter\Facades\Twitter;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property string $scheduled
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */

class Tweet extends Model
{
    use ValidatingTrait;
    protected $table = 'tweets';
    protected $fillable = ['user_id', 'message', 'scheduled', 'status'];
    protected $rules = [
        'user_id' => 'required|exists:users,id|integer',
        'message' => 'required|string',
        'status' => 'required|string',
        'scheduled' => 'required|date|future'
    ];
    protected $validationMessages = [
        'scheduled.future' => "Scheduled date must be in the future."
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sendViaApi()
    {
        /** @var AccessToken $accessToken */
        $accessToken = AccessToken::where('user_id','=',$this->user_id)->first();
        $token = json_decode($accessToken->access_token,true);
        Twitter::reconfig(['token'=>$token['oauth_token'], 'secret'=> $token['oauth_token_secret']]);
        try {
            Twitter::postTweet(['status' => $this->message, 'format' => 'json']);
            $this->status = "posted";
            $this->forceSave();
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function returnArray()
    {
        $returnArray = $this->toArray();
        $returnArray['scheduled'] = date('c',strtotime($this->scheduled));
        return $returnArray;
    }
}
