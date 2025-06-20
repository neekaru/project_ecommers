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
    public $addonQuantities = [];

    public function mount($id)
    {
        $this->productId = $id;
        $this->product = Product::with(['varianProducts', 'addons', 'ratings'])->findOrFail($id);

        // Variants
        $this->variants = $this->product->varianProducts->mapWithKeys(function($variant) {
            return [$variant->id => [
                'name' => $variant->nama_varian,
                'price' => $variant->price,
            ]];
        })->toArray();
        $this->variant = null;

        // Add-ons
        $this->addOns = $this->product->addons->mapWithKeys(function($addon) {
            return [$addon->id => [
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

        $this->addonQuantities = [];
        foreach ($this->addOns as $addonId => $addon) {
            $this->addonQuantities[$addonId] = 1;
        }
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

    public function incrementAddonQuantity($addonId)
    {
        if (!isset($this->addonQuantities[$addonId])) {
            $this->addonQuantities[$addonId] = 1;
        }
        $this->addonQuantities[$addonId]++;
        $this->dispatch('refresh');
    }

    public function decrementAddonQuantity($addonId)
    {
        if (!isset($this->addonQuantities[$addonId])) {
            $this->addonQuantities[$addonId] = 1;
        }
        $this->addonQuantities[$addonId] = max(1, $this->addonQuantities[$addonId] - 1);
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
            if (!isset($this->addonQuantities[$addOnKey])) {
                $this->addonQuantities[$addOnKey] = 1;
            }
        }
        $this->dispatch('refresh');
    }

    // Pilihan radio: hanya satu addOn yang bisa dipilih
    public function selectAddOn($addOnKey)
    {
        $this->selectedAddOns = [$addOnKey];
        if (!isset($this->addonQuantities[$addOnKey])) {
            $this->addonQuantities[$addOnKey] = 1;
        }
        $this->dispatch('refresh');
    }

    public function getVariantPriceProperty()
    {
        if ($this->variant && isset($this->variants[$this->variant]['price'])) {
            return $this->variants[$this->variant]['price'];
        }

        return $this->product->harga_dasar ?? 0;
    }

    public function getAddOnsTotalProperty()
    {
        $total = 0;
        foreach ($this->selectedAddOns as $addOnKey) {
            if (isset($this->addOns[$addOnKey])) {
                $qty = $this->addonQuantities[$addOnKey] ?? 1;
                $total += $this->addOns[$addOnKey]['price'] * $qty;
            }
        }

        return $total;
    }

    public function getTotalPriceProperty()
    {
        // If variant is selected, use variant price + add-ons total
        // Otherwise, use base price + add-ons total
        $basePrice = $this->variant ? $this->variantPrice : $this->product->harga_dasar;
        return ($basePrice + $this->addOnsTotal) * $this->quantity;
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
            ->where('variant_id', $this->variant)
            ->first();

        // Calculate the price based on variant or base price
        $price = $this->variant
            ? ($this->variants[$this->variant]['price'] + $this->addOnsTotal)
            : ($this->product->harga_dasar + $this->addOnsTotal);

        if ($cartItem) {
            $cartItem->increment('quantity', $this->quantity);
        } else {
            $cartItem = \App\Models\Cart::create([
                'user_id' => $customerId,
                'product_id' => $this->productId ?? null,
                'variant_id' => $this->variant ?? null,
                'quantity' => $this->quantity ?? 1,
                'price' => $price,
            ]);
        }

        // Simpan addon ke tabel cart_addons
        foreach ($this->selectedAddOns as $addOnKey) {
            $qty = $this->addonQuantities[$addOnKey] ?? 1;
            \App\Models\CartAddon::create([
                'cart_id' => $cartItem->id,
                'product_addon_id' => $addOnKey,
                'quantity' => $qty,
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
        ]);
    }
}