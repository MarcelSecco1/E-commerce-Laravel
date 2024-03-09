<?php

namespace App\Livewire\Shop;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

use function Laravel\Prompts\error;

class ShowCart extends Component
{
    public $total = 0;

    public $cep;
    public $estado;
    public $bairro;
    public $continente;
    public $cidade;


    public function atualizarCep()
    {
        $this->validate([
            'cep' => ['required', 'regex:/^\d{8}$/']
        ], [
            'cep.regex' => 'O CEP deve conter exatamente 8 dígitos.'
        ]);

        $response = Http::get('https://viacep.com.br/ws/' . $this->cep . '/json/');

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['erro'])) {
                $this->addError('cep', 'CEP não encontrado.');
                return;
            }

            $this->estado = $data['uf'];
            $this->bairro = $data['bairro'];
            $this->continente = 'Brasil';
            $this->cidade = $data['localidade'];
        }
    }

    public function mount(): void
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');

            foreach ($cart as $item) {
                $this->total += $item['price'] * $item['quantity'];
            }
        }
    }
    #[On('limparCarrinho')]
    public function limparCarrinho(): void
    {
        $this->dispatch('update');
        session()->forget('cart');
        $this->total = 0;
    }

    public function render(): View
    {
        return view('livewire.shop.show-cart');
    }
}
