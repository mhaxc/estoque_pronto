@extends('adminlte::page')

@section('content')
    <h3>Relatórios do Sistema de Estoque</h3>

    <a href="{{ route('relatorios.produtos-mais-saidos') }}" class="btn btn-primary">Produtos mais saídos</a>
    <a href="{{ route('relatorios.movimentacoes') }}" class="btn btn-primary">Movimentações por data e funcionário</a>
@endsection
