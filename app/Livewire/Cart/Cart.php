<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart as CartModel;

class Cart extends Component
{
    public $subtotal= 0;
    public $items = [
       
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

        // 1. ambil data cart (relasi tbl produk) dari database
        // 2. masukan ke var $this->items

        // dd(auth()->id());
        // dd(auth()->guard('customers')->check(), auth()->guard('customers')->user());

        $cartItems = CartModel::with('product')->where('user_id', auth()->guard('customers')->id())->get();
        $this->items = $cartItems->map(function($cart) {
            return [
                'nama_produk' => $cart->product->nama_produk ?? '-',
                'name' => $cart->product->nama_produk ?? '-',
                'desc' => $cart->product->deskripsi ?? '',
                'price' => $cart->product->harga_dasar ?? 0,
                'qty' => $cart->quantity ?? 1,
                'image' => $cart->product->gambar_produk ?? 'https://via.placeholder.com/50',
            ];
        })->toArray();
        $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
        
        // // Ambil data cart dari database menggunakan getCartItems
        // $this->items = $this->getCartItems()->map(function($cart) {
        //     return [
        //         'name' => $cart->product->name ?? '-',
        //         'desc' => $cart->product->desc ?? '',
        //         'price' => $cart->product->price ?? 0,
        //         'qty' => $cart->qty ?? 1,
        //         'image' => $cart->product->image_url ?? 'https://via.placeholder.com/50',
        //     ];
        // })->toArray();
        // // Hitung subtotal setelah items diisi
        // $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function render()
    {
        return view('livewire.cart.cart')->layout('components.layouts.app'); // Gunakan layout biasa
    }
}
