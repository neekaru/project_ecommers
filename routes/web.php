<?php

use App\Livewire\Menu\Makanan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.main');
});


// Handle route for social login
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/menu', Makanan::class);