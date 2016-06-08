<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property string $valid_until
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */

class AccessToken extends Model
{
    use ValidatingTrait;
    protected $table = 'access_tokens';
    protected $fillable = ['user_id', 'access_token', 'valid_until'];
    protected $rules = [
        'user_id' => 'required|integer',
        'access_token' => 'required|min:6',
        'valid_until' => 'required|date'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
