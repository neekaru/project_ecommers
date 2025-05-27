<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'image',
        'name',
        'slug',
    ];

    // Contoh relasi jika kategori punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Jika kamu ingin otomatis generate slug dari name,
    // kamu bisa pakai mutator atau package tambahan seperti "spatie/laravel-sluggable"
}
