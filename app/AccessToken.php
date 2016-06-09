<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property string $access_token_sha1
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */

class AccessToken extends Model
{
    use ValidatingTrait;
    protected $table = 'access_tokens';
    protected $fillable = ['user_id', 'access_token', 'access_token_sha1'];
    protected $rules = [
        'user_id' => 'required|exists:users,id|integer',
        'access_token' => 'required|string',
        'access_token_sha1' => 'required|string',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
