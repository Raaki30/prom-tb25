<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'merch_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
    ];

    // Relasi balik ke merch (setiap item milik satu merch)
    public function merch()
    {
        return $this->belongsTo(Merch::class);
    }
}
