<?php

use App\Livewire\Auth\Login;
use App\Livewire\Menu\Makanan;
use App\Livewire\ProductDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Cart\Cart;
use App\Livewire\Layout\Menu\ProductDetails;
use App\Livewire\User\Dashboard;
use App\Livewire\Checkout\Checkout;
use App\Livewire\User\EditProfile;

Route::get('/', function () {
    return view('layouts.main');
});


// Handle route for social login
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.google');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');
Route::get('/menu', Makanan::class)->name('menu');
Route::get('/login', Login::class)->name('login');
Route::get('/cart', Cart::class);
Route::get('/product/{id}', ProductDetails::class);
Route::get('/checkout', Checkout::class)->name('checkout');


Route::middleware(['auth:customers'])->group(function () {
    Route::get('/user', Dashboard::class)->name('user.dashboard');
    Route::get('/user/edit-profile', EditProfile::class)->name('user.edit-profile');
});