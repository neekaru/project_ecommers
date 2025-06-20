<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantProduct()
    {
        return $this->belongsTo(VarianProduct::class, 'variant_id');
    }

    public function addons()
    {
        return $this->hasMany(CartAddon::class);
    }
}
