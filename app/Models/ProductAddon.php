<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAddon extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'description',
    ];

    // Relasi ke produk utama
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
