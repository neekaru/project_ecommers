<?php

use App\Livewire\Auth\Login;
use App\Livewire\Menu\Makanan;
use App\Livewire\ProductDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Cart\Cart;
use App\Livewire\Layout\Menu\ProductDetails;

Route::get('/', function () {
    return view('layouts.main');
});


// Handle route for social login
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.google');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');
Route::get('/menu', Makanan::class);
Route::get('/login', Login::class)->name('login');
Route::get('/cart', Cart::class);
Route::get('/product/{id}', ProductDetails::class);
