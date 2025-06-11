<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart as CartModel;

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

    public function getCartItems()
    {
        // Pakai data langsung dari model
        // Cek guard yang digunakan, jika customer pakai guard 'customers', ambil id dari situ
        $userId = auth()->id();
        if (auth()->guard('customers')->check()) {
            $userId = auth()->guard('customers')->user()->id;
        }
        return CartModel::with('product')->where('user_id', $userId)->get();
    }

    public function getSubtotalProperty()
    {
        return collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function mount()
    {
        // Ambil data cart dari database menggunakan getCartItems
        $this->items = $this->getCartItems()->map(function($cart) {
            return [
                'name' => $cart->product->name ?? '-',
                'desc' => $cart->product->desc ?? '',
                'price' => $cart->product->price ?? 0,
                'qty' => $cart->qty ?? 1,
                'image' => $cart->product->image_url ?? 'https://via.placeholder.com/50',
            ];
        })->toArray();
        // Hitung subtotal setelah items diisi
        $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function render()
    {
        return view('livewire.cart.cart')->layout('components.layouts.app'); // Gunakan layout biasa
    }
}
