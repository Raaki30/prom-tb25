<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    protected $fillable = [
        'session_id',
        'status',
        'expired_at',
        'entered_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'entered_at' => 'datetime',
    ];

    
}
