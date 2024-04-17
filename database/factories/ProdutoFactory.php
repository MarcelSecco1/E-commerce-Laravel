<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'preco' => $this->faker->randomFloat(2, 0, 100),
            'descricao' => $this->faker->text,
            'imagem' => '01HRE4HSVT3K5D3BRFK3CKE8NY.jpg',
            'ativo' => 1,

        ];
    }
}
