@extends('adminlte::page')

@section('title', 'Detalhes da Transferência')

@section('content_header')
    <h1>Detalhes da Transferência</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Origem:</strong> {{ $transferencia->origem }}</p>
            <p><strong>Destino:</strong> {{ $transferencia->destino }}</p>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($transferencia->data_transferencia)->format('d/m/Y H:i') }}</p>
            
            <p><strong>Funcionário:</strong> {{ $transferencia->funcionario->nome }}</p>
            <p><strong>Observação:</strong> {{ $transferencia->observacao }}</p>

            <h4>Produtos</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transferencia->produtos as $produto)
                    <tr>
                        <td>{{ $produto->produto->nome }}</td>
                        <td>{{ $produto->quantidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
             <a href="{{ route('transferencias.edit', $transferencia) }}" class="btn btn btn-warning">Editar</a>
            <a href="{{ route('transferencias.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
@stop