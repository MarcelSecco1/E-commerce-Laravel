<?php

namespace App\Livewire\Shop;

use App\Models\LikeProduto;
use Livewire\WithPagination;
use App\Models\Produto;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

class AllProducts extends Component
{

    use WithPagination;
    public $paginationTheme = 'bootstrap';
    // public $produtos;f
    public $colun = 'created_at';
    public $order = 'desc';

    public function orderBy($value)
    {
        switch ($value) {
            case 'recent':
                $this->colun = 'created_at';
                $this->order = 'desc';
                break;
            case 'antigo':
                $this->colun = 'created_at';
                $this->order = 'asc';
                break;
            case 'atoz':
                $this->colun = 'nome';
                $this->order = 'asc';
                break;
            case 'ztoa':
                $this->colun = 'nome';
                $this->order = 'desc';
                break;
        }
        $this->resetPage();
    }
    public function likedProduto($id)
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        if (auth()->user()->likes()->where('produto_id', $id)->exists()) {
            $produto = (auth()->user()->likes()->where('produto_id', $id)->first());
            $produto->delete();
            $this->dispatch('addToCart', 'Produto removido dos seus favoritos!');
            // $this->dispatch('error', 'O produto já está na sua lista de favoritos!');
            return;
        }

        auth()->user()->likes()->create([
            'produto_id' => $id
        ]);


        $this->dispatch('addToCart', 'Produto está na sua lista de favoritos!');
        return;
    }


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


    public function search()
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $produtos = Produto::query()->orderBy($this->colun, $this->order)->paginate(12);

        return view('livewire.shop.all-products', compact('produtos'));
    }
}
