{{-- resources/views/transferencias/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Transferência</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $transferencia->id }}</p>
            <p><strong>Produto:</strong> {{ $transferencia->produto->nome }}</p>
            <p><strong>Quantidade:</strong> {{ $transferencia->quantidade }}</p>
            <p><strong>Data:</strong> {{ $transferencia->data_transferencia->format('d/m/Y') }}</p>
            <p><strong>Origem:</strong> {{ $transferencia->origem }}</p>
            <p><strong>Destino:</strong> {{ $transferencia->destino }}</p>
            <p><strong>Observação:</strong> {{ $transferencia->observacao ?? 'Nenhuma' }}</p>
            <p><strong>Funcionário:</strong> {{ $transferencia->funcionario->nome }}</p>
        </div>
    </div>
    
    <a href="{{ route('transferencias.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection