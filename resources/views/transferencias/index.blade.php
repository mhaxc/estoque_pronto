
@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Gestão de Transferências</h1>
    
    <a href="{{ route('transferencias.create') }}" class="btn btn-primary mb-3">Nova Transferência</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Data</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Funcionário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transferencias as $transferencia)
            <tr>
                <td>{{ $transferencia->id }}</td>
                <td>{{ $transferencia->produto->nome }}</td>
                <td>{{ $transferencia->quantidade }}</td>
                <td>{{ $transferencia->data_transferencia->format('d/m/Y') }}</td>
                <td>{{ $transferencia->origem }}</td>
                <td>{{ $transferencia->destino }}</td>
                <td>{{ $transferencia->funcionario->nome }}</td>
                <td>
                    <a href="{{ route('transferencias.show', $transferencia) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('transferencias.edit', $transferencia) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('transferencias.destroy', $transferencia) }}" method="POST" class="d-inline">
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
    {{ $transferencias->links() }}
</div>
@endsection