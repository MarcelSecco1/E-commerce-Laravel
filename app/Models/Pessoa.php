<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'bairro',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
