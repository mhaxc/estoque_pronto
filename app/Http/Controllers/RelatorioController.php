<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdutosExport;

class RelatorioController extends Controller
{
    public function produtos(Request $request)
    {
        $query = Produto::query();

        // Filtros dinâmicos
        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('data', [$request->data_inicial, $request->data_final]);
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', 'like', '%' . $request->categoria . '%');
        }

        $produtos = $query->orderBy('data', 'desc')->get();

        return view('relatorios.produtos', compact('produtos'));
    }

    public function exportarPDF(Request $request)
    {
        $query = Produto::query();

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('data', [$request->data_inicial, $request->data_final]);
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', 'like', '%' . $request->categoria . '%');
        }

        $produtos = $query->orderBy('data', 'desc')->get();

        $pdf = PDF::loadView('relatorios.produtos_pdf', compact('produtos'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('relatorio_produtos.pdf');
    }

    public function exportarExcel(Request $request)
    {
        return Excel::download(new ProdutosExport(
            $request->data_inicial,
            $request->data_final,
            $request->nome,
            $request->categoria
        ), 'relatorio_produtos.xlsx');
    }
}
