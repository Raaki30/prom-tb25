<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Merch extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'nama',
        'email',
        'no_hp',
        'grand_total',
        'metodebayar',
        'bukti',
        'status_bayar',
        'status_pickup',
    ];

    // Relasi ke merch_items (1 merch memiliki banyak item)
    public function items()
{
    return $this->hasMany(MerchItem::class, 'merch_id');
}

}
