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
use App\Exports\RelatorioExport;
use Illuminate\Support\Str;

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

    // export PDF minimalista (preto e branco) com rodapé paginado e gráfico de produtos mais saídos
    public function exportPDF(Request $request)
    {
        $dados = $this->gerarDados($request);

        // gerar URL do gráfico de top produtos via QuickChart
        $chartProdutosUrl = $this->gerarChartProdutosMaisSaidos($dados['saidas']);

        $empresa = $request->empresa_nome ?? 'Sistema de Estoque';
        $style = $request->style ?? 'minimalista';

        $pdf = Pdf::loadView('relatorios.pdf', array_merge($dados, [
            'chartProdutosUrl' => $chartProdutosUrl,
            'empresa' => $empresa,
            'style' => $style,
        ]));

        // configurações para permitir fontes Unicode se necessário
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('relatorio_movimentacoes.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new RelatorioExport($request), 'relatorio_movimentacoes.xlsx');
    }

    private function gerarDados(Request $request)
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

    // Monta uma URL de gráfico (PNG) usando QuickChart para inserir no PDF.
    // QuickChart aceita um objeto chartjs codificado em URL.
    private function gerarChartProdutosMaisSaidos($saidasCollection)
    {
        // sumariza por produto nome
        $soma = [];
        foreach ($saidasCollection as $s) {
            $nome = $s->produto->nome ?? ('Produto ' . ($s->produto_id ?? ''));
            if (!isset($soma[$nome])) $soma[$nome] = 0;
            $soma[$nome] += $s->quantidade;
        }

        arsort($soma);
        $top = array_slice($soma, 0, 8, true);

        $labels = array_keys($top);
        $data = array_values($top);

        if (count($labels) === 0) {
            // gráfico vazio (placeholder)
            $labels = ['Nenhum dado'];
            $data = [0];
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Quantidade saída',
                        'data' => $data,
                    ],
                ],
            ],
            'options' => [
                'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => 'Produtos mais saídos (top)',
                ],
                'scales' => [
                    'xAxes' => [['ticks' => ['autoSkip' => false]]],
                ],
            ],
        ];

        $encoded = urlencode(json_encode($chartConfig));
        // quickchart endpoint (retorna PNG)
        return "https://quickchart.io/chart?c={$encoded}&format=png&width=800&height=400";
    }
}
