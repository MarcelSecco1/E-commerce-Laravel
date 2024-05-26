<?php

namespace App\Livewire;

use App\Console\Commands\check;
use App\Models\Category;
use Livewire\Component;

class CategoryInHome extends Component
{
    public function render()
    {

        $categories = Category::inRandomOrder()->take(3)->get();


        $valueToCheck = $this->checkProducts($categories);

        while (!$valueToCheck) {
            $categories = Category::inRandomOrder()->take(3)->get();
            $valueToCheck = $this->checkProducts($categories);
        }



        foreach ($categories as $category) {
            $products[] = $category->products()->get();
        }


        return view('livewire.category-in-home', compact('categories', 'products'));
    }

    private function checkProducts($categories)
    {
        foreach ($categories as $category) {
            if ($category->products->count() == 0) {
                return false;
            }
        }
        return true;
    }
}
