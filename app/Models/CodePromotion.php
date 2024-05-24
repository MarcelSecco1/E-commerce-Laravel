<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePromotion extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount', 'limit_usage_per_user', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
