<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart as CartModel;

class Cart extends Component
{
    public $subtotal= 0;
    public $items = [
       
    ];
    //  public $order;


    // public function placeOrder()
    // {
    //     if (!$this->items) {
    //         session()->flash('error', 'Tidak ada pesanan yang dapat diproses.');
    //         return;
    //     }


    //     dd("oke");

        // 1. memindahkan data dari items ke transaction dan transaction_detail
        // 2. hapus data cart yang sudah dipindahkan
        // 3. redirect ke halaman checkout


        
        // Simulasikan update status
    //     $this->order->status = 'diproses';
    //     $this->order->save();

    //     session()->flash('success', 'Pesanan Anda sedang diproses.');
    // }

    
    public function getCartItems()
    {
        // Pakai data langsung dari model
        // Cek guard yang digunakan, jika customer pakai guard 'customers', ambil id dari situ
        $userId = auth()->guard('customers')->check()
            ? auth()->guard('customers')->user()->id
            : auth()->guard('web')->user()->id;
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
            $price = $cart->variant_id
                ? $cart->variantProduct->price ?? ($cart->product->harga_dasar ?? 0)
                : ($cart->product->harga_dasar ?? 0);

            // Get add-ons
            $addOnsTotal = 0;
            foreach ($cart->addons as $addon) {
                $addOnsTotal += $addon->productAddon->price * $addon->quantity;
            }

            return [
                'id_produk' => $cart->product->id ?? '-',
                'nama_produk' => $cart->product->nama_produk ?? '-',
                'name' => $cart->product->nama_produk ?? '-',
                'desc' => $cart->product->deskripsi ?? '',
                'price' => $price + $addOnsTotal,
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
        return view('livewire.cart.cart');
    }
}
