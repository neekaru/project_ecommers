<?php

namespace App\Livewire\Layout\Menu;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Models\Rating;
use App\Models\VarianProduct;

class ProductDetails extends Component
{
    public $quantity = 1;
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
        $this->product = Product::with(['addons', 'ratings'])->findOrFail($id);
        // $this->product = Product::with(['variants', 'CartartAddon', 'ratings'])->findOrFail($id);

        // Variants
        $this->variants = $this->product->variants->mapWithKeys(function($variant) {
            return [$variant->slug => [
                'name' => $variant->name,
                'price' => $variant->price
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
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
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
        return $this->variants[$this->variant]['price'] ?? 0;
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
        $cartItem = [
            'product' => $this->product,
            'variant' => $this->variant,
            'quantity' => $this->quantity,
            'add_ons' => $this->selectedAddOns,
            'total_price' => $this->totalPrice
        ];
        $this->dispatch('item-added-to-cart', $cartItem);
        session()->flash('message', 'Item berhasil ditambahkan ke keranjang!');
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