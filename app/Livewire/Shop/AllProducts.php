<?php

namespace App\Livewire\Shop;

use App\Models\Produto;
use Illuminate\View\View;
use Livewire\Component;

class AllProducts extends Component
{
    public $produtos;

    public function addProductInCart($id): void
    {

        $produto = Produto::findOrFail($id);
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $produto->id => [
                    'id' => $produto->id,
                    'name' => $produto->nome,
                    'quantity' => 1,
                    'price' => $produto->preco,
                    'image' => $produto->imagem,
                ]
            ];

            session()->put('cart', $cart);
            $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
        } else {
            if (isset($cart[$produto->id])) {
                $cart[$produto->id]['quantity']++;
                session()->put('cart', $cart);
                $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
            } else {
                $cart[$produto->id] = [
                    'id' => $produto->id,
                    'name' => $produto->nome,
                    'quantity' => 1,
                    'price' => $produto->preco,
                    'image' => $produto->imagem,
                ];
                session()->put('cart', $cart);
                $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
            }
        }

        $this->dispatch('update', session()->put('cart', $cart));
    }


    public function mount(): void
    {
        $this->produtos = Produto::all();
    }




    public function render(): View
    {
        return view('livewire.shop.all-products');
    }
}
