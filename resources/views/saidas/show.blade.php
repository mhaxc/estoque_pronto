@extends('adminlte::page')

@section('title', 'Ver Saída')

@section('content_header')
    <h1>Ver Saída #{{ $saida->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Funcionário:</strong>
                    <p class="text-muted">{{ $saida->funcionario->nome }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Data da Saída:</strong>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($saida->data_saida)->format('d/m/Y') }}</p>
                </div>
            </div>

            <h5>Produtos</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saida->items as $item)
                        <tr>
                            <td>{{ $item->produto->nome }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total Geral:</th>
                        <th>R$ {{ number_format($saida->items->sum(function($item) {
                            return $item->produto->preco * $item->quantidade;
                        }), 2, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-3">
                <a href="{{ route('saidas.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@stop