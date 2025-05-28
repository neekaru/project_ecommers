<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Filament\Pages\Page;


class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    public $totalProduk;
    public $totalPelanggan;
    public $totalTransaksi;
    public $totalPendapatan;

    public function mount(): void
    {
        $this->totalProduk = Product::count();
        $this->totalPelanggan = Customer::count();
        $this->totalTransaksi = Transaction::count();
        //$this->totalPendapatan = 'Rp ' . number_format(Transaction::sum('grand_ total'), 0, ',', '.');
    }
}
