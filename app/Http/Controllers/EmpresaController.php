<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    // Listar todas as empresas
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    // Mostrar uma empresa específica
    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
    }

    // Criar uma nova empresa
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:empresas|max:255',
            'senha' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $empresa = Empresa::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
        ]);

        return response()->json($empresa, 201);
    }

    // Atualizar uma empresa existente
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:empresas,email,' . $empresa->id,
            'senha' => 'sometimes|required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $empresa->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => isset($request->senha) ? bcrypt($request->senha) : $empresa->senha,
        ]);

        return response()->json($empresa, 200);
    }

    // Excluir uma empresa existente
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return response()->json(null, 204);
    }
}
