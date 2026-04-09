<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;

// ========== ROTAS DE AUTENTICAÇÃO ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.processar');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.processar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ROTA INICIAL ==========
Route::get('/', function () {
    return redirect()->route('animais.index');
});

// ========== ROTAS DO SISTEMA ==========
Route::resource('especies', EspecieController::class);
Route::resource('animais', AnimalController::class);

// ========== ROTA PARA BUSCAR VACINAS POR ESPÉCIE ==========
Route::get('/buscar-vacinas/{especieId}', function ($especieId) {
    $vacinas = App\Models\Vacina::where('especie_id', $especieId)
                 ->select('id', 'nome')
                 ->get();
    return response()->json($vacinas);
});