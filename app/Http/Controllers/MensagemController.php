<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MensagemController extends Controller
{
    // Listar todas as mensagens
    public function index()
    {
        $mensagens = Mensagem::all();
        if ($mensagens->isEmpty()){
            return response()->json(['mensagem' => 'Nao ha mensagens disponiveis'], 200);
        }
        return response()->json(['data' => $mensagens], 200);
    }

    // Mostrar uma mensagem específica
    public function show($id)
    {
        $mensagem = Mensagem::findOrFail($id);
        return response()->json(['data' => $mensagem], 200);
    }

    // Criar uma nova mensagem
    public function store(Request $request)
    {
        $mensagem = Mensagem::created([
            'mensagem' => $request->mensagem,
            'remetente_id' => $request->remetente_id,
            'destinatario_id' => $request->destinatario_id
        ]);
        print_r($mensagem)
        return response()->json(['data' => $mensagem], 201);
    }

    // Atualizar uma mensagem existente
    public function update(Request $request, $id)
    {
        $mensagem = Mensagem::findOrFail($id);

        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mensagem->update($request->only(['mensagem', 'remetente_id', 'destinatario_id']));

        return response()->json(['data' => $mensagem], 200);
    }

    // Excluir uma mensagem existente
    public function destroy($id)
    {
        $mensagem = Mensagem::findOrFail($id);
        $mensagem->delete();
        return response()->json(null, 204);
    }

    // Regras de validação para criação e atualização de mensagem
    protected function getValidationRules()
    {
        return [
            'mensagem' => 'required|string|max:500',
            'remetente_id' => 'required|exists:empresas.id',
            'destinatario_id' => 'required|exists:usuarios.id',
        ];
    }
}
