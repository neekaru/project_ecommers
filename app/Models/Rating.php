<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'review',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function komentar()
    {
        return $this->hasOne(\App\Models\Komentar::class, 'product_id', 'product_id')
            ->whereColumn('customer_id', 'customer_id');
    }
}
