<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merch extends Model
{
    protected $table = 'merches';
    protected $fillable = [
        'order_id',
        'nama',
        'email',
        'no_hp',
        'status',
        'item1',
        'varian_item1',
        'item2',
        'varian_item2',
        'item3',
        'varian_item3',
        'item4',
        'varian_item4',
        'total_harga',
        'metodebayar',
        'bukti',
        'pickup',
        'pickup_time',
        'notes'
    ];
}
