<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeProduto extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'produto_id'];

    // Relacionamento com o usuário que deu o like
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o produto que recebeu o like
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    
}
