<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SaidaController;
use App\Http\Controllers\RelatorioController;


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/', function () {
    return view('dashboard');
});
  
    Route::resource('categorias', CategoriaController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('saidas', SaidaController::class);
    Route::resource('entradas', EntradaController::class);
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('movimentacoes', EntradaController::class);
    Route::resource('transferencias', transferenciaController::class);
    
  
     Route::get('/relatorios/produtos', [RelatorioController::class, 'produtos'])->name('relatorios.produtos');
    Route::get('/relatorios/produtos/pdf', [RelatorioController::class, 'exportarPDF'])->name('relatorios.produtos.pdf');
    Route::get('/relatorios/produtos/excel', [RelatorioController::class, 'exportarExcel'])->name('relatorios.produtos.excel');
   
});

require __DIR__.'/auth.php';
