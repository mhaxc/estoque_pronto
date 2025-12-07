<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\EntradaProduto;
use App\Models\Categoria;
use App\Models\Transferencia;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RelatorioExport;
use App\Models\SaidaItem;
use App\Models\TransferenciaItem;
use Illuminate\Support\Str;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $funcionarios = Funcionario::all();
        $produtos = Produto::all();
        $categorias = Categoria::all();

        $dados = null;

        if ($request->filled('tipo')) {
            $dados = $this->filtrar($request);
            
        }

        return view('relatorios.index', compact('funcionarios','produtos','categorias','dados'));
    }

    private function filtrar($request)
    {
        $tipo = $request->tipo;
        $funcionario = $request->funcionario_id;
        $produto = $request->produto_id;
        $categoria = $request->categoria_id;
        $inicio = $request->data_inicio;
        $fim = $request->data_fim;

        if ($tipo == 'entrada') {
            $query = EntradaProduto::with(['produto.categoria', 'entrada.funcionario']);

            if ($funcionario) {
                $query->whereHas('entrada', fn($q) =>
                    $q->where('funcionario_id', $funcionario)
                );
            }

            if ($produto) $query->where('produto_id', $produto);

            if ($categoria) {
                $query->whereHas('produto', fn($q) =>
                    $q->where('categoria_id', $categoria)
                );
            }

            if ($inicio && $fim) {
                $query->whereHas('entrada', fn($q) =>
                    $q->whereBetween('data_entrada', [$inicio, $fim])
                );
            }

            return $query->get();
        }

        if ($tipo == 'saida') {
            $query = SaidaItem::with(['produto.categoria', 'saida.funcionario']);

            if ($funcionario) {
                $query->whereHas('saida', fn($q) =>
                    $q->where('funcionario_id', $funcionario)
                );
            }

            if ($produto) $query->where('produto_id', $produto);

            if ($categoria) {
                $query->whereHas('produto', fn($q) =>
                    $q->where('categoria_id', $categoria)
                );
            }

            if ($inicio && $fim) {
                $query->whereHas('saida', fn($q) =>
                    $q->whereBetween('data_saida', [$inicio, $fim])
                );
            }

            return $query->get();
        }

        if ($tipo == 'transferencia') {
            $query = TransferenciaItem::with(['produto.categoria', 'transferencia.funcionario']);

            if ($funcionario) {
                $query->whereHas('transferencia', fn($q) =>
                    $q->where('funcionario_id', $funcionario)
                );
            }

            if ($produto) $query->where('produto_id', $produto);

            if ($categoria) {
                $query->whereHas('produto', fn($q) =>
                    $q->where('categoria_id', $categoria)
                );
            }

            if ($inicio && $fim) {
                $query->whereHas('transferencia', fn($q) =>
                    $q->whereBetween('data_transferencia', [$inicio, $fim])
                );
            }

            return $query->get();
        }
    }
}
