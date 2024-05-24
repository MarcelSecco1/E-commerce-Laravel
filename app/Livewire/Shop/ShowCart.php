<?php

namespace App\Livewire\Shop;

use App\Models\Pessoa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;



class ShowCart extends Component
{
    public $total = 0;

    #[Validate('required')]
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
            'cep' => ['required']
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


    #[On('applyCodeInCart')]
    public function applyCodeInCart($discount)
    {
        $this->total = $this->total * ($discount / 100);
    }


    #[On('limparCarrinho')]
    public function limparCarrinho(): void
    {
        $this->dispatch('update');
        session()->forget('cart');
        $this->total = 0;
    }


    // @return 
    public function salvarPessoa(): void
    {

        if (!auth()->check()) {
            $this->dispatch('error', 'Erro ao realizar pedido, logue-se para tentar novamente!');
            return;
        }

        Pessoa::create([
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'cpf' => $this->cpf,
            'cep' => $this->cep,
            'estado' => $this->estado,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'endereco' => $this->endereco,
            'user_id' => auth()->user()->id
        ]);


        if (!session()->has('cart')) {
            $this->dispatch('error', 'Erro ao realizar pedido, adicione item ao carrinho!');
            return;
        }


        // if (session()->has('cart')) {
        //     $body = "\nOlá, o cliente " . $this->nome . " " . $this->sobrenome . " acabou de realizar uma compra.\n";
        //     $body .= "\n🚚 Dados do cliente:\n";
        //     $body .= "Nome: " . $this->nome . " " . $this->sobrenome . "\n";
        //     $body .= "CPF: " . $this->cpf . "\n";
        //     $body .= "CEP: " . $this->cep . "\n";
        //     $body .= "Estado: " . $this->estado . "\n";
        //     $body .= "Cidade: " . $this->cidade . "\n";
        //     $body .= "Bairro: " . $this->bairro . "\n";
        //     $body .= "Rua: " . $this->endereco . "\n\n";

        //     $body .= "\n🛒  Itens do Pedido:\n";
        //     foreach (session('cart') as $item) {
        //         $itemTotal = $item['price'] * $item['quantity'];
        //         $body .= $item['quantity'] . "x - " . $item['name'] . " - R$" . $itemTotal . "\n";
        //     }

        //     $body .= "\nTotal: *R$" . $this->total . "*";


        //     $params = array(
        //         'token' => 'wxh3pcrqez0y2low',
        //         'to' => '+5517997534057',
        //         'body' => $body
        //     );

        //     $client = new Client();
        //     $headers = [
        //         'Content-Type' => 'application/x-www-form-urlencoded'
        //     ];
        //     $options = ['form_params' => $params];
        //     $request = new Request('POST', 'https://api.ultramsg.com/instance81323/messages/chat', $headers);
        //     $res = $client->sendAsync($request, $options)->wait();

        //     if ($res->getStatusCode() == 200) {
        //         $this->dispatch('enviado', 'Pedido realizado com sucesso, entraremos em contato!');
        //         $this->limparDados();
        //         $this->limparCarrinho();
        //     } else {
        //         $this->dispatch('error', 'Erro ao realizar pedido, tente novamente!');
        //     }
        // } else {
        //     $this->dispatch('error', 'Erro ao realizar pedido, seu carrinho está vazio.');
        // }
    }

    public function pagar()
    {

        if (!session()->has('cart')) {
            $this->dispatch('error', 'Erro ao realizar pedido, adicione item ao carrinho!');
            return null;
        }

        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACESSTOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $cart = session()->get('cart');

        $itemsArray = [];


        foreach ($cart as $item) {
            // Cria um array associativo para cada item
            $itemToArray = [
                "title" => $item['name'],
                "quantity" => $item['quantity'],
                "unit_price" => floatval($item['price']),
            ];

            $itemsArray[] = $itemToArray;
        }


        $this->dispatch('applyCodeInUser');
        // dd('ok');
        try {


            $client = new PreferenceClient();
            $preference = $client->create([
                "back_urls" => [
                    "success" => "http://localhost:8989",
                    "failure" => "http://localhost:8989",
                    // "pending" => "http://localhost:8000/pending"
                ],
                "items" => $itemsArray,
            ]);


            return redirect($preference->sandbox_init_point);
        } catch (MPApiException $e) {
            echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
            echo "Content: ";
            var_dump($e->getApiResponse()->getContent());
            echo "\n";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function limparDados(): void
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

    public function deletePessoa($id)
    {
        Pessoa::findOrfail($id)->delete();
        $this->dispatch('enviado', 'Pessoa deletada com sucesso!');
    }

    public function render(): View
    {
        return view('livewire.shop.show-cart');
    }
}
