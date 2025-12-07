@extends('adminlte::page')

@section('title', 'Relatórios de Movimentações')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-chart-pie mr-2 text-primary"></i>
                    Relatórios de Movimentações
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Relatórios</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Filtros -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i>
                        Filtros de Pesquisa
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body pt-0">
                    <form method="GET" action="{{ route('relatorios.index') }}" id="filterForm">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="fas fa-exchange-alt mr-1"></i>
                                        Tipo de Movimentação
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                        </div>
                                        <select name="tipo" class="form-control">
                                            <option value="">Todos os Tipos</option>
                                            <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>
                                                Entradas
                                            </option>
                                            <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>
                                                Saídas
                                            </option>
                                            <option value="transferencia" {{ request('tipo') == 'transferencia' ? 'selected' : '' }}>
                                                Transferências
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="fas fa-user mr-1"></i>
                                        Funcionário
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-users"></i>
                                            </span>
                                        </div>
                                        <select name="funcionario_id" class="form-control">
                                            <option value="">Todos os Funcionários</option>
                                            @foreach ($funcionarios as $f)
                                                <option value="{{ $f->id }}" {{ request('funcionario_id') == $f->id ? 'selected' : '' }}>
                                                    {{ $f->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="fas fa-box mr-1"></i>
                                        Produto
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-box-open"></i>
                                            </span>
                                        </div>
                                        <select name="produto_id" class="form-control">
                                            <option value="">Todos os Produtos</option>
                                            @foreach ($produtos as $p)
                                                <option value="{{ $p->id }}" {{ request('produto_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="fas fa-tags mr-1"></i>
                                        Categoria
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select name="categoria_id" class="form-control">
                                            <option value="">Todas as Categorias</option>
                                            @foreach ($categorias as $c)
                                                <option value="{{ $c->id }}" {{ request('categoria_id') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        Data Inicial
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="date" name="data_inicio" class="form-control" 
                                               value="{{ request('data_inicio') }}" id="dataInicio">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        Data Final
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="date" name="data_fim" class="form-control" 
                                               value="{{ request('data_fim') }}" id="dataFim">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group d-flex align-items-end h-100">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-primary btn-lg mr-2 flex-fill">
                                            <i class="fas fa-search mr-2"></i>
                                            Filtrar Dados
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-lg flex-fill" id="clearFilters">
                                            <i class="fas fa-undo mr-2"></i>
                                            Limpar Filtros
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Resultados -->
    @if(isset($dados) && $dados->count())
    <div class="row">
        <div class="col-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table mr-2"></i>
                        Resultados da Pesquisa
                        <span class="badge badge-light ml-2">{{ $dados->count() }} registro(s)</span>
                    </h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            @if(request()->anyFilled(['tipo', 'funcionario_id', 'produto_id', 'categoria_id', 'data_inicio', 'data_fim']))
                            <a href="{{ route('relatorios.pdf', request()->query()) }}" 
                               class="btn btn-danger btn-sm mr-1" title="Exportar PDF">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </a>
                            <a href="{{ route('relatorios.excel', request()->query()) }}" 
                               class="btn btn-success btn-sm" title="Exportar Excel">
                                <i class="fas fa-file-excel mr-1"></i> Excel
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center" style="width: 10%">
                                        <i class="far fa-calendar mr-1"></i> Data
                                    </th>
                                    <th style="width: 20%">
                                        <i class="fas fa-user mr-1"></i> Funcionário
                                    </th>
                                    <th style="width: 20%">
                                        <i class="fas fa-box mr-1"></i> Produto
                                    </th>
                                    <th style="width: 15%">
                                        <i class="fas fa-tags mr-1"></i> Categoria
                                    </th>
                                    <th class="text-center" style="width: 10%">
                                        <i class="fas fa-hashtag mr-1"></i> Quantidade
                                    </th>
                                    <th class="text-center" style="width: 10%">
                                        <i class="fas fa-dollar-sign mr-1"></i> Preço
                                    </th>
                                    <th class="text-center" style="width: 15%">
                                        <i class="fas fa-exchange-alt mr-1"></i> Tipo
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dados as $d)
                                    @php
                                        if(request('tipo') == 'entrada') {
                                            $data = $d->entrada->data_entrada ?? null;
                                            $funcionario = $d->entrada->funcionario->nome ?? 'N/A';
                                            $tipo = 'Entrada';
                                            $tipoColor = 'success';
                                            $tipoIcon = 'fa-arrow-circle-down';
                                            $quantidadeClass = 'text-success font-weight-bold';
                                        } elseif(request('tipo') == 'saida') {
                                            $data = $d->saida->data_saida ?? null;
                                            $funcionario = $d->saida->funcionario->nome ?? 'N/A';
                                            $tipo = 'Saída';
                                            $tipoColor = 'danger';
                                            $tipoIcon = 'fa-arrow-circle-up';
                                            $quantidadeClass = 'text-danger font-weight-bold';
                                        } else {
                                            $data = $d->transferencia->data_transferencia ?? null;
                                            $funcionario = $d->transferencia->funcionario->nome ?? 'N/A';
                                            $tipo = 'Transferência';
                                            $tipoColor = 'warning';
                                            $tipoIcon = 'fa-exchange-alt';
                                            $quantidadeClass = 'text-warning font-weight-bold';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            @if($data)
                                                <span class="badge badge-light">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="user-block">
                                                <span class="username">
                                                    <i class="fas fa-user-circle mr-1 text-primary"></i>
                                                    {{ $funcionario }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-info">
                                                <i class="fas fa-box-open mr-1 text-info"></i>
                                                <span class="text">{{ $d->produto->nome ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-secondary">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $d->produto->categoria->nome ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="{{ $quantidadeClass }}">
                                                <i class="fas fa-hashtag mr-1"></i>
                                                {{ number_format($d->quantidade, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="font-weight-bold text-dark">
                                                R$ {{ number_format($d->Produto->preco ?? 0, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $tipoColor }}">
                                                <i class="fas {{ $tipoIcon }} mr-1"></i>
                                                {{ $tipo }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Se estiver usando paginação, descomente esta parte -->
                {{--
                @if(method_exists($dados, 'links'))
                <div class="card-footer clearfix">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dataTables_info">
                                Mostrando {{ $dados->firstItem() ?? 1 }} a {{ $dados->lastItem() ?? $dados->count() }} de {{ $dados->total() ?? $dados->count() }} registros
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $dados->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                --}}
            </div>
            
            <!-- Cards de Estatísticas -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Itens</span>
                            <span class="info-box-number">{{ $dados->sum('quantidade') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Valor Total</span>
                            <span class="info-box-number">
                                R$ {{ number_format($dados->sum(function($item) { 
                                    return ($item->quantidade * ($item->Produto->preco ?? 0)); 
                                }), 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Média por Item</span>
                            <span class="info-box-number">
                                @php
                                    $precos = $dados->pluck('Produto.preco')->filter()->average();
                                @endphp
                                R$ {{ number_format($precos ?? 0, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-filter"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tipo Ativo</span>
                            <span class="info-box-number">
                                {{ request('tipo') ? ucfirst(request('tipo')) : 'Todos' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->anyFilled(['tipo', 'funcionario_id', 'produto_id', 'categoria_id', 'data_inicio', 'data_fim']))
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-search fa-4x text-warning mb-3"></i>
                        <h3 class="text-warning">Nenhum resultado encontrado</h3>
                        <p class="lead">Não encontramos registros com os filtros aplicados.</p>
                        <p class="text-muted mb-4">Tente ajustar os critérios de pesquisa.</p>
                        <button type="button" class="btn btn-warning btn-lg" id="clearFilters2">
                            <i class="fas fa-undo mr-2"></i>
                            Limpar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop

@section('css')
<style>
    .card-outline {
        border-top: 3px solid;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-top: none;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 5px 12px;
        border-radius: 12px;
    }
    
    .empty-state {
        padding: 40px 0;
    }
    
    .product-info {
        display: flex;
        flex-direction: column;
    }
    
    .product-info .text {
        font-weight: 500;
    }
    
    .user-block .username {
        font-size: 14px;
        font-weight: 600;
    }
    
    .info-box {
        border-radius: 10px;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 1rem;
    }
    
    .info-box .info-box-content {
        padding: 10px;
    }
    
    .info-box .info-box-text {
        text-transform: uppercase;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .info-box .info-box-number {
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-group .btn {
        border-radius: 5px !important;
    }
    
    .bg-primary {
        background-color: #007bff !important;
    }
    
    .bg-success {
        background-color: #28a745 !important;
    }
    
    .bg-info {
        background-color: #17a2b8 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Configurar data máxima para data fim
    $('#dataInicio').on('change', function() {
        $('#dataFim').attr('min', $(this).val());
    });
    
    $('#dataFim').on('change', function() {
        $('#dataInicio').attr('max', $(this).val());
    });
    
    // Limpar filtros
    $('#clearFilters, #clearFilters2').on('click', function() {
        $('#filterForm').find('select').val('');
        $('#filterForm').find('input[type="date"]').val('');
        $('#filterForm').submit();
    });
    
    // Alertas para datas
    $('input[type="date"]').on('change', function() {
        let inicio = $('#dataInicio').val();
        let fim = $('#dataFim').val();
        
        if (inicio && fim && inicio > fim) {
            alert('A data inicial não pode ser maior que a data final!');
            $(this).val('');
        }
    });
});
</script>
@stop