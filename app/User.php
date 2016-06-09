<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Watson\Validating\ValidatingTrait;

/**
 * Class User
 * @package App
 * @property integer $id
 * @property string $name
 * @property string $twitter_id
 * @property string $picture
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tweet[] $tweets
 */

class User extends Authenticatable
{
    use ValidatingTrait;
    protected $table = 'users';
    protected $fillable = ['name', 'twitter_id', 'picture'];
    protected $hidden = ['twitter_id'];

    protected $rules = [
        'name' => 'string|required|unique',
        'twitter_id' => 'string|required|unique',
        'picture' => 'string'
    ];

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
}
