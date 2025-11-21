@extends('adminlte::page')

@section('content')
<h3>Entradas, Saídas e Transferências</h3>

<form method="GET">
    <div class="row">
        <div class="col-md-3">
            <label>Funcionário</label>
            <select name="funcionario_id" class="form-control">
                <option value="">Todos</option>
                @foreach ($funcionarios as $f)
                    <option value="{{ $f->id }}">{{ $f->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Data início</label>
            <input type="date" name="inicio" class="form-control">
        </div>

        <div class="col-md-3">
            <label>Data fim</label>
            <input type="date" name="fim" class="form-control">
        </div>

        <div class="col-md-3">
            <label>&nbsp;</label>
            <button class="btn btn-primary btn-block">Filtrar</button>
        </div>
    </div>
</form>

<hr>

<h4>Entradas</h4>
<table class="table">
  <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Preco</th><th>Data</th></tr>
@foreach ($entradas as $e)
<tr>
    <td>{{ $e->produto->nome }}</td>
    <td>{{ $e->quantidade }}</td>
    <td>{{ $e->funcionario->nome }}</td>
  <td>R$ {{ number_format($e->produto->preco, 2, ',', '.') }}</td>
    <td>{{ $e->created_at }}</td>
</tr>
@endforeach
</table>

<h4>Saídas</h4>
<table class="table">
  <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Preco</th><th>Data</th></tr>
@foreach ($saidas as $s)
<tr>
    <td>{{ $s->produto->nome }}</td>
    <td>{{ $s->quantidade }}</td>
    <td>{{ $s->funcionario->nome }}</td>
   <td>R$ {{ number_format($s->produto->preco, 2, ',', '.') }}</td>
    <td>{{ $s->created_at }}</td>
</tr>
@endforeach
</table>

<h4>Transferências</h4>
<table class="table">
  <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Preco</th><th>Data</th></tr>
@foreach ($transferencias as $t)
<tr>
    <td>{{ $t->produto->nome }}</td>
    <td>{{ $t->quantidade }}</td>
    <td>{{ $t->funcionario->nome }}</td>
    <td>{{ $t->(quantidade * preco)  }}</td>
   <td>R$ {{ number_format($t->produto->preco, 2, ',', '.') }}</td>
    <td>{{ $t->created_at }}</td>
</tr>
@endforeach
</table>

<a href="{{ route('relatorios.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
<a href="{{ route('relatorios.export.excel') }}" class="btn btn-success">Exportar Excel</a>

@endsection


