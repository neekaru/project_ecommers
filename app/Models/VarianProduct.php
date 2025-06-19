<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianProduct extends Model
{
    protected $fillable = [
        'product_id',
        'nama_varian',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


