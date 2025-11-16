@extends('adminlte::page')
@section('content')

<div class="container">
    <h1>Produtos</h1>
    
    <a href="{{ route('produtos.create') }}" class="btn btn-primary mb-3">Novo Produto</a>
       @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                 <th>Estoque Minimo</th>
                <th>Estoque Atual</th>
                <th>Ações</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->id }}</td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->categoria->nome }}</td>
                <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td>{{ $produto->estoque_minimo}}</td>
                
                <td class="{{ $produto->estoque_atual <= $produto->estoque_minimo ? '"badge badge-warning"' : '' }}">
                    {{ $produto->estoque_atual }}      
            

                </td>
                <td>
                    <a href="{{ route('produtos.show', $produto->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                    <td>
                    @if($produto->estoque_atual <= $produto->estoque_minimo)
                    <span class="badge badge-warning"> Estoque Baixo </span>
                    @else
                    <span class="badge badge-success"> Normal </span>
                    @endif
                    </td>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
            {{ $produtos->links() }}
</div>
@endsection