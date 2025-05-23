<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'nis',
        'category_id',
        'nominee_id',
    ];

}
