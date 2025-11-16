@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Saída #{{ $saida->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Produto:</strong> {{ $saida->produto->nome }}</p>
            <p><strong>Quantidade:</strong> {{ $saida->quantidade }}</p>
            <p><strong>Data:</strong> {{ $saida->data_saida->format('d/m/Y') }}</p>
            <p><strong>Valor:</strong> R$ {{ number_format($saida->valor, 2, ',', '.') }}</p>
            <p><strong>Funcionário:</strong> {{ $saida->funcionario->nome }}</p>
            <p><strong>Observação:</strong> {{ $saida->observacao ?? 'Nenhuma' }}</p>
            <p><strong>Registrado em:</strong> {{ $saida->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('saidas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection