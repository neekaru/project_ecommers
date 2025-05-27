<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMethod extends Model
{
    protected $table = 'order_methods';

    protected $fillable = [
        'checkout_id',
        'metode_pesanan',
        'dijadwalkan',
        'tanggal_pengambilan',
        'waktu_pengambilan',
    ];

    protected $casts = [
        'dijadwalkan' => 'boolean',
        'tanggal_pengambilan' => 'date',
        'waktu_pengambilan' => 'time',
    ];

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }
}
