<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\Saida;
use App\Models\Transferencia;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL DE PRODUTOS
        $totalProdutos = Produto::count('preco');
         
        $total = Produto::sum('estoque_atual');
        
       

        // PRODUTOS EM BAIXA (estoque <= mínimo)
        $produtosBaixa = Produto::whereColumn('estoque_atual', '<=', 'estoque_minimo')->get();
            
        // TOTAL DE ENTRADAS
        $totalEntrada = Entrada::count('quantidade');

        // TOTAL DE SAÍDAS
        $totalSaida = Saida::count('quantidade');

        // TOTAL DE TRANSFERÊNCIAS
        $totalTransferencias = Transferencia::count('quantidade');

        return view('dashboard', compact(
            'totalProdutos',
            'produtosBaixa',
            'totalEntrada',
            'totalSaida',
            'totalTransferencias',
            'total'
            

        ));
    }
}
