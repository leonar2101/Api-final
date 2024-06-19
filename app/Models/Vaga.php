<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{

    protected $table = 'vagas';
    protected $fillable = [
        'titulo', 'descricao', 'empresa_id', 'status',
    ];

    // Relacionamento com a empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
