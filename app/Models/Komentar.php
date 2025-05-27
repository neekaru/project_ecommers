<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komentar extends Model
{
    protected $table = 'komentars';

    protected $fillable = [
        'product_id',
        'customer_id',
        'parent_id',
        'isi',
    ];

    // Komentar terkait product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Komentar dari customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Balasan komentar
    public function balasan(): HasMany
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }

    // Induk komentar jika ini balasan
    public function induk(): BelongsTo
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }
}
