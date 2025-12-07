<?php

namespace App\Http\Controllers;

use App\Models\EntradaProduto;
use App\Models\SaidaItem;
use App\Models\TransferenciaItem;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioExportController extends Controller
{
    public function pdf(Request $request)
    {
        $dados = $this->filtrar($request);

        $pdf = PDF::loadView('relatorios.pdf', [
            'dados' => $dados,
            'tipo' => $request->tipo
        ]);

        return $pdf->stream('relatorio.pdf');
    }

    public function excel(Request $request)
    {
        $dados = $this->filtrar($request);

        return Excel::download(new \App\Exports\RelatorioExport($dados, $request->tipo), 'relatorio.xlsx');
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
            if ($categoria) $query->whereHas('produto', fn($q)=>$q->where('categoria_id',$categoria));

            if ($inicio && $fim) {
                $query->whereHas('entrada', fn($q)=>
                    $q->whereBetween('data_entrada', [$inicio, $fim])
                );
            }

            return $query->get();
        }

        if ($tipo == 'saida') {
            $query = SaidaItem::with(['produto.categoria', 'saida.funcionario']);

            if ($funcionario) {
                $query->whereHas('saida', fn($q)=>
                    $q->where('funcionario_id', $funcionario)
                );
            }
            if ($produto) $query->where('produto_id',$produto);
            if ($categoria) $query->whereHas('produto',fn($q)=>$q->where('categoria_id',$categoria));

            if ($inicio && $fim) {
                $query->whereHas('saida', fn($q)=>
                    $q->whereBetween('data_saida',[$inicio,$fim])
                );
            }

            return $query->get();
        }

        if ($tipo == 'transferencia') {
            $query = TransferenciaItem::with(['produto.categoria','transferencia.funcionario']);

            if ($funcionario) {
                $query->whereHas('transferencia',fn($q)=>
                    $q->where('funcionario_id',$funcionario)
                );
            }
            if ($produto) $query->where('produto_id',$produto);
            if ($categoria) $query->whereHas('produto',fn($q)=>$q->where('categoria_id',$categoria));

            if ($inicio && $fim) {
                $query->whereHas('transferencia',fn($q)=>
                    $q->whereBetween('data_transferencia',[$inicio,$fim])
                );
            }

            return $query->get();
        }
    }
}
