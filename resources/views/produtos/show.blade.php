@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Detalhes do Produto</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $produto->nome }}</h5>
            <p class="card-text"><strong>Descrição:</strong> {{ $produto->descricao ?? 'N/A' }}</p>
            <p class="card-text"><strong>Categoria:</strong> {{ $produto->categoria->nome }}</p>
            <p class="card-text"><strong>Unidade:</strong> {{ $produto->unidade->nome }}</p>
            <p class="card-text"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p class="card-text"><strong>Estoque Mínimo:</strong> {{ $produto->estoque_minimo }}</p>
            <p class="card-text"><strong>Estoque Atual:</strong> {{ $produto->estoque_atual }}</p>
            
            <div class="mt-3">
                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
                 <button onclick="window.print()" class="btn btn-info btn-lg ml-1">
                  <i class="fas fa-print"></i> Imprimir
                 </button>
            </div>
        </div>
    </div>
</div>
@endsection