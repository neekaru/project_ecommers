<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault();
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
