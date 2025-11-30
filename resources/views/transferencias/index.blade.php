@extends('adminlte::page')

@section('title', 'Transferências')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Transferências</h1>
        <a href="{{ route('transferencias.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nova Transferência
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Funcionário</th>
                            <th>Produtos</th>
                            <th>Total Itens e valor</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transferencias as $transferencia)
                        <tr>
                            <td>#{{ str_pad($transferencia->id, 6, '0', STR_PAD_LEFT) }}</td>
                           
                             <td>{{ \Carbon\Carbon::parse($transferencia->data_saida)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-warning">{{ $transferencia->origem }}</span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $transferencia->destino }}</span>
                            </td>
                            <td>{{ $transferencia->funcionario->nome }}</td>
                            <td>
                                @foreach($transferencia->items->take(3) as $item)
                                    <small class="badge badge-info">{{ $item->produto->nome }} ({{ $item->quantidade }})</small>
                                @endforeach
                                @if($transferencia->items->count() > 3)
                                    <small class="badge badge-secondary">+{{ $transferencia->items->count() - 3 }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $transferencia->items->sum('quantidade') }}</span>
                                <table>
       <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total Geral:</th>
                        <th>R$ {{ number_format($transferencia->items->sum(function($item) {
                            return $item->produto->preco * $item->quantidade;
                        }), 2, ',', '.') }}</th>
                    </tr>
        </tfoot>
</table>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('transferencias.show', $transferencia) }}" 
                                       class="btn btn-info btn-sm" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transferencias.edit', $transferencia) }}" 
                                       class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transferencias.destroy', $transferencia) }}" method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                title="Excluir" 
                                                onclick="return confirm('Tem certeza que deseja excluir esta transferência?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Nenhuma transferência encontrada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($transferencias->hasPages())
        <div class="card-footer">
            {{ $transferencias->links() }}
        </div>
        @endif
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
                },
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@stop