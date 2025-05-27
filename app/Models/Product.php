<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // Nama tabel jika tidak mengikuti default (opsional karena Laravel otomatis pakai 'products')
    protected $table = 'products';

    // Mass assignable attributes
    protected $fillable = [
        'gambar_produk',
        'nama_produk',
        'deskripsi',
        'harga_dasar',
        'kategori_id',
    ];

    /**
     * Relasi ke kategori (products -> categories)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
