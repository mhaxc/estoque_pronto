@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">

    <!-- Total de Produtos -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>R$ {{ number_format($totalProdutos * $total, 2, ',', '.') }}</h3>
                
                <p>Total Preço dos Produtos</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>

    <!-- Produtos em Baixa -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $produtosBaixa->count() }}</h3>
                <p>Produtos em Baixa</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <!-- Entradas -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalEntrada }}</h3>
                <p>Total de Entradas</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>

    <!-- Saídas -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalSaida }}</h3>
                <p>Total de Saídas</p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>

    <!-- Transferências -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalTransferencias }}</h3>
                <p>Total de Transferências</p>
            </div>
            <div class="icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de produtos em baixa -->
<div class="card mt-4">
    <div class="card-header bg-danger text-white">
        <h3 class="card-title">Produtos em Baixa</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade Atual</th>
                    <th>Estoque Mínimo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtosBaixa as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->estoque_atual }}</td>
                    <td>{{ $produto->estoque_minimo }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum produto em baixa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
