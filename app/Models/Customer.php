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
<<<<<<< HEAD
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
=======
        'provider_id',
        'provider_name',
        'avatar',
>>>>>>> d52a8bc339157c40cadeca0d0213e0c2c3bb42f2
    ];

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class, 'customer_id');
    }
}
