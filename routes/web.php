<?php

use App\Livewire\Menu\Makanan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/menu', Makanan::class);