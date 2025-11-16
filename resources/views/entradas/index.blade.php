@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Controle de Entradas</h1>
    
    <div class="mb-3">
        <a href="{{ route('entradas.create') }}" class="btn btn-primary">
            Nova Entrada
        </a>
    </div>
       @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Entradas</h5>
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
                            <th>Nota Fiscal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entradas as $entrada)
                        <tr>
                            <td>{{ $entrada->data_entrada->format('d/m/Y') }}</td>
                            <td>{{ $entrada->produto->nome }}</td>
                            <td>{{ $entrada->quantidade }}</td>
                            <td>{{ $entrada->funcionario->nome }}</td>
                            <td>{{ $entrada->numero_nota ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('entradas.show', $entrada) }}" 
                                   class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('entradas.edit', $entrada) }}" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                   <form action="{{ route('entradas.destroy', $entrada) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
                    {{ $entradas->links() }}
        </div>
    </div>
</div>
@endsection