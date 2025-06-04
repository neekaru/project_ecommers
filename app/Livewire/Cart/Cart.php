<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class Cart extends Component
{
    public $subtotal= 0;
    public $items = [
        [
            'name' => 'Ayam Goreng',
            'desc' => 'ayam goreng Paha komplit',
            'price' => 23000,
            'qty' => 1,
            'image' => 'https://via.placeholder.com/50',
        ],
        [
            'name' => 'Nasi Putih',
            'desc' => '',
            'price' => 5000,
            'qty' => 1,
            'image' => 'https://via.placeholder.com/50',
        ],
        // Tambahkan produk lainnya
    ];

    public function getSubtotalProperty()
    {
        return collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function render()
    {
        return view('livewire.cart.cart')->layout('components.layouts.app'); // Gunakan layout biasa
    }
}
