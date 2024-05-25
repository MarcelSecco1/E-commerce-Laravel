<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryInHome extends Component
{
    public function render()
    {
        $categories = Category::inRandomOrder()->take(3)->get();

        return view('livewire.category-in-home', compact('categories'));
    }
}
