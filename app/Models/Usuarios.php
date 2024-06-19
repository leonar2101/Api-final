<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome', 'email', 'senha',
    ];

    protected $hidden = [
        'senha',
    ];

}

