<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public function render()
    {
        $products = ProductModel::latest()->take(6)->get();

        return view('livewire.home.product', [
            'products' => $products,
        ]);
    }
}
