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
        $cartItems = CartModel::with(['product', 'variantProduct', 'addons'])->where('customer_id', auth()->guard('customers')->id())->get();
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

        if (strtolower($this->metodePembayaran) === 'qris') {
            // Store checkout data in session for Tripay callback
            session([
                'checkout_nama' => $this->nama,
                'checkout_telepon' => $this->telepon,
                'checkout_alamat' => $this->alamat,
                'checkout_metodePemesanan' => $this->metodePemesanan,
                'checkout_metodePembayaran' => $this->metodePembayaran,
                'checkout_jadwalAktif' => $this->jadwalAktif,
                'checkout_tanggal' => $this->tanggal,
                'checkout_waktu' => $this->waktu,
            ]);
            // Redirect to Tripay payment page
            $tripayUrl = $this->getTripayPaymentUrl();
            return redirect()->away($tripayUrl);
        }

        $this->createOrder();
    }

    public function getTripayPaymentUrl()
    {
        // Mock Tripay payment URL (replace with real API integration)
        // You can pass a unique reference or session id if needed
        return url('/checkout/tripay-callback?success=1');
    }

    public function tripayCallback()
    {
        // Here you would validate the Tripay callback (signature, status, etc.)
        // For now, we assume payment is successful if ?success=1
        if (request('success') == 1) {
            // Restore checkout data from session
            $this->nama = session('checkout_nama');
            $this->telepon = session('checkout_telepon');
            $this->alamat = session('checkout_alamat');
            $this->metodePemesanan = session('checkout_metodePemesanan');
            $this->metodePembayaran = session('checkout_metodePembayaran');
            $this->jadwalAktif = session('checkout_jadwalAktif');
            $this->tanggal = session('checkout_tanggal');
            $this->waktu = session('checkout_waktu');
            $this->createOrder();
            // Clear session data after use
            session()->forget([
                'checkout_nama',
                'checkout_telepon',
                'checkout_alamat',
                'checkout_metodePemesanan',
                'checkout_metodePembayaran',
                'checkout_jadwalAktif',
                'checkout_tanggal',
                'checkout_waktu',
            ]);
            session()->flash('success', 'Pembayaran QRIS berhasil, pesanan Anda dikirim!');
            return redirect('/user');
        } else {
            session()->flash('error', 'Pembayaran QRIS gagal atau dibatalkan.');
            return redirect('/checkout');
        }
    }

    public function createOrder()
    {
        // Use logged-in customer if available
        if (auth()->guard('customers')->check()) {
            $customer = \App\Models\Customer::find(auth()->guard('customers')->id());
            // Optionally update customer info from form
            if ($customer) {
                $customer->nama = $this->nama;
                $customer->alamat = $this->alamat;
                $customer->telepon = $this->telepon;
                // $customer->email = $this->telepon . '@mail.com';
                $customer->save();
            }
        } else {
            $customer = Customer::updateOrCreate(
                ['telepon' => $this->telepon],
                [
                    'nama' => $this->nama,
                    'alamat' => $this->alamat,
                    // 'email' => $this->telepon . '@mail.com',
                    'password' => bcrypt($this->telepon)
                ]
            );
            // Optionally log in the new customer
            auth()->guard('customers')->login($customer);
        }

        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'total_harga' => $this->subtotal,
            'metode_pembayaran' => $this->metodePembayaran,
            'catatan' => $this->metodePemesanan,
        ]);

        // Hitung ulang total dari cartItems agar pesanan tidak 0
        $pesananTotal = 0;
        $pesananCartItems = CartModel::with('product', 'variantProduct', 'addons')->where('customer_id', $customer->id)->get();
        foreach ($pesananCartItems as $cart) {
            $price = $cart->variant_id
                ? $cart->variantProduct->price ?? ($cart->product->harga_dasar ?? 0)
                : ($cart->product->harga_dasar ?? 0);
            $addOnsTotal = 0;
            foreach ($cart->addons as $addon) {
                $addOnsTotal += $addon->productAddon->price * $addon->quantity;
            }
            $pesananTotal += ($price + $addOnsTotal) * $cart->quantity;
        }

        \App\Models\Pesanan::create([
            'customer_id' => $customer->id,
            'total' => $pesananTotal,
            'status' => 'menunggu',
            'waktu' => now(),
        ]);

        $cartItems = CartModel::with('product')->where('customer_id', $customer->id)->get();

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

        CartModel::where('customer_id', $customer->id)->delete();

        session()->flash('success', 'Pesanan Anda berhasil dikirim!');

        return redirect('/user');
    }

    public function render()
    {
        return view('livewire.checkout.checkout');
    }
}