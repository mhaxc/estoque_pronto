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


Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
  
});
  
    Route::resource('categorias', CategoriaController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('saidas', SaidaController::class);
    Route::resource('entradas', EntradaController::class);
    Route::resource('funcionarios', FuncionarioController::class);
    Route::resource('movimentacoes', EntradaController::class);
    Route::resource('transferencias', transferenciaController::class);
    
  
    
    Route::prefix('relatorios')->group(function () {

    Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');

    Route::get('/produtos-mais-saidos', [RelatorioController::class, 'produtosMaisSaidos'])->name('relatorios.produtos-mais-saidos');

    Route::get('/movimentacoes', [RelatorioController::class, 'movimentacoes'])->name('relatorios.movimentacoes');

    Route::get('/export/pdf', [RelatorioController::class, 'exportPDF'])->name('relatorios.export.pdf');

    Route::get('/export/excel', [RelatorioController::class, 'exportExcel'])->name('relatorios.export.excel');

});

require __DIR__.'/auth.php';
