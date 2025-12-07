<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\EntradaProduto;
use App\Models\Saidaitem;
use App\Models\Transferencia;
use App\Models\TransferenciaItem;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL DE PRODUTOS CADASTRADOS
        $totalProdutos = Produto::count();
        
        // VALOR TOTAL DO ESTOQUE (soma de preço * estoque_atual)
        $totalValorEstoque = Produto::sum(\DB::raw('preco * estoque_atual'));
        
        // QUANTIDADE TOTAL EM ESTOQUE
        $totalQuantidadeEstoque = Produto::sum('estoque_atual');

        // PRODUTOS EM BAIXA (estoque <= mínimo)
        $produtosBaixa = Produto::whereColumn('estoque_atual', '<=', 'estoque_minimo')->get();
            
        // TOTAL DE QUANTIDADE DE ENTRADAS
        $totalEntrada = EntradaProduto::sum('quantidade');

        // TOTAL DE QUANTIDADE DE SAÍDAS
        $totalSaida = Saidaitem::sum('quantidade');

        // TOTAL DE QUANTIDADE DE TRANSFERÊNCIAS
        $totalTransferencias = TransferenciaItem::sum('quantidade');

        return view('dashboard', compact(
            'totalProdutos',
            'produtosBaixa',
            'totalEntrada',
            'totalSaida',
            'totalTransferencias',
            'totalValorEstoque',
            'totalQuantidadeEstoque'
        ));
    }
}