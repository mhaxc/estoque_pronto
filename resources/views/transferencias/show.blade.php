@extends('adminlte::page')
@section('title','Detalhes da Transferência')
@section('content_header') <h1>Detalhes</h1> @endsection
@section('content')
<div class="card p-3">
<p><strong>Origem:</strong> {{ $t->origem }}</p>
<p><strong>Destino:</strong> {{ $t->destino }}</p>
<p><strong>Data:</strong> {{ date('d/m/Y', strtotime($t->data_transferencia)) }}</p>
<p><strong>Funcionário:</strong> {{ $t->funcionario->nome }}</p>
<p><strong>Observação:</strong> {{ $t->observacao }}</p>


<h4>Itens</h4>
<table class="table table-bordered">
<thead>
<tr><th>Produto</th><th>Quantidade</th></tr>
</thead>
<tbody>
@foreach($t->itens as $i)
<tr>
<td>{{ $i->produto->nome }}</td>
<td>{{ $i->quantidade }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection