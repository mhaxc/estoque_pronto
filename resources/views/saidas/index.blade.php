@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Controle de saida</h1>
    
    <div class="mb-3">
        <a href="{{ route('saidas.create') }}" class="btn btn-primary">
            Nova saida
        </a>
    </div>
       
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de saidas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Funcionário</th>
                            <th>Observaçao</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saidas as $saida)
                        <tr>
                            <td>{{ $saida->data_saida->format('d/m/Y') }}</td>
                            <td>{{ $saida->produto->nome }}</td>
                            <td>{{ $saida->quantidade }}</td>
                            <td>{{ $saida->funcionario->nome }}</td>
                            <td>{{ $saida->observacao }}</td>
                            <td>
                                <a href="{{ route('entradas.show', $saida) }}" 
                                   class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('entradas.edit', $saida) }}" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                   <form action="{{ route('saidas.destroy', $saida) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
                 {{ $saidas->links() }}
        </div>
    </div>
</div>
@endsection