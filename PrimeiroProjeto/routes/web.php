<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;

// Rotas públicas (qualquer um pode ver)
Route::get('/', [AnimalController::class, 'index'])->name('animais.index');
Route::get('/animais/{id}', [AnimalController::class, 'show'])->name('animais.show');

// ========== ROTAS DE AUTENTICAÇÃO ==========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.processar');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.processar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ROTA INICIAL ==========
Route::get('/', function () {
    return redirect()->route('animais.index');
});

// ========== ROTAS DO SISTEMA ==========
Route::resource('especies', EspecieController::class);
Route::resource('animais', AnimalController::class);

// Rotas protegidas (requerem login)
Route::middleware(['auth'])->group(function () {
    Route::get('/animais/create', [AnimalController::class, 'create'])->name('animais.create');
    Route::post('/animais', [AnimalController::class, 'store'])->name('animais.store');
    Route::get('/animais/{id}/edit', [AnimalController::class, 'edit'])->name('animais.edit');
    Route::put('/animais/{id}', [AnimalController::class, 'update'])->name('animais.update');
    Route::delete('/animais/{id}', [AnimalController::class, 'destroy'])->name('animais.destroy');
});

// ========== ROTA PARA BUSCAR VACINAS POR ESPÉCIE ==========
Route::get('/buscar-vacinas/{especieId}', function ($especieId) {
    $vacinas = App\Models\Vacina::where('especie_id', $especieId)
                 ->select('id', 'nome')
                 ->get();
    return response()->json($vacinas);
});

use App\Http\Controllers\AdocaoController;

// Rotas de adoção (protegidas)
Route::middleware(['auth'])->group(function () {
    Route::post('/animal/{animal}/solicitar-adocao', [AdocaoController::class, 'solicitar'])->name('solicitar-adocao');
    Route::post('/animal/{animal}/favoritar', [AdocaoController::class, 'favoritar'])->name('favoritar');
    Route::get('/notificacoes', [AdocaoController::class, 'notificacoes'])->name('notificacoes');
    Route::post('/adocao/{adocao}/responder', [AdocaoController::class, 'responder'])->name('responder-adocao');
    Route::get('/minhas-solicitacoes', [AdocaoController::class, 'minhasSolicitacoes'])->name('minhas-solicitacoes');
    Route::get('/solicitacoes-recebidas', [AdocaoController::class, 'solicitacoesRecebidas'])->name('solicitacoes-recebidas');
});