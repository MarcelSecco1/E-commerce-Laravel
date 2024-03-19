<?php

namespace App\Livewire\Shop;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ShowCart extends Component
{
    public $total = 0;

    #[Validate('required|regex:/^\d{8}$/')]
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
            if ($data['bairro'] !== '') {
                $this->bairro = $data['bairro'];
            } else {
                $this->bairro = $data['localidade'];
            }
            $this->estado = $data['uf'];

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

    public function salvarPessoa(): void
    {

        if (session()->has('cart')) {
            $body = "\nOlá, o cliente " . $this->nome . " " . $this->sobrenome . " acabou de realizar uma compra.\n";
            $body .= "\n🚚 Dados do cliente:\n";
            $body .= "Nome: " . $this->nome . " " . $this->sobrenome . "\n";
            $body .= "CPF: " . $this->cpf . "\n";
            $body .= "CEP: " . $this->cep . "\n";
            $body .= "Estado: " . $this->estado . "\n";
            $body .= "Cidade: " . $this->cidade . "\n";
            $body .= "Bairro: " . $this->bairro . "\n";
            $body .= "Rua: " . $this->endereco . "\n\n";

            $body .= "\n🛒  Itens do Pedido:\n";
            foreach (session('cart') as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $body .= $item['quantity'] . "x - " . $item['name'] . " - R$" . $itemTotal . "\n";
            }

            $body .= "\nTotal: *R$" . $this->total . "*";


            $params = array(
                'token' => 'wxh3pcrqez0y2low',
                'to' => '+5517997534057',
                'body' => $body
            );

            $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $options = ['form_params' => $params];
            $request = new Request('POST', 'https://api.ultramsg.com/instance81323/messages/chat', $headers);
            $res = $client->sendAsync($request, $options)->wait();

            if ($res->getStatusCode() == 200) {
                $this->dispatch('enviado', 'Pedido realizado com sucesso, entraremos em contato!');
                $this->limparDados();
                $this->limparCarrinho();
            } else {
                $this->dispatch('error', 'Erro ao realizar pedido, tente novamente!');
            }
        } else {
            $this->dispatch('error', 'Erro ao realizar pedido, seu carrinho está vazio.');
        }
    }

    public function limparDados()
    {
        $this->nome = '';
        $this->sobrenome = '';
        $this->cpf = '';
        $this->cep = 0;
        $this->estado = '';
        $this->cidade = '';
        $this->bairro = '';
        $this->endereco = '';
    }

    public function render(): View
    {
        return view('livewire.shop.show-cart');
    }
}
