@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4">Relatório de Produtos</h2>

    <form method="GET" action="{{ route('relatorios.produtos') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Data Inicial</label>
            <input type="date" name="data_inicial" class="form-control" value="{{ request('data_inicial') }}">
        </div>
        <div class="col-md-3">
            <label>Data Final</label>
            <input type="date" name="data_final" class="form-control" value="{{ request('data_final') }}">
        </div>
        <div class="col-md-3">
            <label>Nome do Produto</label>
            <input type="text" name="nome" class="form-control" placeholder="Ex: Areia Fina" value="{{ request('nome') }}">
        </div>
        <div class="col-md-3">
            <label>Categoria</label>
            <input type="text" name="categoria" class="form-control" placeholder="Ex: Brita" value="{{ request('categoria') }}">
        </div>

        <div class="col-12 d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary me-2">Filtrar</button>
            <a href="{{ route('relatorios.produtos.pdf', request()->all()) }}" class="btn btn-danger me-2">Exportar PDF</a>
            
            <a href="{{ route('relatorios.produtos.excel', request()->all()) }}" class="btn btn-success">Exportar Excel</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->categoria }}</td>
                    <td>{{ $produto->Quantidade }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($produto->data)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Nenhum produto encontrado</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
