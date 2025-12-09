<table border="1">
    <tr><th colspan="4">Relatório Geral do Dashboard</th></tr>
    <tr><td colspan="4">Gerado automaticamente pelo sistema</td></tr>

    <tr><th colspan="4">Informações Gerais</th></tr>
    <tr>
        <th>Total de Produtos</th>
        <td colspan="3">{{ $dadosExport['totalProdutos'] }}</td>
    </tr>
    <tr>
        <th>Valor Total do Estoque</th>
        <td colspan="3">{{ $dadosExport['totalValorEstoque'] }}</td>
    </tr>
    <tr>
        <th>Quantidade Total em Estoque</th>
        <td colspan="3">{{ $dadosExport['totalQuantidadeEstoque'] }}</td>
    </tr>

    <tr><th colspan="4">Entradas</th></tr>
    <tr>
        <th>Total de Entradas</th>
        <td>{{ $dadosExport['totalEntrada'] }}</td>
        <th>Valor Total</th>
        <td>{{ $dadosExport['valorEntrada'] }}</td>
    </tr>

    <tr><th colspan="4">Saídas</th></tr>
    <tr>
        <th>Total de Saídas</th>
        <td>{{ $dadosExport['totalSaida'] }}</td>
        <th>Valor Total</th>
        <td>{{ $dadosExport['valorSaida'] }}</td>
    </tr>

    <tr><th colspan="4">Transferências</th></tr>
    <tr>
        <th>Total de Transferências</th>
        <td>{{ $dadosExport['totalTransferencias'] }}</td>
        <th>Valor Total</th>
        <td>{{ $dadosExport['valorTransferencias'] }}</td>
    </tr>

    <tr><th colspan="4">Produtos em Baixa</th></tr>
    <tr>
        <th>Produto</th>
        <th>Estoque Atual</th>
        <th colspan="2">Estoque Mínimo</th>
    </tr>

    @forelse($dadosExport['produtosBaixa'] as $p)
        <tr>
            <td>{{ $p->nome }}</td>
            <td>{{ $p->estoque_atual }}</td>
            <td colspan="2">{{ $p->estoque_minimo }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Nenhum produto em baixa.</td></tr>
    @endforelse

    <tr><th colspan="4">Movimentações Recentes</th></tr>
    <tr>
        <th>Tipo</th>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Data</th>
    </tr>

    @forelse($dadosExport['ultimasMovimentacoes'] as $m)
        <tr>
            <td>{{ $m['tipo'] }}</td>
            <td>{{ $m['produto'] }}</td>
            <td>{{ $m['quantidade'] }}</td>
            <td>{{ \Carbon\Carbon::parse($m['data'])->format('d/m/Y H:i') }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Nenhuma movimentação encontrada.</td></tr>
    @endforelse
</table>
