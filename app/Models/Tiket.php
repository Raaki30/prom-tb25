<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tikets';
    protected $fillable = [
        'order_id',
        'nis',
        'nama',
        'email',
        'phone',
        'kelas',
        'jumlah_tiket',
        'harga',
        'metodebayar',
        'bukti',
        'status',
        'entry',
        'checkin_time',
    ];
    public $timestamps = true;
}
