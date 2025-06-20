<?php

namespace App\Livewire\Checkout;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Cart as CartModel;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Checkout extends Component
{
    public $items = [];
    public $subtotal = 0;

    public $nama;
    public $telepon;
    public $alamat;
    public $metodePemesanan = 'dine_in';
    public $metodePembayaran = 'Qris';
    public $jadwalAktif = false;
    public $tanggal;
    public $waktu;

    public function mount()
    {
        $cartItems = CartModel::with(['product', 'variantProduct', 'addons'])->where('user_id', auth()->guard('customers')->id())->get();
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
                'name' => $cart->product->nama_produk ?? '-',
                'desc' => $cart->product->deskripsi ?? '',
                'price' => $price + $addOnsTotal,
                'qty' => $cart->quantity ?? 1,
                'image' => $cart->product->gambar_produk ?? 'https://via.placeholder.com/50',
            ];
        })->toArray();

        $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function submit()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'metodePemesanan' => 'required|in:dine_in,take_away,drive_thru,catering',
            'metodePembayaran' => 'required|in:Qris,Cod/cash',
        ];

        if ($this->jadwalAktif) {
            $rules['tanggal'] = 'required|date';
            $rules['waktu'] = 'required';
        }

        $this->validate($rules);

        $customer = Customer::updateOrCreate(
            ['telepon' => $this->telepon],
            [
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'email' => $this->telepon . '@mail.com',
                'password' => bcrypt($this->telepon)
            ]
        );

        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'total_harga' => $this->subtotal,
            'metode_pembayaran' => $this->metodePembayaran,
            'catatan' => $this->metodePemesanan,
        ]);

        \App\Models\Pesanan::create([
            'customer_id' => $customer->id,
            'total' => $this->subtotal,
            'status' => 'menunggu',
            'waktu' => now(),
        ]);

        $cartItems = CartModel::with('product')->where('user_id', auth()->guard('customers')->id())->get();

        foreach ($cartItems as $cart) {
            $price = $cart->variant_id
                ? $cart->variantProduct->price ?? ($cart->product->harga_dasar ?? 0)
                : ($cart->product->harga_dasar ?? 0);

            // Get add-ons
            $addOnsTotal = 0;
            foreach ($cart->addons as $addon) {
                $addOnsTotal += $addon->productAddon->price * $addon->quantity;
            }

            $totalPrice = $price + $addOnsTotal;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product_id,
                'variant_id' => $cart->variant_id,
                'quantity' => $cart->quantity,
                'price' => $totalPrice,
                'subtotal' => $totalPrice * $cart->quantity,
            ]);
        }

        CartModel::where('user_id', auth()->guard('customers')->id())->delete();

        session()->flash('success', 'Pesanan Anda berhasil dikirim!');

        return redirect('/user');
    }

    public function render()
    {
        return view('livewire.checkout.checkout');
    }
}