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
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
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
        }
        .metric-card {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            background-color: #fafafa;
        }
        .metric-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px;
            text-transform: uppercase;
            font-size: 11px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        .total-row {
            font-weight: bold;
            background-color: #efefef;
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
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Dashboard de Estoque</h1>
        <div class="subtitle">Período: {{ ucfirst($periodo) }}</div>
        <div class="subtitle">Gerado em: {{ date('d/m/Y H:i') }}</div>
    </div>

    <!-- ============================= -->
    <!-- RESUMO DO PERÍODO -->
    <!-- ============================= -->
    <div class="section">
        <div class="section-title">RESUMO DO PERÍODO</div>
        <div class="metrics-grid">

            <div class="metric-card">
                <div class="metric-label">Total de Produtos</div>
                <div class="metric-value">{{ $totalProdutos }}</div>
            </div>

            <div class="metric-card">
                <div class="metric-label">Valor Total em Estoque</div>
                <div class="metric-value">
                    R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-label">Quantidade Total em Estoque</div>
                <div class="metric-value">{{ $totalQuantidadeEstoque }}</div>
            </div>

            <div class="metric-card">
                <div class="metric-label">Produtos em Alerta</div>
                <div class="metric-value">{{ $produtosAlerta }}</div>
            </div>

        </div>
    </div>

    <!-- ============================= -->
    <!-- MOVIMENTAÇÕES -->
    <!-- ============================= -->
    <div class="section">
        <div class="section-title">MOVIMENTAÇÕES DO PERÍODO</div>

        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Entradas</td>
                    <td>{{ $totalEntrada }}</td>
                    <td>R$ {{ number_format($valorEntrada, 2, ',', '.') }}</td>
                </tr>

                <tr>
                    <td>Saídas</td>
                    <td>{{ $totalSaida }}</td>
                    <td>R$ {{ number_format($valorSaida, 2, ',', '.') }}</td>
                </tr>

                <tr>
                    <td>Transferências</td>
                    <td>{{ $totalTransferencias }}</td>
                    <td>R$ {{ number_format($valorTransferencias, 2, ',', '.') }}</td>
                </tr>

                <tr class="total-row">
                    <td>Total Geral</td>
                    <td>{{ $totalEntrada + $totalSaida + $totalTransferencias }}</td>
                    <td>
                        R$ {{ number_format($valorEntrada + $valorSaida + $valorTransferencias, 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- PRODUTOS EM BAIXO ESTOQUE -->
    <!-- ============================= -->
    @if($produtosBaixa->count() > 0)
        <div class="section">
            <div class="section-title">
                PRODUTOS COM ESTOQUE BAIXO ({{ $produtosBaixa->count() }})
            </div>

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
                        <td class="status-saida">
                            {{ $p->estoque_atual - $p->estoque_minimo }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- ============================= -->
    <!-- ÚLTIMAS MOVIMENTAÇÕES -->
    <!-- ============================= -->
    @if(count($ultimasMovimentacoes) > 0)
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
        Sistema de Gestão de Estoque — Gerado automaticamente em {{ date('d/m/Y H:i:s') }}
    </div>

</body>
</html>

