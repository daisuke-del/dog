<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoveDiagnosisPerson extends Model
{
  protected $fillable = [
    'slug',
    'name',
    'image_url',
    'comment',
  ];
}

