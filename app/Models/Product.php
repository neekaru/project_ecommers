<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

        protected static function boot()
    {
        parent::boot();

        // Generate slug before saving
        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }
}
