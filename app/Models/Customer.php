<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    use HasFactory;

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
