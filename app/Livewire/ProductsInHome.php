<?php

namespace App\Livewire;

use App\Models\Produto;
use Livewire\Component;

class ProductsInHome extends Component
{
    public function render()
    {
        $products = Produto::inRandomOrder()->take(3)->get();
        
        return view('livewire.products-in-home', compact('products'));
    }
}
