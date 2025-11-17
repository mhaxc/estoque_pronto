<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $empresa ?? 'Sistema de Estoque' }} - Relatório</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color:#000; margin: 30px; }
        header { text-align: center; margin-bottom: 8px; }
        .empresa { font-size: 14px; font-weight: 700; }
        .sub { font-size: 11px; color: #444; margin-bottom: 10px; }
        h3 { margin-top: 12px; margin-bottom: 6px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 11px; }
        th { background: #f2f2f2; text-align: left; }
        .small { font-size: 10px; color: #333; }
        footer { position: fixed; bottom: 0; left: 0; right: 0; height: 30px; text-align: center; font-size: 10px; color: #666; }
        .chart { text-align: center; margin-bottom: 12px; }
    </style>
</head>
<body>

<header>
    <div class="empresa">{{ $empresa ?? 'Sistema de Estoque' }}</div>
    <div class="sub">Relatório de Entradas / Saídas / Transferências</div>
    <div class="sub small">Gerado em: {{ now()->format('d/m/Y H:i') }}</div>
</header>

<main>
    <h3>Produtos mais saídos (top)</h3>
    <div class="chart">
        <img src="{{ $chartProdutosUrl }}" alt="Gráfico produtos" style="max-width:100%; height:auto;">
    </div>

    <h3>Entradas</h3>
    <table>
        <thead>
            <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
        </thead>
        <tbody>
        @foreach($entradas as $e)
            <tr>
                <td>{{ $e->produto->nome ?? '—' }}</td>
                <td>{{ $e->quantidade }}</td>
                <td>{{ $e->funcionario->nome ?? '—' }}</td>
                <td>{{ $e->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Saídas</h3>
    <table>
        <thead>
            <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
        </thead>
        <tbody>
        @foreach($saidas as $s)
            <tr>
                <td>{{ $s->produto->nome ?? '—' }}</td>
                <td>{{ $s->quantidade }}</td>
                <td>{{ $s->funcionario->nome ?? '—' }}</td>
                <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Transferências</h3>
    <table>
        <thead>
            <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
        </thead>
        <tbody>
        @foreach($transferencias as $t)
            <tr>
                <td>{{ $t->produto->nome ?? '—' }}</td>
                <td>{{ $t->quantidade }}</td>
                <td>{{ $t->funcionario->nome ?? '—' }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

<footer>
    {{ $empresa ?? 'Sistema de Estoque' }} — Página <span class="page"></span>
</footer>

<!-- script para mostrar número de página (Dompdf usa um marcador especial) -->
<script type="text/php">
if (isset($pdf)) {
    $font = $fontMetrics->getFont("DejaVuSans", "normal");
    $pdf->page_text(520, 820, "Página {PAGE_NUM} / {PAGE_COUNT}", $font, 9, array(0,0,0));
}
</script>

</body>
</html>
