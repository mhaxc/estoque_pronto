@extends('adminlte::page')

@section('title', 'Saídas')

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-sign-out-alt mr-2"></i>
        Saídas de Produtos
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-warning">
                    <h3 class="card-title text-white">
                        <i class="fas fa-list mr-2"></i>
                        Lista de Saídas
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('saidas.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Nova Saída
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

                    @if($saidas->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="icon fas fa-info-circle mr-2"></i>
                            Nenhuma saída registrada ainda.
                            <a href="{{ route('saidas.create') }}" class="alert-link ml-1">
                                Clique aqui para registrar a primeira saída.
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="8%">ID</th>
                                        <th width="15%">Funcionário</th>
                                        <th width="12%">Data</th>
                                        <th width="30%">Produtos</th>
                                        <th width="10%">Total</th>
                                        <th width="15%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saidas as $saida)
                                        <tr>
                                            <td>
                                                <span class="badge badge-secondary">#{{ $saida->id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                                         style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold text-sm">
                                                            {{ $saida->funcionario->nome }}
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($saida->data_saida)->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-dark">
                                                    <i class="fas fa-calendar-alt mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($saida->data_saida)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($saida->items->count() > 0)
                                                    <div class="product-list">
                                                        @foreach($saida->items->take(2) as $item)
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div class="flex-grow-1">
                                                                    <span class="text-sm font-weight-bold d-block">
                                                                        {{ $item->produto->nome }}
                                                                    </span>
                                                                    <small class="text-muted">
                                                                        {{ $item->quantidade }} un × R$ {{ number_format($item->produto->preco, 2, ',', '.') }}
                                                                    </small>
                                                                </div>
                                                                <span class="badge badge-success ml-2">
                                                                    R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                        @if($saida->items->count() > 2)
                                                            <button type="button" class="btn btn-xs btn-outline-primary mt-1" 
                                                                    data-toggle="collapse" 
                                                                    data-target="#moreProducts{{ $saida->id }}">
                                                                +{{ $saida->items->count() - 2 }} produtos
                                                            </button>
                                                            <div class="collapse" id="moreProducts{{ $saida->id }}">
                                                                @foreach($saida->items->skip(2) as $item)
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div class="flex-grow-1">
                                                                            <span class="text-sm">
                                                                                {{ $item->produto->nome }}
                                                                            </span>
                                                                            <small class="text-muted d-block">
                                                                                {{ $item->quantidade }} un × R$ {{ number_format($item->produto->preco, 2, ',', '.') }}
                                                                            </small>
                                                                        </div>
                                                                        <span class="badge badge-light ml-2">
                                                                            R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}
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
                                                    $totalSaida = $saida->items->sum(function($item) {
                                                        return $item->produto->preco * $item->quantidade;
                                                    });
                                                @endphp
                                                <span class="font-weight-bold text-success h5">
                                                    R$ {{ number_format($totalSaida, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('saidas.show', $saida->id) }}" 
                                                       class="btn btn-info"
                                                       title="Visualizar saída">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('saidas.edit', $saida->id) }}" 
                                                       class="btn btn-warning"
                                                       title="Editar saída">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('saidas.destroy', $saida->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-danger"
                                                                onclick="return confirm('Tem certeza que deseja excluir esta saída?\\nID: {{ $saida->id }}\\nData: {{ \Carbon\Carbon::parse($saida->data_saida)->format('d/m/Y') }}')"
                                                                title="Excluir saída">
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

                @if($saidas->hasPages())
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $saidas->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $saidas->firstItem() }} a {{ $saidas->lastItem() }} de {{ $saidas->total() }} registros
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
        .card-header.bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
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

            // Calcular totais em tempo real (exemplo adicional)
            $('.product-item').each(function() {
                var quantity = $(this).data('quantity');
                var price = $(this).data('price');
                var total = quantity * price;
                $(this).find('.item-total').text('R$ ' + total.toFixed(2).replace('.', ','));
            });
        });
    </script>
@stop