@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Detalhes da Entrada #{{ $entrada->id }}</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>Produto:</strong> {{ $entrada->produto->nome }}</p>
            <p><strong>Quantidade:</strong> {{ $entrada->quantidade }}</p>
            <p><strong>Data de Entrada:</strong> {{ $entrada->data_entrada->format('d/m/Y') }}</p>
            <p><strong>Funcionário:</strong> {{ $entrada->funcionario->nome }}</p>
            <p><strong>Número da Nota:</strong> {{ $entrada->numero_nota ?? 'N/A' }}</p>
            <p><strong>Observação:</strong> {{ $entrada->observacao ?? 'Nenhuma' }}</p>
            <p><strong>Criado em:</strong> {{ $entrada->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    
    <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
</div>
@endsection