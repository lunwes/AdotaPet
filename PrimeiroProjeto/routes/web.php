<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\AnimalController;

Route::get('/paginainicial', function () {
    return view('welcome');
});

Route::get('/exercicio', function() {
    return view('exercicio');
});

Route::post('/resposta', function(Request $request) {
    $valor1 = $request->input('valor1');
    $valor2 = $request->input('valor2');
    $soma = $valor1 + $valor2;
    return("A soma é: $soma");
});

Route::resource('especies', EspecieController::class);

Route::resource('animais', AnimalController::class);