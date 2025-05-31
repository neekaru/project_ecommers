<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'provider_id',
        'provider_name',
        'avatar',
    ];

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class, 'customer_id');
    }
}
