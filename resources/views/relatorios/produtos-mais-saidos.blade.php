@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <h3>Produtos mais saídos</h3>

    <form method="GET" class="form-inline mb-3">
        <div class="form-group mr-2">
            <label> Mês </label>
            <input type="month" name="mesano" class="form-control ml-2" value="{{ request('mesano', now()->format('Y-m')) }}">
        </div>
        <button class="btn btn-primary ml-2">Filtrar</button>
    </form>

    <canvas id="chartProdutos" style="max-height:300px"></canvas>

    <table class="table table-bordered mt-3">
        <thead>
            <tr><th>Produto</th><th>Total Saído</th></tr>
        </thead>
        <tbody>
        @foreach ($produtos as $item)
            <tr><td>{{ $item->produto->nome ?? '-' }}</td><td>{{ $item->total }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('relatorios.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
    <a href="{{ route('relatorios.export.excel') }}" class="btn btn-success">Exportar Excel</a>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($produtos->pluck('produto.nome')->map(fn($v)=> $v ?? '-') ) !!};
    const data = {!! json_encode($produtos->pluck('total')) !!};

    const ctx = document.getElementById('chartProdutos').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Quantidade saída', data }] },
        options: { responsive:true, maintainAspectRatio:false }
    });
</script>
@endsection
