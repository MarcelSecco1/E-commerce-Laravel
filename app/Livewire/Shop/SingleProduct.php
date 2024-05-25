<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Produto;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Url;

class SingleProduct extends Component
{
    #[Url]
    public $id;


    public $quantity = 1;

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if ($this->quantity > 1)
            $this->quantity--;
    }

    public function addToCart()
    {


        $product = Produto::where('id', $this->id)->first();

        $cart = session()->get('cart');

        if ($cart) {
            if (isset($cart[$product['id']])) {
                $cart[$product['id']]["quantity"] += $this->quantity;
                session()->put('cart', $cart);
                $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
            } else {
                $cart[$product['id']] = [
                    'id' => $product['id'],
                    'name' => $product['nome'],
                    'quantity' => $this->quantity,
                    'price' => $product['preco'],
                    'image' => $product['imagem'],
                ];
                session()->put('cart', $cart);
                $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
            }
            $this->dispatch('update', session()->put('cart', $cart));
            return;
        }

        $cart = [
            $product['id'] => [
                'id' => $product['id'],
                'name' => $product['nome'],
                'quantity' => $this->quantity,
                'price' => $product['preco'],
                'image' => $product['imagem'],
            ]
        ];
        session()->put('cart', $cart);
        $this->dispatch('addToCart', 'Produto adicionado ao carrinho!');
        $this->dispatch('update', session()->put('cart', $cart));
    }

    public function render(): View
    {

        $product = Produto::where('id', $this->id)->first();
        if (!$product) {
            return abort(404);
        }

        $category = Category::where('id', $product['category_id'])->first();

        return view('livewire.shop.single-product', compact('product', 'category'));
    }
}
