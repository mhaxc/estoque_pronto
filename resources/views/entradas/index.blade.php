@extends('adminlte::page')

@section('title', 'Entradas')

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-inbox mr-2"></i>
        Entradas de Produtos
    </h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header bg-gradient-info">
                <h3 class="card-title text-white">
                    <i class="fas fa-list mr-2"></i>
                    Registro de Entradas
                </h3>
                <div class="card-tools">
                    <a href="{{ route('entradas.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Nova Entrada
                    </a>
                </div>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="icon fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($entradas->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="icon fas fa-info-circle mr-2"></i>
                        Nenhuma entrada registrada.
                        <a href="{{ route('entradas.create') }}" class="alert-link ml-1">Clique aqui para registrar.</a>
                    </div>
                @else

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="6%" class="text-center">ID</th>
                                <th width="12%" class="text-center">Nº Nota</th>
                                <th width="12%" class="text-center">Data Entrada</th>
                                <th width="30%" class="text-left">Produtos</th>
                                <th width="10%" class="text-center">Qtd</th>
                                <th width="10%" class="text-center">Total</th>
                                <th width="15%" class="text-center">Funcionário</th>
                                <th width="10%" class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($entradas as $entrada)
                            <tr>

                                <td class="text-center">
                                    <span class="badge badge-secondary">#{{ $entrada->id }}</span>
                                </td>

                                <td class="text-center">
                                    <span class="font-weight-bold text-primary">{{ $entrada->numero_nota }}</span>
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-dark">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($entrada->data_entrada)->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td class="text-left align-middle">
                                    @if($entrada->produtos->count())
                                        <div class="product-list">
                                            @foreach($entrada->produtos->take(2) as $p)
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="font-weight-bold">{{ $p->nome }}</span>
                                                    <span class="badge badge-primary">{{ $p->pivot->quantidade }}</span>
                                                </div>
                                            @endforeach

                                            @if($entrada->produtos->count() > 2)
                                                <button class="btn btn-xs btn-outline-primary mt-1"
                                                    data-toggle="collapse"
                                                    data-target="#moreProducts{{ $entrada->id }}">
                                                    +{{ $entrada->produtos->count() - 2 }} produtos
                                                </button>

                                                <div class="collapse" id="moreProducts{{ $entrada->id }}">
                                                    @foreach($entrada->produtos->skip(2) as $p)
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span>{{ $p->nome }}</span>
                                                            <span class="font-weight-bold">{{ $p->pivot->quantidade }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-exclamation-circle mr-1"></i> Nenhum produto
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <span class="badge badge-info">
                                        {{ $entrada->produtos->sum('pivot.quantidade') }}
                                    </span>
                                </td>

                                <td class="text-center align-middle">
                                    <span class="badge badge-success">
                                        R$ {{ number_format($entrada->valor_total, 2, ',', '.') }}
                                    </span>
                                </td>

                                <td class="text-center align-middle">
                                    @if($entrada->funcionario)
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="user-avatar bg-primary rounded-circle d-flex 
                                                 align-items-center justify-content-center mr-2"
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div class="text-left">
                                                <strong>{{ $entrada->funcionario->name }}</strong><br>
                                                <small class="text-muted">{{ $entrada->funcionario->cargo ?? 'Funcionário' }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted"><i class="fas fa-user-slash"></i> Não atribuído</span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir esta entrada?\nNota: {{ $entrada->numero_nota }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @endif
            </div>

            @if($entradas->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">{{ $entradas->links() }}</div>
                <small class="text-muted float-left">
                    Mostrando {{ $entradas->firstItem() }} a {{ $entradas->lastItem() }} de {{ $entradas->total() }} registros
                </small>
            </div>
            @endif

        </div>
    </div>
</div>
@stop

@section('css')
<style>

    /* Corrige alinhamento de toda a tabela */
    table.table th,
    table.table td {
        vertical-align: middle !important;
        text-align: center !important;
        white-space: nowrap;
    }

    /* Produtos precisam quebrar linha — mas sem destruir a tabela */
    .product-list {
        white-space: normal !important;
        text-align: left !important;
    }

    .product-list .d-flex {
        border-bottom: 1px solid #eee;
        padding: 3px 0;
    }

    .product-list .d-flex:last-child {
        border-bottom: none;
    }

    .card-header.bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
    }

    .user-avatar {
        font-size: 0.8rem;
    }

    .btn-group form { display: inline-block; }
</style>
@stop

@section('js')
<script>
$(function() {
    setTimeout(() => $('.alert').fadeOut('slow'), 5000);
    $('[title]').tooltip();
});
</script>
@stop
