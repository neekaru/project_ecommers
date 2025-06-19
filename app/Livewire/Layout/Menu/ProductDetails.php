<?php

namespace App\Livewire\Layout\Menu;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Models\Rating;
use App\Models\VarianProduct;
use App\Models\Cart;
use App\Models\CartAddon;
use Illuminate\Support\Facades\Auth;

class ProductDetails extends Component
{
    public $quantity = 1;
    protected $updatesQueryString = ['quantity'];
    protected $listeners = ['refresh' => '$refresh'];

    public $variant;
    public $selectedAddOns = [];
    public $product;
    public $variants = [];
    public $addOns = [];
    public $reviews = [];
    public $productId;

    public function mount($id)
    {
        $this->productId = $id;
        $this->product = Product::with(['varianProducts', 'addons', 'ratings'])->findOrFail($id);

        // Variants
        $this->variants = $this->product->varianProducts->mapWithKeys(function($variant) {
            return [$variant->id => [
                'name' => $variant->nama_varian,
            ]];
        })->toArray();
        $this->variant = array_key_first($this->variants);

        // Add-ons
        $this->addOns = $this->product->addons->mapWithKeys(function($addon) {
            return [$addon->slug => [
                'name' => $addon->name,
                'price' => $addon->price
            ]];
        })->toArray();
        $this->selectedAddOns = [];

        // Reviews
        $this->reviews = $this->product->ratings->map(function($rating) {
            return [
                'name' => $rating->customer->name ?? 'Anonim',
                'rating' => $rating->rating,
                'comment' => $rating->comment,
                'avatar' => strtoupper(substr($rating->customer->name ?? 'A', 0, 2))
            ];
        })->toArray();
    }

    public function incrementQuantity()
    {
        $this->quantity = (int) $this->quantity + 1;
        $this->dispatch('refresh');
    }

    public function decrementQuantity()
    {
        $this->quantity = max(1, (int) $this->quantity - 1);
        $this->dispatch('refresh');
    }

    public function toggleAddOn($addOnKey)
    {
        if (in_array($addOnKey, $this->selectedAddOns)) {
            $this->selectedAddOns = array_filter($this->selectedAddOns, function($item) use ($addOnKey) {
                return $item !== $addOnKey;
            });
        } else {
            $this->selectedAddOns[] = $addOnKey;
        }
    }

    public function getVariantPriceProperty()
    {
        return $this->product->harga_dasar ?? 0;
    }

    public function getAddOnsTotalProperty()
    {
        $total = 0;
        foreach ($this->selectedAddOns as $addOnKey) {
            if (isset($this->addOns[$addOnKey])) {
                $total += $this->addOns[$addOnKey]['price'];
            }
        }
        return $total;
    }

    public function getTotalPriceProperty()
    {
        return ($this->variantPrice + $this->addOnsTotal) * $this->quantity;
    }

    public function addToCart()
    {
        if (!auth()->guard('customers')->check()) {
            session()->flash('error', 'Anda harus login terlebih dahulu untuk menambahkan item ke keranjang.');
            return redirect('/login'); // redirect ke halaman login
        }

        $customerId = auth()->guard('customers')->user()->id;

        $cartItem = \App\Models\Cart::where('product_id', $this->productId)
            ->where('user_id', $customerId)
            ->first();
        
        if ($cartItem) {
            $cartItem->increment('quantity', $this->quantity);
        } else {
            \App\Models\Cart::create([
                'user_id' => $customerId,
                'product_id' => $this->productId ?? null,
                'variant' => $this->variant ?? null,
                'quantity' => $this->quantity ?? 1,
                'price' => $this->totalPrice,
            ]);
        }

        session()->flash('message', 'Item berhasil ditambahkan ke keranjang!');
        return redirect('/cart'); // langsung redirect
    }

    public function render() 
    {
        return view('livewire.layout.menu.productDetail', [
            'product' => $this->product,
            'variants' => $this->variants,
            'addOns' => $this->addOns,
            'reviews' => $this->reviews,
            'variantPrice' => $this->variantPrice,
            'addOnsTotal' => $this->addOnsTotal,
            'totalPrice' => $this->totalPrice
        ])->layout('components.layouts.app', [
            'title' => $this->product->name ?? 'Product Details'
        ]);
    }
}