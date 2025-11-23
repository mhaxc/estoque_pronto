@extends('adminlte::page')

@section('title', 'Transferências')

@section('content_header')
    <h1>Transferências</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('transferencias.create') }}" class="btn btn-primary">Nova Transferência</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Data</th>
                        <th>Funcionário</th>
                        <th>produtos e quantidade</th>
                        <th>Preco Final</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transferencias as $transferencia)
                    <tr>
                        <td>{{ $transferencia->id }}</td>
                        <td>{{ $transferencia->origem }}</td>
                        <td>{{ $transferencia->destino }}</td>
                        <td>{{ \Carbon\Carbon::parse($transferencia->data_transferencia)->format('d/m/Y H:i') }}</td>
                        <td>{{ $transferencia->funcionario->nome }}</td>

                  <td>
    <ul class="list-unstyled mb-0">
        @foreach($transferencia->produtos as $produto)
            <li>{{ $produto->produto->nome }}  =  {{ $produto->quantidade }}</li>
        @endforeach
    </ul>
</td>
<td class="text-center">
R$ =  {{ number_format($produto->produto->preco * $produto->quantidade, 2, ',', '.') }}
</td>

                        <td>
                            <a href="{{ route('transferencias.show', $transferencia) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('transferencias.edit', $transferencia) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('transferencias.destroy', $transferencia) }}" method="POST" style="display:inline">
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
    </div>
@stop