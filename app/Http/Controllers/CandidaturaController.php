<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatura;
use Illuminate\Support\Facades\Validator;

class CandidaturaController extends Controller
{
    // Retorna todas as candidaturas cadastradas
    public function index()
    {
        $candidaturas = Candidatura::all();
        return response()->json(['data' => $candidaturas], 200);
    }

    // Retorna os detalhes de uma candidatura específica
    public function show($id)
    {
        $candidatura = Candidatura::find($id);
        if (!$candidatura) {
            return response()->json(['message' => 'Candidatura não encontrada'], 404);
        }
        return response()->json(['data' => $candidatura], 200);
    }

    // Cria uma nova candidatura
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer',
            'vaga_id' => 'required|integer',
            'mensagem' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidatura = Candidatura::create($request->only(['usuario_id', 'vaga_id', 'mensagem']));

        return response()->json(['data' => $candidatura], 201);
    }

    // Atualiza os detalhes de uma candidatura existente
    public function update(Request $request, $id)
    {
        $candidatura = Candidatura::find($id);
        if (!$candidatura) {
            return response()->json(['message' => 'Candidatura não encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'mensagem' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $candidatura->fill($request->only('mensagem'))->save();

        return response()->json(['data' => $candidatura], 200);
    }

    // Remove uma candidatura existente
    public function destroy($id)
    {
        $candidatura = Candidatura::find($id);
        if (!$candidatura) {
            return response()->json(['message' => 'Candidatura não encontrada'], 404);
        }

        $candidatura->delete();

        return response()->json(['message' => 'Candidatura removida com sucesso'], 204);
    }
}
