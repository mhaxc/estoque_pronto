@extends('adminlte::page')

@section('title', 'Saídas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lista de Saídas</h1>
        <a href="{{ route('saidas.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nova Saída
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Funcionário</th>
                        <th>Data</th>
                        <th>Produtos</th>
                        <th>Total</th>
                        <th width="15%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saidas as $saida)
                        <tr>
                            <td><strong>#{{ $saida->id }}</strong></td>
                            <td>{{ $saida->funcionario->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($saida->data_saida)->format('d/m/Y') }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($saida->items as $item)
                                        <li class="border-bottom pb-1 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $item->produto->nome }}</span>
                                                <span class="text-muted">
                                                    {{ $item->quantidade }} x R$ {{ number_format($item->produto->preco, 2, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <small class="text-success font-weight-bold">
                                                    R$ {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}
                                                </small>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="font-weight-bold text-success">
                                R$ {{ number_format($saida->items->sum(function($item) {
                                    return $item->produto->preco * $item->quantidade;
                                }), 2, ',', '.') }}
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ route('saidas.show', $saida->id) }}" 
                                       class="btn btn-info btn-sm btn-block d-flex align-items-center justify-content-center">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>
                                    <a href="{{ route('saidas.edit', $saida->id) }}" 
                                       class="btn btn-warning btn-sm btn-block d-flex align-items-center justify-content-center">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                    <form action="{{ route('saidas.destroy', $saida->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm btn-block d-flex align-items-center justify-content-center"
                                                onclick="return confirm('Tem certeza que deseja excluir esta saída?')">
                                            <i class="fas fa-trash mr-1"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table td {
            vertical-align: middle !important;
        }
        .btn-block {
            width: 100%;
        }
    </style>
@stop