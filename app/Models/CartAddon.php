<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartAddon extends Model
{
    protected $fillable = [
        'cart_id',
        'product_addon_id',  // referensi ke addon produk
        'quantity',          // jumlah addon (misal, 2x topping keju)
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function productAddon()
    {
        return $this->belongsTo(ProductAddon::class);
    }
}
