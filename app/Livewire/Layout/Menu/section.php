<?php

namespace App\Livewire\Layout\Menu;

use Livewire\Component;
use App\Models\Product;

class Section extends Component
{
    public function render()
    {
        $products = Product::all();
        return view('livewire.layout.menu.section', [
            'products' => $products,
        ]);
    }
}
