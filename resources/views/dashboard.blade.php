@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<style>
    /* CSS Reset e Paleta de Cores Moderna */
    :root {
        --primary: #4361ee;
        --primary-light: #5a75ff;
        --primary-dark: #2a4dcc;
        --success: #06d6a0;
        --success-light: #0ef7c2;
        --success-dark: #04b482;
        --info: #118ab2;
        --info-light: #17a8d6;
        --info-dark: #0d6e8f;
        --warning: #ff9e00;
        --warning-light: #ffb238;
        --warning-dark: #cc7e00;
        --danger: #ef476f;
        --danger-light: #ff5c85;
        --danger-dark: #d9345d;
        --dark: #2b2d42;
        --light: #f8f9fa;
        --border-radius: 12px;
        --box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        --print: #3a506b;
    }

    /* Override das cores do AdminLTE para os cards */
    .bg-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, var(--info) 0%, var(--info-light) 100%) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, var(--warning) 0%, var(--warning-light) 100%) !important;
    }

    /* Cards de métricas - Estilo moderno */
    .small-box {
        border-radius: var(--border-radius) !important;
        border: none !important;
        box-shadow: var(--box-shadow) !important;
        transition: all 0.3s ease !important;
        overflow: hidden !important;
        margin-bottom: 1.5rem !important;
    }

    .small-box:hover {
        transform: translateY(-5px) scale(1.02) !important;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }

    .small-box .inner {
        padding: 20px !important;
        position: relative !important;
        z-index: 2 !important;
    }

    .small-box .inner h3 {
        font-size: 2.2rem !important;
        font-weight: 800 !important;
        color: white !important;
        margin-bottom: 5px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
    }

    .small-box .inner p {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: rgba(255, 255, 255, 0.9) !important;
        margin-bottom: 0 !important;
        text-transform: uppercase !important;
    }

    .small-box .icon {
        position: absolute !important;
        top: 15px !important;
        right: 15px !important;
        z-index: 1 !important;
        font-size: 70px !important;
        color: rgba(255, 255, 255, 0.15) !important;
        transition: all 0.3s ease !important;
    }

    /* Cards principais */
    .card {
        border-radius: var(--border-radius) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 1.5rem !important;
    }

    .card.card-primary {
        border-top: 4px solid var(--primary) !important;
    }

    .card.card-info {
        border-top: 4px solid var(--info) !important;
    }

    .card.card-warning {
        border-top: 4px solid var(--warning) !important;
    }

    .card.card-success {
        border-top: 4px solid var(--success) !important;
    }

    .card .card-header {
        background: white !important;
        border-bottom: 1px solid #e9ecef !important;
        padding: 1.25rem 1.5rem !important;
        font-weight: 700 !important;
        color: var(--dark) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    /* Tabelas modernas */
    .table {
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    .table thead th {
        background: #f8f9fa !important;
        border: none !important;
        padding: 1rem !important;
        font-weight: 700 !important;
        color: var(--dark) !important;
        text-transform: uppercase !important;
        font-size: 0.85rem !important;
        border-bottom: 2px solid #dee2e6 !important;
    }

    .table tbody td {
        padding: 1rem !important;
        vertical-align: middle !important;
        border-top: 1px solid #f1f3f4 !important;
    }

    .table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05) !important;
    }

    /* Status badges modernos */
    .badge {
        padding: 0.4em 0.8em !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        border-radius: 50px !important;
    }

    /* Botões modernos */
    .btn {
        border-radius: 8px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
    }

    /* Filtros e impressão */
    .dashboard-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 2rem !important;
        padding: 1.5rem !important;
        background: white !important;
        border-radius: var(--border-radius) !important;
        box-shadow: var(--box-shadow) !important;
    }

    .dashboard-header h1 {
        font-weight: 800 !important;
        color: var(--dark) !important;
        margin: 0 !important;
    }

    .dashboard-header .subtitle {
        color: #6c757d !important;
        font-size: 0.95rem !important;
        margin-top: 0.25rem !important;
    }

    .filter-group {
        display: flex !important;
        gap: 0.75rem !important;
        align-items: center !important;
    }

    .filter-select {
        border: 2px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600 !important;
        color: #4a5568 !important;
        background: white !important;
        transition: all 0.3s ease !important;
    }

    .filter-select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1) !important;
        outline: none !important;
    }

    .print-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        padding: 0.5rem 1.25rem !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        background: linear-gradient(135deg, var(--print) 0%, #5c6bc0 100%) !important;
        color: white !important;
        border: none !important;
        cursor: pointer !important;
    }

    .print-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        background: linear-gradient(135deg, #2c3e50 0%, #4a5bb5 100%) !important;
    }

    /* Gráfico compacto */
    .chart-container {
        height: 220px !important;
        width: 100% !important;
    }

    /* Status das movimentações */
    .status-indicator {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        padding: 0.4rem 0.8rem !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
    }

    .status-entrada {
        background: rgba(6, 214, 160, 0.1) !important;
        color: var(--success-dark) !important;
        border-left: 4px solid var(--success) !important;
    }

    .status-saida {
        background: rgba(239, 71, 111, 0.1) !important;
        color: var(--danger-dark) !important;
        border-left: 4px solid var(--danger) !important;
    }

    .status-transferencia {
        background: rgba(255, 158, 0, 0.1) !important;
        color: var(--warning-dark) !important;
        border-left: 4px solid var(--warning) !important;
    }

    /* Produtos em baixa */
    .low-stock-item {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 0.75rem 1rem !important;
        border-bottom: 1px solid #f1f3f4 !important;
    }

    .stock-critical {
        color: var(--danger) !important;
        font-weight: 800 !important;
    }

    .stock-warning {
        color: var(--warning) !important;
        font-weight: 800 !important;
    }

    /* Ações rápidas */
    .quick-actions {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 0.75rem !important;
    }

    .quick-action-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0.5rem !important;
        padding: 0.75rem !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        border: none !important;
        width: 100% !important;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    /* Loading state */
    .loading {
        position: relative !important;
        pointer-events: none !important;
        opacity: 0.7 !important;
    }

    .loading::after {
        content: '' !important;
        position: absolute !important;
        right: 10px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        width: 16px !important;
        height: 16px !important;
        border: 2px solid rgba(255,255,255,0.3) !important;
        border-top: 2px solid white !important;
        border-radius: 50% !important;
        animation: spin 1s linear infinite !important;
    }

    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }

    /* Estilos para impressão */
    @media print {
        .dashboard-header .filter-group,
        .quick-actions,
        .card-footer,
        .print-btn,
        .export-btn-pdf,
        .export-btn-excel {
            display: none !important;
        }
        
        .small-box {
            break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            margin-bottom: 10px !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        .table {
            font-size: 12px !important;
        }
        
        .no-print {
            display: none !important;
        }
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column !important;
            gap: 1rem !important;
            align-items: flex-start !important;
        }
        
        .filter-group {
            width: 100% !important;
            flex-direction: column !important;
            align-items: stretch !important;
        }
        
        .filter-select, .print-btn {
            width: 100% !important;
        }
        
        .small-box .inner h3 {
            font-size: 1.8rem !important;
        }
    }
</style>

<div class="dashboard-header">
    <div>
        <h1>Dashboard de Estoque</h1>
        <div class="subtitle">Visão geral das movimentações e estoque atual | Período: 
            <strong>
                @if($periodo == 'hoje')
                    Hoje ({{ \Carbon\Carbon::now()->format('d/m/Y') }})
                @elseif($periodo == 'semana')
                    Esta Semana ({{ \Carbon\Carbon::now()->startOfWeek()->format('d/m') }} a {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }})
                @elseif($periodo == 'mes')
                    Este Mês ({{ \Carbon\Carbon::now()->format('m/Y') }})
                @else
                    Este Ano ({{ \Carbon\Carbon::now()->format('Y') }})
                @endif
            </strong>
        </div>
    </div>
    
    <div class="filter-group">
        <form method="GET" action="{{ route('dashboard') }}" id="periodoForm" class="mb-0">
            <select name="periodo" class="filter-select" id="periodoSelect">
                <option value="hoje" {{ $periodo == 'hoje' ? 'selected' : '' }}>Hoje</option>
                <option value="semana" {{ $periodo == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                <option value="mes" {{ $periodo == 'mes' ? 'selected' : '' }}>Este Mês</option>
                <option value="ano" {{ $periodo == 'ano' ? 'selected' : '' }}>Este Ano</option>
            </select>
        </form>
        
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>
</div>
@stop

@section('content')

<!-- Primeira linha: Cards de métricas -->
<div class="row mb-4">
    <!-- TOTAL PRODUTOS -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalProdutos }}</h3>
                <p>Total de Produtos</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    <!-- VALOR ESTOQUE -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}</h3>
                <p>Valor Total em Estoque</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <!-- ENTRADAS QTD -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalEntrada }}</h3>
                <p>Entradas (Qtd)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>

    <!-- ENTRADAS VALOR -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>R$ {{ number_format($valorEntrada ?? 0, 2, ',', '.') }}</h3>
                <p>Entradas (Valor)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
        </div>
    </div>

    <!-- SAIDAS QTD -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalSaida }}</h3>
                <p>Saídas (Qtd)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>

    <!-- SAIDAS VALOR -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>R$ {{ number_format($valorSaida ?? 0, 2, ',', '.') }}</h3>
                <p>Saídas (Valor)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <!-- TRANSFERENCIAS QTD -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalTransferencias }}</h3>
                <p>Transferências (Qtd)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>
    </div>

    <!-- TRANSFERENCIAS VALOR -->
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>R$ {{ number_format($valorTransferencias ?? 0, 2, ',', '.') }}</h3>
                <p>Transferências (Valor)</p>
                <small>Período selecionado</small>
            </div>
            <div class="icon">
                <i class="fas fa-truck-loading"></i>
            </div>
        </div>
    </div>
</div>

<!-- Segunda linha: Gráfico -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title m-0">
                    <i class="fas fa-chart-line mr-2"></i>
                    Movimentação Anual ({{ \Carbon\Carbon::now()->format('Y') }})
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartMensal"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terceira linha: MOVIMENTAÇÕES RECENTES (Centralizado) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title m-0">
                    <i class="fas fa-history mr-2"></i>
                    Movimentações Recentes
                    <span class="badge bg-info ml-2">{{ count($ultimasMovimentacoes) }}</span>
                </h3>
            </div>
            <div class="card-body p-0">
                @if(count($ultimasMovimentacoes) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="table-movimentacoes">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Local</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimasMovimentacoes as $mov)
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ \Carbon\Carbon::parse($mov['data'])->format('d/m/Y') }}</div>
                                    <div class="text-muted small">{{ \Carbon\Carbon::parse($mov['data'])->format('H:i') }}</div>
                                </td>
                                <td>
                                    <span class="status-indicator status-{{ strtolower($mov['tipo']) }}">
                                        <i class="fas fa-{{ $mov['tipo'] == 'ENTRADA' ? 'arrow-down' : ($mov['tipo'] == 'SAIDA' ? 'arrow-up' : 'exchange-alt') }} mr-1"></i>
                                        {{ $mov['tipo'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ Str::limit($mov['produto'], 30) }}</div>
                                    <div class="text-muted small">Cód: {{ $mov['codigo'] ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="font-weight-bold {{ $mov['tipo'] == 'ENTRADA' ? 'text-success' : ($mov['tipo'] == 'SAIDA' ? 'text-danger' : 'text-warning') }}">
                                        {{ $mov['tipo'] == 'ENTRADA' ? '+' : ($mov['tipo'] == 'SAIDA' ? '-' : '↔') }}{{ $mov['quantidade'] }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $mov['local'] ?? 'Principal' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Nenhuma movimentação encontrada para o período selecionado.</p>
                </div>
                @endif
            </div>
            @if(count($ultimasMovimentacoes) > 0)
            <div class="card-footer text-right">
                <a href="{{ route('saidas.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list mr-1"></i> Ver Todas as Movimentações
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quarta linha: PRODUTOS EM BAIXA E AÇÕES RÁPIDAS -->
<div class="row">
    <!-- PRODUTOS EM BAIXA -->
    <div class="col-lg-8">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title m-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Produtos em Baixa
                    <span class="badge badge-danger ml-2">{{ $produtosBaixa->count() }}</span>
                </h3>
            </div>
            <div class="card-body p-0">
                @if($produtosBaixa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Estoque</th>
                                <th>Mínimo</th>
                                <th>Diferença</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtosBaixa as $p)
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ Str::limit($p->nome, 25) }}</div>
                                    <div class="text-muted small">Cód: {{ $p->codigo ?? $p->id }}</div>
                                </td>
                                <td>
                                    <span class="{{ $p->estoque_atual < $p->estoque_minimo ? 'stock-critical' : 'stock-warning' }}">
                                        {{ $p->estoque_atual }}
                                    </span>
                                </td>
                                <td>{{ $p->estoque_minimo }}</td>
                                <td>
                                    <span class="{{ ($p->estoque_atual - $p->estoque_minimo) < 0 ? 'text-danger' : 'text-warning' }}">
                                        {{ $p->estoque_atual - $p->estoque_minimo }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <p class="text-muted mb-0">Nenhum produto com estoque baixo</p>
                </div>
                @endif
            </div>
            @if($produtosBaixa->count() > 0)
            <div class="card-footer">
                <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-boxes mr-1"></i> Gerenciar Produtos
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- AÇÕES RÁPIDAS -->
    <div class="col-lg-4">
        <div class="card card-success no-print">
            <div class="card-header">
                <h3 class="card-title m-0">
                    <i class="fas fa-bolt mr-2"></i>
                    Ações Rápidas
                </h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="{{ route('entradas.create') }}" class="quick-action-btn" style="background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%); color: white;">
                        <i class="fas fa-plus-circle"></i>
                        <span>Nova Entrada</span>
                    </a>
                    <a href="{{ route('saidas.create') }}" class="quick-action-btn" style="background: linear-gradient(135deg, var(--danger) 0%, var(--danger-light) 100%); color: white;">
                        <i class="fas fa-minus-circle"></i>
                        <span>Nova Saída</span>
                    </a>
                    <a href="{{ route('transferencias.create') }}" class="quick-action-btn" style="background: linear-gradient(135deg, var(--warning) 0%, var(--warning-light) 100%); color: white;">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Nova Transferência</span>
                    </a>
                    <a href="{{ route('produtos.create') }}" class="quick-action-btn" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
                        <i class="fas fa-box"></i>
                        <span>Novo Produto</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuração do Gráfico
    const ctx = document.getElementById('chartMensal').getContext('2d');
    
    const labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    
    // Dados do gráfico (ajustado para o novo formato)
    const entradas = [
        @for($m=1;$m<=12;$m++)
            {{ $dadosMensaisEntradas->get(sprintf('%02d', $m)) ?? 0 }},
        @endfor
    ];

    const saidas = [
        @for($m=1;$m<=12;$m++)
            {{ $dadosMensaisSaidas->get(sprintf('%02d', $m)) ?? 0 }},
        @endfor
    ];

    const transferencias = [
        @for($m=1;$m<=12;$m++)
            {{ $dadosMensaisTransferencias->get(sprintf('%02d', $m)) ?? 0 }},
        @endfor
    ];

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Entradas',
                    data: entradas,
                    borderColor: '#06d6a0',
                    backgroundColor: 'rgba(6, 214, 160, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#06d6a0',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: 'Saídas',
                    data: saidas,
                    borderColor: '#ef476f',
                    backgroundColor: 'rgba(239, 71, 111, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#ef476f',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: 'Transferências',
                    data: transferencias,
                    borderColor: '#ff9e00',
                    backgroundColor: 'rgba(255, 158, 0, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#ff9e00',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 12,
                            family: "'Segoe UI', sans-serif",
                            weight: '600'
                        },
                        padding: 20,
                        boxWidth: 12,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 12 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 6
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: '600' }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: {
                        font: { size: 11 },
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(1) + 'k';
                            }
                            return value;
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // DataTable para movimentações
    if(window.jQuery && $.fn.DataTable){
        $('#table-movimentacoes').DataTable({
            order: [[0, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json'
            },
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: 4 }
            ]
        });
    }

    // Filtro de período melhorado
    const periodoSelect = document.getElementById('periodoSelect');
    if (periodoSelect) {
        periodoSelect.addEventListener('change', function() {
            // Mostrar loading
            this.classList.add('loading');
            this.disabled = true;
            
            // Mostrar mensagem de carregamento
            const loadingMessage = document.createElement('div');
            loadingMessage.className = 'alert alert-info alert-dismissible fade show mt-3';
            loadingMessage.innerHTML = `
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Carregando dados para o período selecionado...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            
            const header = document.querySelector('.dashboard-header');
            if (header) {
                header.insertAdjacentElement('afterend', loadingMessage);
            }
            
            // Enviar formulário
            document.getElementById('periodoForm').submit();
        });
    }

    // Animar cards ao entrar na página
    const cards = document.querySelectorAll('.small-box');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Função para melhorar a impressão
    window.addEventListener('beforeprint', function() {
        // Adicionar título e data na impressão
        const printHeader = document.createElement('div');
        printHeader.innerHTML = `
            <h2>Dashboard de Estoque - Relatório Impresso</h2>
            <p>Data de impressão: ${new Date().toLocaleDateString('pt-BR')} ${new Date().toLocaleTimeString('pt-BR')}</p>
            <p>Período: ${document.querySelector('.subtitle strong').textContent}</p>
            <hr>
        `;
        printHeader.style.cssText = 'text-align: center; margin-bottom: 20px;';
        document.body.insertBefore(printHeader, document.body.firstChild);
    });

    window.addEventListener('afterprint', function() {
        // Remover o cabeçalho de impressão após imprimir
        const printHeader = document.querySelector('body > div:first-child');
        if (printHeader && printHeader.querySelector('h2')) {
            printHeader.remove();
        }
    });
});

// Adicionar tooltips se o Bootstrap estiver disponível
if (typeof $ !== 'undefined') {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
}
</script>

<!-- Adicionar ícones do Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop