<?php

namespace App\Livewire;

use App\Models\LikeProduto;
use App\Models\Produto;
use Illuminate\View\View;
use Livewire\Component;

class ListLiked extends Component
{

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

    public function remoteToFav($id)
    {
        $like = LikeProduto::where('user_id', auth()->id())
            ->where('produto_id', $id)->first();
        $like->delete();
        $this->dispatch('addToCart', 'Produto removido dos favoritos!');
    }

    public function removeAllFav()
    {
        $userId = auth()->user()->id;

        $allLike = LikeProduto::query()->where('user_id', $userId);
        $allLike->delete();
        $this->dispatch('addToCart', 'Todos os produtos foram removidos!');
    }
    public function render(): View
    {
        $likeProduto = LikeProduto::where('user_id', auth()->id())->get();
        $produtos = [];
        foreach ($likeProduto as $like) {
            $produtos[] = $like->produto;
        }
        // $produtos = Produto::whereIn('id', $produtosId)->get();

        return view('livewire.list-liked', compact('produtos'));
    }
}
