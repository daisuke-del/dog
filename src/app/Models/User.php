<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $primaryKey = 'user_id';

    protected static function boot()
    {
        parent::boot();

        self::creating(function(User $model) {
            $model -> user_id = Str::orderedUuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'gender',
        'height',
        'weight',
        'age',
        'salary',
        'face_point',
        'height2',
        'weight2',
        'age2',
        'salary2',
        'face_point2',
        'face_image',
        'facebook_id',
        'instagram_id',
        'twitter_id',
        'yellow_card',
        'create_date',
        'update_face_at',
        'face_image_void_flg',
        'order_number'
    ];

    protected $hidden = ['password'];
}
