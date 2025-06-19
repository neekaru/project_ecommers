<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    protected $table = 'checkouts';

    protected $fillable = [
        'product_id',
        'customer_id',
        'total_harga',
        'metode_pembayaran',
        'method_pesanan'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderMethod(): HasOne
    {
        return $this->hasOne(OrderMethod::class);
    }
}
