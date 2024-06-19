<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }

    // Mostrar um usuário específico
    public function show($id)
    {
        $usuario = Usuarios::findOrFail($id);
        return response()->json($usuario);
    }

    // Criar um novo usuário
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|unique:usuarios|max:255',
            'senha' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario = Usuarios::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
        ]);

        return response()->json($usuario, 201);
    }

    // Atualizar um usuário existente
    public function update(Request $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'senha' => 'sometimes|required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => isset($request->senha) ? bcrypt($request->senha) : $usuario->senha,
        ]);

        return response()->json($usuario, 200);
    }

    // Excluir um usuário existente
    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();
        return response()->json(null, 204);
    }
}
