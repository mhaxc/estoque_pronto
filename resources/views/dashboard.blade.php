@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard de Estoque</h1>
@stop

@section('content')
<div class="row">

    <!-- Valor Total do Estoque -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3>R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}</h3>
                <p>Valor Total do Estoque</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="{{ route('produtos.index') }}" class="small-box-footer">
                Ver Produtos <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Quantidade Total em Estoque -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ number_format($totalQuantidadeEstoque, 0, '', '.') }}</h3>
                <p>Quantidade em Estoque</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
            <a href="{{ route('produtos.index') }}" class="small-box-footer">
                Detalhes <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total de Produtos Cadastrados -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ $totalProdutos }}</h3>
                <p>Produtos Cadastrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="{{ route('produtos.index') }}" class="small-box-footer">
                Ver Todos <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Produtos em Baixa -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-gradient-danger">
            <div class="inner">
                <h3>{{ $produtosBaixa->count() }}</h3>
                <p>Produtos em Alerta</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modalProdutosBaixa">
                Ver Detalhes <i class="fas fa-search"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Movimentações do Estoque -->
    <div class="col-lg-4 col-6">
        <div class="info-box bg-gradient-success">
            <span class="info-box-icon"><i class="fas fa-arrow-down"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Entradas</span>
                <span class="info-box-number">{{ number_format($totalEntrada, 0, '', '.') }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    Total de itens que entraram
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="info-box bg-gradient-warning">
            <span class="info-box-icon"><i class="fas fa-arrow-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Saídas</span>
                <span class="info-box-number">{{ number_format($totalSaida, 0, '', '.') }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    Total de itens que saíram
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="info-box bg-gradient-info">
            <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Transferências</span>
                <span class="info-box-number">{{ number_format($totalTransferencias, 0, '', '.') }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    Itens transferidos
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Resumo Rápido -->
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-2"></i>
                    Resumo do Estoque
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box mb-3 bg-light">
                            <span class="info-box-icon bg-primary"><i class="fas fa-box"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Produtos Ativos</span>
                                <span class="info-box-number">{{ $totalProdutos }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box mb-3 bg-light">
                            <span class="info-box-icon bg-success"><i class="fas fa-warehouse"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Estoque Total</span>
                                <span class="info-box-number">{{ number_format($totalQuantidadeEstoque, 0, '', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box mb-3 bg-light">
                            <span class="info-box-icon bg-danger"><i class="fas fa-exclamation"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Em Alerta</span>
                                <span class="info-box-number">{{ $produtosBaixa->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-box mb-3 bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Valor Total</span>
                                <span class="info-box-number">R$ {{ number_format($totalValorEstoque, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de produtos em baixa -->
<div class="card card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Produtos em Estado de Alerta
        </h3>
        <div class="card-tools">
            <span class="badge badge-danger">{{ $produtosBaixa->count() }} Produtos</span>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="5%">ID</th>
                    <th width="45%">Nome do Produto</th>
                    <th width="15%">Estoque Atual</th>
                    <th width="15%">Estoque Mínimo</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtosBaixa as $produto)
                <tr>
                    <td><strong>#{{ $produto->id }}</strong></td>
                    <td>{{ $produto->nome }}</td>
                    <td>
                        <span class="badge bg-danger">{{ $produto->estoque_atual }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $produto->estoque_minimo }}</span>
                    </td>
                    <td>
                        @if($produto->estoque_atual == 0)
                            <span class="badge bg-danger">ESGOTADO</span>
                        @else
                            <span class="badge bg-warning">ESTOQUE BAIXO</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                        <p class="text-muted">Nenhum produto em estado de alerta no momento</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($produtosBaixa->count() > 0)
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    Estoque abaixo do mínimo requerido
                </small>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('produtos.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>Adicionar Produto
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

@stop

@section('css')
<style>
    .small-box {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .small-box:hover {
        transform: translateY(-5px);
    }
    
    .info-box {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    
    .card-outline {
        border-top: 3px solid;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@stop

@section('js')
<script>
    console.log('Dashboard carregado com sucesso!');
    
    // Atualizar a página a cada 5 minutos para dados em tempo real
    setTimeout(function() {
        window.location.reload();
    }, 300000); // 5 minutos
</script>
@stop