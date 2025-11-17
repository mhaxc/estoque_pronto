<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\Saida;
use App\Models\Transferencia;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    // Produtos mais saídos no mês
    public function produtosMaisSaidos(Request $request)
    {
        $mes = $request->mes ?? now()->format('m');
        $ano = $request->ano ?? now()->format('Y');

        $produtos = Saida::selectRaw('produto_id, SUM(quantidade) as total')
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->groupBy('produto_id')
            ->orderByDesc('total')
            ->with('produto')
            ->get();

        return view('relatorios.produtos-mais-saidos', compact('produtos', 'mes', 'ano'));
    }

    // Movimentações por funcionário + data
    public function movimentacoes(Request $request)
    {
        $funcionario = $request->funcionario_id;
        $inicio = $request->inicio;
        $fim = $request->fim;

        $entradas = Entrada::with('produto', 'funcionario')
            ->when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
            ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
            ->get();

        $saidas = Saida::with('produto', 'funcionario')
            ->when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
            ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
            ->get();

        $transferencias = Transferencia::with('produto', 'funcionario')
            ->when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
            ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
            ->get();

        $funcionarios = Funcionario::all();

        return view('relatorios.movimentacoes', compact(
            'entradas', 'saidas', 'transferencias', 'funcionarios'
        ));
    }

    public function exportPDF(Request $request)
    {
        $dados = $this->gerarDados($request);
        $pdf = Pdf::loadView('relatorios.pdf', $dados);
        return $pdf->download('relatorio.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new \App\Exports\RelatorioExport($request), 'relatorio.xlsx');
    }

    
    
    
    Private function gerarDados(Request $request)
    {
    $funcionario = $request->funcionario_id;
    $inicio = $request->inicio;
    $fim = $request->fim;

    return [
        'entradas' => Entrada::when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
                            ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                            ->with('produto', 'funcionario')
                            ->get(),

        'saidas' => Saida::when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
                         ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                         ->with('produto', 'funcionario')
                         ->get(),

        'transferencias' => Transferencia::when($funcionario, fn($q) => $q->where('funcionario_id', $funcionario))
                                         ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                                         ->with('produto', 'funcionario')
                                         ->get(),
    ];
    }
}
