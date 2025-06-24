<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'waktu',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderMethod()
    {
        return $this->belongsTo(OrderMethod::class);
    }

    // Removed rating() relationship because ratings table does not have pesanan_id

    // Removed komentar() relationship because komentars table does not have pesanan_id
    public function transaction()
    {
        return $this->hasOne(\App\Models\Transaction::class, 'customer_id', 'customer_id')->latestOfMany();
    }
}