<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Empresa extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'nome', 'email', 'senha',
    ];

    protected $hidden = [
        'senha',
    ];
}
