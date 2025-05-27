<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends Model
{
    protected $table = 'checkouts';

    protected $fillable = [
        'customer_id',
        'total_harga',
        'catatan',
        'metode_pembayaran',  // kolom metode pembayaran
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
