<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderMethod extends Model
{
    protected $table = 'order_methods';

    protected $fillable = [
        'metode_pesanan',
        'dijadwalkan',
        'tanggal_pengambilan',
        'waktu_pengambilan',
    ];

    protected $casts = [
        'dijadwalkan' => 'boolean',
        'tanggal_pengambilan' => 'date',
        'waktu_pengambilan' => 'datetime:H:i',
    ];

 
}
