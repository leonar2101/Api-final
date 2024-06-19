<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';
    protected $fillable = [
        'remetente_id', 'destinatario_id', 'mensagem',
    ];

    // Relacionamento com usuário (remetente) e empresa (destinatário)
    public function remetente()
    {
        return $this->belongsTo(Usuarios::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(Empresa::class, 'destinatario_id');
    }
}

