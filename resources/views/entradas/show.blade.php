@extends('adminlte::page')

@section('title', 'Detalhes da Entrada')

@section('content_header')
    <h1>Detalhes da Entrada de Produtos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Informações da Entrada
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Data da Entrada:</strong>
                <p class="text-muted">
                    @if($entrada->data_entrada instanceof \Carbon\Carbon)
                        {{ $entrada->data_entrada->format('d/m/Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($entrada->data_entrada)->format('d/m/Y') }}
                    @endif
                </p>
            </div>

            <div class="col-md-3">
                <strong>Número da Nota:</strong>
                <p class="text-muted">{{ $entrada->numero_nota ?? 'Não informado' }}</p>
            </div>

            <div class="col-md-3">
                <strong>Funcionário Responsável:</strong>
                <p class="text-muted">{{ $entrada->funcionario->nome }}</p>
            </div>

            <div class="col-md-3">
                <strong>Data de Registro:</strong>
                <p class="text-muted">
                    @if($entrada->created_at instanceof \Carbon\Carbon)
                        {{ $entrada->created_at->format('d/m/Y H:i') }}
                    @else
                        {{ \Carbon\Carbon::parse($entrada->created_at)->format('d/m/Y H:i') }}
                    @endif
                </p>
            </div>
        </div>

        @if($entrada->observacao)
        <div class="row mt-3">
            <div class="col-12">
                <strong>Observação:</strong>
                <p class="text-muted">{{ $entrada->observacao }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">
            <i class="fas fa-boxes"></i>
            Produtos da Entrada
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Produto</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-right">Preço Unitário</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalGeral = 0;
                    @endphp
                    @foreach($entrada->produtos as $item)
                    @php
                        $quantidade = $item->pivot->quantidade ?? $item->quantidade;
                        $preco = $item->pivot->preco ?? $item->preco;
                        $subtotal = $quantidade * $preco;
                        $totalGeral += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $item->nome }}</strong><br>
                            <small class="text-muted">Código: {{ $item->id }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-primary" style="font-size: 1em;">
                                {{ $quantidade }} un
                            </span>
                        </td>
                        <td class="text-right">
                            R$ {{ number_format($preco, 2, ',', '.') }}
                        </td>
                        <td class="text-right">
                            <strong>R$ {{ number_format($subtotal, 2, ',', '.') }}</strong>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total Geral:</strong></td>
                        <td class="text-right">
                            <strong class="text-success" style="font-size: 1.2em;">
                                R$ {{ number_format($totalGeral, 2, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i>
            Resumo do Estoque
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="info-box bg-gradient-success">
                    <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total de Itens</span>
                        <span class="info-box-number">
                            @php
                                $totalItens = 0;
                                foreach($entrada->produtos as $item) {
                                    $totalItens += $item->pivot->quantidade ?? $item->quantidade;
                                }
                            @endphp
                            {{ $totalItens }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="info-box bg-gradient-primary">
                    <span class="info-box-icon"><i class="fas fa-cubes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tipos de Produtos</span>
                        <span class="info-box-number">{{ $entrada->produtos->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="info-box bg-gradient-warning">
                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Valor Total</span>
                        <span class="info-box-number">R$ {{ number_format($totalGeral, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-lg">
        <i class="fas fa-edit"></i> Editar Entrada
    </a>
    <a href="{{ route('entradas.index') }}" class="btn btn-secondary btn-lg ml-2">
        <i class="fas fa-arrow-left"></i> Voltar para Lista
    </a>
    
    <!-- Botão para imprimir ou gerar PDF -->
    <button onclick="window.print()" class="btn btn-info btn-lg ml-2">
        <i class="fas fa-print"></i> Imprimir
    </button>
</div>
@stop

@section('css')
<style>
    @media print {
        .btn, .card-header, .info-box {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
    
    .info-box {
        min-height: 80px;
    }
    .info-box-icon {
        height: 80px;
        width: 80px;
        font-size: 2rem;
    }
</style>
@stop