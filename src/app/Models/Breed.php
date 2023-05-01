<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'min_width',
        'max_width',
        'min_weight',
        'max_weight',
        'personality1',
        'personality2',
        'personality3',
        'country',
        'size',
        'group',
        'dog_image'
    ];
}
