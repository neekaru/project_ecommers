<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    protected static function boot()
    {
        parent::boot();

        // Generate slug before saving
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}

    // Jika kamu ingin otomatis generate slug dari name,
    // kamu bisa pakai mutator atau package tambahan seperti "spatie/laravel-sluggable"

