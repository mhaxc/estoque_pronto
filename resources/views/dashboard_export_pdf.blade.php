<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard de Estoque - {{ ucfirst($periodo) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f5f5f5;
            padding: 8px;
            font-weight: bold;
            border-left: 4px solid #333;
            margin-bottom: 10px;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        .metric-card {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .metric-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        .total-row {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
        .status-entrada {
            color: #28a745;
        }
        .status-saida {
            color: #dc3545;
        }
        .status-transferencia {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard de Estoque</h1>
        <div class="subtitle">Relatório do período: {{ ucfirst($periodo) }}</div>
        <div class="subtitle">Gerado em: {{ date('d/m/Y H:i') }}</div>
    </div>

    <!-- Seção: Resumo -->
    <div class="section">
        <div class="section-title">RESUMO DO PERÍODO</div>
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-label">Total de Produtos</div>
                <div class="metric-value">{{ $totalProdutos }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Valor Total em Estoque</div>
                <div class="metric-value">R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Quantidade em Estoque</div>
                <div class="metric-value">{{ $totalQuantidadeEstoque }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Produtos em Alerta</div>
                <div class="metric-value">{{ $produtosBaixa->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Seção: Movimentações -->
    <div class="section">
        <div class="section-title">MOVIMENTAÇÕES DO PERÍODO</div>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Entradas</td>
                    <td>{{ $totalEntrada }}</td>
                    <td>R$ {{ number_format($valorEntrada ?? 0, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Saídas</td>
                    <td>{{ $totalSaida }}</td>
                    <td>R$ {{ number_format($valorSaida ?? 0, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Transferências</td>
                    <td>{{ $totalTransferencias }}</td>
                    <td>R$ {{ number_format($valorTransferencias ?? 0, 2, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Movimentado</strong></td>
                    <td><strong>{{ $totalEntrada + $totalSaida + $totalTransferencias }}</strong></td>
                    <td><strong>R$ {{ number_format(($valorEntrada ?? 0) + ($valorSaida ?? 0) + ($valorTransferencias ?? 0), 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($produtosBaixa->count() > 0)
    <!-- Seção: Produtos em Baixa -->
    <div class="section">
        <div class="section-title">PRODUTOS COM ESTOQUE BAIXO ({{ $produtosBaixa->count() }})</div>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Código</th>
                    <th>Estoque Atual</th>
                    <th>Estoque Mínimo</th>
                    <th>Diferença</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtosBaixa as $p)
                <tr>
                    <td>{{ $p->nome }}</td>
                    <td>{{ $p->codigo ?? $p->id }}</td>
                    <td>{{ $p->estoque_atual }}</td>
                    <td>{{ $p->estoque_minimo }}</td>
                    <td class="{{ ($p->estoque_atual - $p->estoque_minimo) < 0 ? 'status-saida' : 'status-warning' }}">
                        {{ $p->estoque_atual - $p->estoque_minimo }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(count($ultimasMovimentacoes) > 0)
    <!-- Seção: Movimentações Recentes -->
    <div class="section">
        <div class="section-title">ÚLTIMAS MOVIMENTAÇÕES</div>
        <table>
            <thead>
                <tr>
                    <th>Data/Hora</th>
                    <th>Tipo</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasMovimentacoes as $mov)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($mov['data'])->format('d/m/Y H:i') }}</td>
                    <td class="status-{{ strtolower($mov['tipo']) }}">{{ $mov['tipo'] }}</td>
                    <td>{{ $mov['produto'] }}</td>
                    <td>{{ $mov['quantidade'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        Sistema de Gestão de Estoque | Gerado automaticamente em {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>