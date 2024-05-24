<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code_promotions_id', 'used'];
}
