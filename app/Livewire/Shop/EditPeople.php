<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

class EditPeople extends Component
{
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

    public Pessoa $people;

    public function mount($id)
    {
        $this->people = Pessoa::findOrFail($id);
        $this->cep = $this->people->cep;
        $this->estado = $this->people->estado;
        $this->bairro = $this->people->bairro;
        $this->nome = $this->people->nome;
        $this->cidade = $this->people->cidade;
        $this->endereco = $this->people->endereco;
        $this->sobrenome = $this->people->sobrenome;
        $this->cpf = $this->people->cpf;
    }

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
                $this->limpaDados();
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

    private function limpaDados(): void
    {
        $this->bairro = '';
        $this->estado = '';
        $this->cidade = '';
    }
    public function editPeople(){
        // $this->validate();
        $this->people->update([
            'cep' => $this->cep,
            'estado' => $this->estado,
            'bairro' => $this->bairro,
            'nome' => $this->nome,
            'cidade' => $this->cidade,
            'endereco' => $this->endereco,
            'sobrenome' => $this->sobrenome,
            'cpf' => $this->cpf,
        ]);

        
        $this->dispatch('enviado', 'Pessoa atualizada com sucesso!');
       
    }

    public function render()
    {
        return view('livewire.shop.edit-people');
    }
}
