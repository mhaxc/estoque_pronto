@extends('adminlte::page')

@section('title', 'Transferências')

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-exchange-alt mr-2"></i>
        Transferências entre Unidades
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-indigo">
                    <h3 class="card-title text-white">
                        <i class="fas fa-truck-loading mr-2"></i>
                        Histórico de Transferências
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('transferencias.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nova Transferência
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

                    @if($transferencias->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="icon fas fa-info-circle mr-2"></i>
                            Nenhuma transferência registrada ainda.
                            <a href="{{ route('transferencias.create') }}" class="alert-link ml-1">
                                Clique aqui para registrar a primeira transferência.
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="8%">ID</th>
                                        <th width="10%">Data</th>
                                        <th width="15%">Origem</th>
                                        <th width="15%">Destino</th>
                                        <th width="15%">Funcionário</th>
                                        <th width="20%">Produtos</th>
                                        <th width="12%">Totais</th>
                                        <th width="10%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transferencias as $transferencia)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">
                                                #{{ str_pad($transferencia->id, 6, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($transferencia->data_saida)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-arrow-left text-warning mr-2"></i>
                                                <div>
                                                    <span class="font-weight-bold text-warning">
                                                        {{ $transferencia->origem }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-arrow-right text-success mr-2"></i>
                                                <div>
                                                    <span class="font-weight-bold text-success">
                                                        {{ $transferencia->destino }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                                     style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold text-sm">
                                                        {{ $transferencia->funcionario->nome }}
                                                    </div>
                                                    <small class="text-muted">
                                                        Responsável
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($transferencia->items->count() > 0)
                                                <div class="product-list">
                                                    @foreach($transferencia->items->take(2) as $item)
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="text-sm">
                                                                {{ $item->produto->nome }}
                                                            </span>
                                                            <span class="badge badge-primary ml-2">
                                                                {{ $item->quantidade }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                    @if($transferencia->items->count() > 2)
                                                        <button type="button" class="btn btn-xs btn-outline-primary mt-1" 
                                                                data-toggle="collapse" 
                                                                data-target="#moreProducts{{ $transferencia->id }}">
                                                            +{{ $transferencia->items->count() - 2 }} produtos
                                                        </button>
                                                        <div class="collapse" id="moreProducts{{ $transferencia->id }}">
                                                            @foreach($transferencia->items->skip(2) as $item)
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span class="text-sm">
                                                                        {{ $item->produto->nome }}
                                                                    </span>
                                                                    <span class="badge badge-light ml-2">
                                                                        {{ $item->quantidade }}
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
                                            @php
                                                $totalItens = $transferencia->items->sum('quantidade');
                                                $totalValor = $transferencia->items->sum(function($item) {
                                                    return $item->produto->preco * $item->quantidade;
                                                });
                                            @endphp
                                            <div class="text-center">
                                                <div class="mb-1">
                                                    <span class="badge badge-pill badge-info">
                                                        <i class="fas fa-boxes mr-1"></i>
                                                        {{ $totalItens }} itens
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="font-weight-bold text-success">
                                                        R$ {{ number_format($totalValor, 2, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('transferencias.show', $transferencia) }}" 
                                                   class="btn btn-info"
                                                   title="Visualizar transferência">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('transferencias.edit', $transferencia) }}" 
                                                   class="btn btn-warning"
                                                   title="Editar transferência">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('transferencias.destroy', $transferencia) }}" method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            title="Excluir transferência"
                                                            onclick="return confirm('Tem certeza que deseja excluir esta transferência?\\nID: {{ str_pad($transferencia->id, 6, '0', STR_PAD_LEFT) }}\\nOrigem: {{ $transferencia->origem }} → Destino: {{ $transferencia->destino }}')">
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

                @if($transferencias->hasPages())
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $transferencias->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $transferencias->firstItem() }} a {{ $transferencias->lastItem() }} de {{ $transferencias->total() }} registros
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
        .card-header.bg-gradient-indigo {
            background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%) !important;
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
        .text-warning {
            color: #ffc107 !important;
        }
        .text-success {
            color: #28a745 !important;
        }
        .table td {
            vertical-align: middle !important;
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

            // Animação para as setas de transferência
            $('.fa-arrow-right, .fa-arrow-left').hover(
                function() {
                    $(this).css('transform', 'scale(1.2)');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        });
    </script>
@stop