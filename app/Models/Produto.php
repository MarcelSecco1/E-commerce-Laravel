<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'preco', 'descricao', 'imagem', 'ativo', 'category_id'];
    use HasFactory;

    public function likes()
    {
        return $this->hasMany(LikeProduto::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
