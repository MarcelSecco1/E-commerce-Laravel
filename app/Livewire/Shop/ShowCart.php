<?php

namespace App\Livewire\Shop;

use App\Models\Pessoa;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class ShowCart extends Component
{
    public $total = 0;

    #[Validate('required|min:8|max:8|regex:/^\d{8}$/')]
    public int $cep;

    #[Validate('required|min:3|max:255')]
    public $estado;

    public $bairro;

    #[Validate('required|min:3|max:255')]
    public $nome;

    #[Validate('required|min:3|max:255')]
    public $cidade;

    #[Validate('required|min:3|max:255')]
    public $endereco;

    #[Validate('required|min:3|max:255')]
    public $sobrenome;

    #[Validate('required|min:3|max:255|cpf')]
    public $cpf;


    public function atualizarCep(): void
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

    public function salvarPessoa(): never
    {
        $this->validate();

        $pessoa = auth()->user()->pessoa()->create([
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'cpf' => $this->cpf,
            'endereco' => $this->endereco,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'cep' => $this->cep,
            'bairro' => $this->bairro,
        ]);

        if ($pessoa) {
            dd('Pessoa cadastrada com sucesso');
        } else {
            dd('Erro ao cadastrar pessoa');
        }
    }

    public function render(): View
    {
        return view('livewire.shop.show-cart');
    }
}
