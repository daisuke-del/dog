<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $primaryKey = 'user_id';

    public function reactions(): BelongsToMany
    {
        return $this->belongsToMany(Reaction::class);
    }

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
        'sex',
        'weight',
        'dog_point',
        'dog_image1',
        'dog_image2',
        'dog_image3',
        'breed1',
        'breed2',
        'instagram_id',
        'twitter_id',
        'tiktok_id',
        'blog_id',
        'location',
        'birthday',
        'comment',
        'yellow_card',
        'create_date',
        'update_dog_at',
        'dog_image_void_flg'
    ];

    protected $hidden = [
        'remember_token'
    ];
}
