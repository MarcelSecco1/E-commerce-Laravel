<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;

class FooterCategories extends Component
{
    public function render(): View
    {
        $categories = Category::all()->take(7);

        return view('livewire.footer-categories', compact('categories'));
    }

}
