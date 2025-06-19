<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Models\Cart as CartModel;

class Checkout extends Component
{
    public $items = [];
    public $subtotal = 0;

    public $nama;
    public $telepon;
    public $alamat;
    public $metodePemesanan = 'Dine-in';
    public $metodePembayaran = 'Qris';
    public $jadwalAktif = false;
    public $tanggal;
    public $waktu;

    public function mount()
    {
        $cartItems = CartModel::with('product')->where('user_id', auth()->guard('customers')->id())->get();
        $this->items = $cartItems->map(function($cart) {
            return [
                'name' => $cart->product->nama_produk ?? '-',
                'desc' => $cart->product->deskripsi ?? '',
                'price' => $cart->product->harga_dasar ?? 0,
                'qty' => $cart->quantity ?? 1,
                'image' => $cart->product->gambar_produk ?? 'https://via.placeholder.com/50',
            ];
        })->toArray();

        $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'metodePemesanan' => 'required|in:Dine-in,Take Away,Driver Thru,Catering',
            'metodePembayaran' => 'required|in:Qris,Cod/cash',
        ]);


         if ($this->jadwalAktif) {
        $rules['tanggal'] = 'required|date';
        $rules['waktu'] = 'required';
    }

    $this->validate($rules);

    // Lanjut simpan order...

        // Simulasi proses simpan pesanan
        session()->flash('success', 'Pesanan Anda berhasil dikirim!');

        // Optional: redirect atau reset input
        return redirect()->route('menu'); // atau rute konfirmasi
    }

    public function render()
    {
        return view('livewire.checkout.checkout')->layout('components.layouts.app');
    }
}