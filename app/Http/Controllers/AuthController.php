<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Login de usuário
    public function loginUsuario(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);

        $usuario = Usuarios::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $usuario->createToken('Token de Acesso')->plainTextToken;

        return response()->json(['usuario' => $usuario, 'token' => $token], 200);
    }

    // Logout de usuário
    public function logoutUsuario(Request $request)
    {
        // Extrair o token Bearer do cabeçalho da requisição
        $token = $request->bearerToken();

        // Verificar se o token foi encontrado
        if (!$token) {
            return response()->json(['mensagem' => 'Token não fornecido'], 400);
        }

        // Encontrar o token no banco de dados e deletá-lo
        $tokenModel = PersonalAccessToken::findToken($token);

        if ($tokenModel) {
            $tokenModel->delete();
            return response()->json(['mensagem' => 'Logout realizado com sucesso'], 200);
        } else {
            return response()->json(['mensagem' => 'Token inválido ou já expirado'], 401);
        }
    }

    // Login de empresa
    public function loginEmpresa(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);

        $empresa = Empresa::where('email', $request->email)->first();

        if (!$empresa || !Hash::check($request->senha, $empresa->senha)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $empresa->createToken('Token de Acesso')->plainTextToken;

        return response()->json(['empresa' => $empresa, 'token' => $token], 200);
    }

    // Logout de empresa
    public function logoutEmpresa(Request $request)
    {
        // Extrair o token Bearer do cabeçalho da requisição
        $token = $request->bearerToken();

        // Verificar se o token foi encontrado
        if (!$token) {
            return response()->json(['mensagem' => 'Token não fornecido'], 400);
        }

        // Encontrar o token no banco de dados e deletá-lo
        $tokenModel = PersonalAccessToken::findToken($token);

        if ($tokenModel) {
            $tokenModel->delete();
            return response()->json(['mensagem' => 'Logout realizado com sucesso'], 200);
        } else {
            return response()->json(['mensagem' => 'Token inválido ou já expirado'], 401);
        }
    }
}
