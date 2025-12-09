<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\EntradaProduto;
use App\Models\Saidaitem;
use App\Models\TransferenciaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\DashboardExport;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // FILTRO DE PERÍODO ---------------------------
        $periodo = $request->get('periodo', 'mes'); // hoje | semana | mes | ano

        // Definir datas baseadas no período selecionado
        switch ($periodo) {
            case 'hoje':
                $inicio = Carbon::now()->startOfDay();
                $fim = Carbon::now()->endOfDay();
                break;
            case 'semana':
                $inicio = Carbon::now()->startOfWeek();
                $fim = Carbon::now()->endOfWeek();
                break;
            case 'ano':
                $inicio = Carbon::now()->startOfYear();
                $fim = Carbon::now()->endOfYear();
                break;
            default: // 'mes'
                $inicio = Carbon::now()->startOfMonth();
                $fim = Carbon::now()->endOfMonth();
                break;
        }

        // -----------------------------------------
        //           DADOS BÁSICOS (SEM FILTRO)
        // -----------------------------------------
        $totalProdutos = Produto::count();
        $totalValorEstoque = Produto::sum(DB::raw('preco * estoque_atual'));
        $totalQuantidadeEstoque = Produto::sum('estoque_atual');
        $produtosBaixa = Produto::whereColumn('estoque_atual', '<=', 'estoque_minimo')
            ->orderByRaw('estoque_atual - estoque_minimo ASC')
            ->get();

        // -----------------------------------------
        // ENTRADAS / SAÍDAS / TRANSF. (COM FILTRO DE PERÍODO)
        // -----------------------------------------
        // ENTRADAS
        $totalEntrada = EntradaProduto::whereBetween('created_at', [$inicio, $fim])->sum('quantidade');
        $valorEntrada = EntradaProduto::whereBetween('entrada_produtos.created_at', [$inicio, $fim])
            ->join('produtos', 'produtos.id', '=', 'entrada_produtos.produto_id')
            ->sum(DB::raw('produtos.preco * entrada_produtos.quantidade'));

        // SAÍDAS
        $totalSaida = Saidaitem::whereBetween('created_at', [$inicio, $fim])->sum('quantidade');
        $valorSaida = Saidaitem::whereBetween('saida_items.created_at', [$inicio, $fim])
            ->join('produtos', 'produtos.id', '=', 'saida_items.produto_id')
            ->sum(DB::raw('produtos.preco * saida_items.quantidade'));

        // TRANSFERÊNCIAS
        $totalTransferencias = TransferenciaItem::whereBetween('created_at', [$inicio, $fim])->sum('quantidade');
        $valorTransferencias = TransferenciaItem::whereBetween('transferencia_items.created_at', [$inicio, $fim])
            ->join('produtos', 'produtos.id', '=', 'transferencia_items.produto_id')
            ->sum(DB::raw('produtos.preco * transferencia_items.quantidade'));

        // --------------------------------------------------
        // MOVIMENTAÇÕES RECENTES (últimos 10 registros DO PERÍODO)
        // --------------------------------------------------
        $ultimasMovimentacoes = collect([]);

        // Entradas
        $entradas = EntradaProduto::with('produto')
            ->whereBetween('created_at', [$inicio, $fim])
            ->select('created_at', 'quantidade', 'produto_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($m) => [
                'tipo' => 'ENTRADA',
                'produto' => $m->produto->nome,
                'quantidade' => $m->quantidade,
                'data' => $m->created_at,
                'codigo' => $m->produto->codigo ?? $m->produto->id,
                'local' => 'Principal'
            ]);

        // Saídas
        $saidas = Saidaitem::with('produto')
            ->whereBetween('created_at', [$inicio, $fim])
            ->select('created_at', 'quantidade', 'produto_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($m) => [
                'tipo' => 'SAIDA',
                'produto' => $m->produto->nome,
                'quantidade' => $m->quantidade,
                'data' => $m->created_at,
                'codigo' => $m->produto->codigo ?? $m->produto->id,
                'local' => 'Principal'
            ]);

        // Transferências
        $transferencias = TransferenciaItem::with('produto')
            ->whereBetween('created_at', [$inicio, $fim])
            ->select('created_at', 'quantidade', 'produto_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($m) => [
                'tipo' => 'TRANSFERENCIA',
                'produto' => $m->produto->nome,
                'quantidade' => $m->quantidade,
                'data' => $m->created_at,
                'codigo' => $m->produto->codigo ?? $m->produto->id,
                'local' => 'Principal'
            ]);

        // Juntar tudo e ordenar por data
        $ultimasMovimentacoes = $entradas->merge($saidas)
            ->merge($transferencias)
            ->sortByDesc('data')
            ->take(10)
            ->values(); // Resetar índices

        // -----------------------------------------------
        // GRÁFICO DE LINHA POR MÊS (12 MESES DO ANO ATUAL)
        // -----------------------------------------------
        $anoAtual = Carbon::now()->year;

        // Se for SQLite (strftime)
        if (config('database.default') === 'sqlite') {
            $dadosMensaisEntradas = EntradaProduto::selectRaw('strftime("%m", created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');

            $dadosMensaisSaidas = Saidaitem::selectRaw('strftime("%m", created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');

            $dadosMensaisTransferencias = TransferenciaItem::selectRaw('strftime("%m", created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');
        } else {
            // Para MySQL
            $dadosMensaisEntradas = EntradaProduto::selectRaw('MONTH(created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');

            $dadosMensaisSaidas = Saidaitem::selectRaw('MONTH(created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');

            $dadosMensaisTransferencias = TransferenciaItem::selectRaw('MONTH(created_at) as mes, SUM(quantidade) as total')
                ->whereYear('created_at', $anoAtual)
                ->groupBy('mes')
                ->pluck('total', 'mes');
        }

        // Preencher meses faltantes com 0
        $dadosMensaisEntradas = $this->preencherMesesFaltantes($dadosMensaisEntradas);
        $dadosMensaisSaidas = $this->preencherMesesFaltantes($dadosMensaisSaidas);
        $dadosMensaisTransferencias = $this->preencherMesesFaltantes($dadosMensaisTransferencias);

        return view('dashboard', compact(
            'totalProdutos', 'totalValorEstoque', 'totalQuantidadeEstoque',
            'produtosBaixa', 'totalEntrada', 'totalSaida', 'totalTransferencias',
            'valorEntrada', 'valorSaida', 'valorTransferencias',
            'ultimasMovimentacoes', 'periodo',
            'dadosMensaisEntradas', 'dadosMensaisSaidas', 'dadosMensaisTransferencias'
        ));
    }

    /**
     * Preenche os meses de 1 a 12 com 0 para os que não têm dados.
     */
    private function preencherMesesFaltantes($dados)
    {
        $todosMeses = collect();
        for ($i = 1; $i <= 12; $i++) {
            $mes = str_pad($i, 2, '0', STR_PAD_LEFT);
            $todosMeses[$mes] = $dados->get($mes) ?? 0;
        }
        return $todosMeses;
    }

   public function export(Request $request, $format)
{
    $periodo = $request->periodo ?? 'hoje';

    // === REPLICA OS DADOS DO DASHBOARD ===
    $totalEntrada = EntradaProduto::sum('quantidade');

    $valorEntrada = EntradaProduto::join('produtos', 'produtos.id', '=', 'entrada_produtos.produto_id')
        ->select(DB::raw('SUM(entrada_produtos.quantidade * produtos.preco) as total'))
        ->value('total');

    $totalSaida = Saidaitem::sum('quantidade');

    $valorSaida = Saidaitem::join('produtos', 'produtos.id', '=', 'saida_items.produto_id')
        ->select(DB::raw('SUM(saida_items.quantidade * produtos.preco) as total'))
        ->value('total');

    $produtosBaixoEstoque = Produto::where('quantidade', '<=', 5)->get();

    $dadosExport = [
        'totalEntrada' => $totalEntrada,
        'valorEntrada' => $valorEntrada,
        'totalSaida'   => $totalSaida,
        'valorSaida'   => $valorSaida,
        'baixoEstoque' => $produtosBaixoEstoque,
        'periodo'      => $periodo,
        'data'         => now()->format('d/m/Y H:i'),
    ];

    // === PDF ===
    if ($format === 'pdf') {
        $pdf = \PDF::loadView('dashboard_export_pdf', $dadosExport)
            ->setPaper('a4', 'portrait');

        return $pdf->download('dashboard-estoque-'.$periodo.'-'.date('Y-m-d').'.pdf');
    }

    // === EXCEL ===
    if ($format === 'xlsx') {
        return \Excel::download(
            new DashboardExport($dadosExport),
            'dashboard-estoque-'.$periodo.'-'.date('Y-m-d').'.xlsx'
        );
    }

    abort(404, 'Formato não suportado.');
}

}