<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->text('mensagem')->nullable();
            $table->enum('status', ['enviada', 'aceita', 'recusada'])->default('enviada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }

    // Prioridade maior que 1 para garantir execução após a tabela vagas
    public function priority()
    {
        return 2;
    }
};
