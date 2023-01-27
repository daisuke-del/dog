<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'to_user_id',
        'from_user_id'
    ];
}
