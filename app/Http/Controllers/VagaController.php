<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VagaController extends Controller
{
    // Listar todas as vagas
    public function index()
    {
        $vagas = Vaga::all();
        if ($vagas->isEmpty()) {
            return response()->json(['mensagem' => 'Nao ha vagas disponiveis'], 200);
        }
        return response()->json($vagas);
    }

    // Mostrar uma vaga específica
    public function show($id)
    {
        $vaga = Vaga::findOrFail($id);
            if (!$vaga) {
                return response()->json(['erro' => 'Vaga nao encontrada'], 404);
            }
        return response()->json($vaga);
    }

    // Criar uma nova vaga
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vaga = Vaga::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'empresa_id' => $request->empresa_id,
        ]);

        return response()->json($vaga, 201);
    }

    // Atualizar uma vaga existente
    public function update(Request $request, $id)
    {
        $vaga = Vaga::findOrFail($id);
        if (!$vaga) {
            return response()->json(['erro' => 'Vaga não encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vaga->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'empresa_id' => $request->empresa_id,
        ]);

        return response()->json($vaga, 200);
    }

    // Excluir uma vaga existente
    public function destroy($id)
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->delete();
        return response()->json(null, 204);
    }
}
