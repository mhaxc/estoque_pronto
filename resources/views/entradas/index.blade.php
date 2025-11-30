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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($entradas->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="icon fas fa-info-circle mr-2"></i>
                            Nenhuma entrada registrada ainda.
                            <a href="{{ route('entradas.create') }}" class="alert-link ml-1">
                                Clique aqui para registrar a primeira entrada.
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="8%">ID</th>
                                        <th width="15%">Nº Nota</th>
                                        <th width="12%">Data Entrada</th>
                                        <th width="25%">Produtos</th>
                                        <th width="10%">Qtd Total</th>
                                        <th width="15%">Funcionário</th>
                                        <th width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entradas as $entrada)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">#{{ $entrada->id }}</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                {{ $entrada->numero_nota }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($entrada->data_entrada)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($entrada->produtos->count() > 0)
                                                <div class="product-list">
                                                    @foreach($entrada->produtos->take(2) as $produto)
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-sm font-weight-bold">
                                                                {{ $produto->nome }}
                                                            </span>
                                                            <span class="badge badge-success ml-2">
                                                                {{ $produto->pivot->quantidade ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                    @if($entrada->produtos->count() > 2)
                                                        <button type="button" class="btn btn-xs btn-outline-primary mt-1" 
                                                                data-toggle="collapse" 
                                                                data-target="#moreProducts{{ $entrada->id }}">
                                                            +{{ $entrada->produtos->count() - 2 }} produtos
                                                        </button>
                                                        <div class="collapse" id="moreProducts{{ $entrada->id }}">
                                                            @foreach($entrada->produtos->skip(2) as $produto)
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span class="text-sm">
                                                                        {{ $produto->nome }}
                                                                    </span>
                                                                    <span class="badge badge-light ml-2">
                                                                        {{ $produto->pivot->quantidade ?? 'N/A' }}
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Nenhum produto
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-primary">
                                                {{ $entrada->produtos->sum('pivot.quantidade') ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($entrada->funcionario)
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                                         style="width: 30px; height: 30px;">
                                                        <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold text-sm">
                                                            {{ $entrada->funcionario->name }}
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $entrada->funcionario->cargo ?? 'Funcionário' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-user-slash mr-1"></i>
                                                    Não atribuído
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('entradas.show', $entrada->id) }}" 
                                                   class="btn btn-info"
                                                   title="Visualizar entrada">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('entradas.edit', $entrada->id) }}" 
                                                   class="btn btn-warning"
                                                   title="Editar entrada">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="d-inline">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Tem certeza que deseja excluir esta entrada?\\nNota: {{ $entrada->numero_nota }}')"
                                                            title="Excluir entrada">
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
                    <div class="float-right">
                        {{ $entradas->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $entradas->firstItem() }} a {{ $entradas->lastItem() }} de {{ $entradas->total() }} registros
                        </small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-group form {
            display: inline-block;
            margin-left: -1px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .card-header.bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
        }
        .thead-light th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .product-list .d-flex {
            border-bottom: 1px solid #f8f9fa;
            padding: 4px 0;
        }
        .product-list .d-flex:last-child {
            border-bottom: none;
        }
        .user-avatar {
            font-size: 0.8rem;
        }
        .badge-pill {
            border-radius: 50rem;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Tooltip para os botões
            $('[title]').tooltip();

            // Collapse para produtos
            $('.collapse').on('show.bs.collapse', function () {
                $(this).prev('button').text('Ver menos');
            }).on('hide.bs.collapse', function () {
                $(this).prev('button').text('+ Ver mais produtos');
            });
        });
    </script>
@stop