<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'controls';
    protected $fillable = [
        'jenis_tiket',
        'is_active',
        'harga',
        'tanggal_mulai',
        'tanggal_berakhir',
        'biaya_lain',
        'isguestactive',
        'ismerchactive',
        'isvoteactive',
        'iswaitingroomactive',
        'harga_tamu',
        'quantity_waiting',
    ];
}
