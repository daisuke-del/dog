<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, Notifiable;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

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
        'name',
        'email',
        'password',
        'face_image',
        'gender',
        'height',
        'weight',
        'age',
        'salary',
        'face_point',
        'update_face_at',
        'create_date',
        'yellow_card',
        'twitter_id',
        'instagram_id',
        'facebook_id',
        'auth_code',
        'email_confirm_flg',
        'face_image_void_flg'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

}
