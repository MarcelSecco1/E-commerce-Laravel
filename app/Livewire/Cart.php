<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

class Cart extends Component
{
    public $cart;
    public $quantia = 0;

    #[On('update')]
    public function updateCart(): void
    {
        if (session()->has('cart')) {
            $this->cart = session()->get('cart');
            $this->quantia = count($this->cart);
        }else{
            $this->quantia = 0;
        }
    }

    public function mount(): void
    {
        if (session()->has('cart')) {
            $this->cart = session()->get('cart');
            $this->quantia = count($this->cart);
        }
    }

    public function render(): View
    {
        return view('livewire.cart');
    }
}
