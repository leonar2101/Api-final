<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VagaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function(){
    return 'Bem vindo a API - Portal de Vagas web servidor LARAVEL';
});

Route::get('/teste', function(){
    return 'teste funcionamento API';
});

// Rotas de autenticação ok
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::post('/usuarios/login', [AuthController::class, 'loginUsuario']);
Route::post('/usuarios/logout', [AuthController::class, 'logoutUsuario']);
Route::post('/empresa', [EmpresaController::class, 'store']);
Route::post('/empresa/login', [AuthController::class, 'loginEmpresa']);
Route::post('/empresa/logout', [AuthController::class, 'logoutEmpresa']);

// Rotas que exigem autenticação Sanctum
//teste grupo ok autentificação

Route::middleware('auth:sanctum')->group(function () {
    // Rotas para usuários ok
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

    // Rotas para empresas ok
    Route::get('/empresas', [EmpresaController::class, 'index']);
    Route::get('/empresas/{id}', [EmpresaController::class, 'show']);
    Route::put('/empresas/{id}', [EmpresaController::class, 'update']);
    Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy']);

    // Rotas para vagas ok
    Route::get('/vagas', [VagaController::class, 'index']);
    Route::get('/vagas/{id}', [VagaController::class, 'show']);
    Route::post('/vagas', [VagaController::class, 'store']);
    Route::put('/vagas/{id}', [VagaController::class, 'update']);
    Route::delete('/vagas/{id}', [VagaController::class, 'destroy']);

    // Rotas para candidaturas ok
    Route::post('/candidaturas', [CandidaturaController::class, 'store']);
    Route::get('/candidaturas', [CandidaturaController::class, 'index']);

    // Rotas para mensagens test
    Route::get('/mensagens', [MensagemController::class, 'index']);
    Route::post('/mensagens', [MensagemController::class, 'store']);
});

