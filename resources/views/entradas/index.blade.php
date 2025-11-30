@extends('adminlte::page')

@section('title', 'Entradas')

@section('content_header')
    <h1>Entradas de Produtos</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Nova Entrada</a>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nº Nota</th>
                    <th>Data Entrada</th>
                    <th>Produtos</th>
                    <th>Qtd Total</th>
                    <th>Funcionário</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>{{ $entrada->numero_nota }}</td>
                    <td>{{ \Carbon\Carbon::parse($entrada->data_entrada)->format('d/m/Y') }}</td>
                    <td>
                        @if($entrada->produtos->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($entrada->produtos as $produto)
                                    <li class="text-sm">
                                        • {{ $produto->nome }} 
                                        <small class="text-muted">
                                            (Qtd: {{ $produto->pivot->quantidade ?? 'N/A' }})
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Nenhum produto</span>
                        @endif
                    </td>
                    <td>{{ $entrada->produtos->sum('pivot.quantidade') ?? 0 }}</td>
                    <td>
                        @if($entrada->funcionario)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user mr-2"></i>
                                {{ $entrada->funcionario->name }}
                            </div>
                        @else
                            <span class="text-muted">Não atribuído</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('entradas.show', $entrada->id) }}" class = "btn btn-info btn-sm">Ver</a>
                            
                            <a href="{{ route('entradas.edit', $entrada->id) }}" class = "btn btn-warning btn-sm">
                               Editar
                            </a>
                            <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Tem certeza?')">
                                    <i class="fas fa-trash"> excluir </i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $entradas->links() }}
    </div>
</div>

@section('css')
<style>
    .list-unstyled li {
        padding: 2px 0;
        border-bottom: 1px dotted #eee;
    }
    .list-unstyled li:last-child {
        border-bottom: none;
    }
    .btn-group form {
        display: inline-block;
        margin-left: -1px;
    }
</style>
@endsection

@endsection