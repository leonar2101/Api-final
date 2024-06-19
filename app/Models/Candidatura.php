<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    protected $fillable = [
        'vaga_id', 'usuario_id', 'mensagem', 'status',
    ];

    // Relacionamento com usuário (candidato) e vaga
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }

    public function vaga()
    {
        return $this->belongsTo(Vaga::class);
    }
}

