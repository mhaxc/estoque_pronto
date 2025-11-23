@extends('adminlte::page')


@section('title', 'Saídas')


@section('content_header')
<h1>Lista de Saídas</h1>
@stop


@section('content')
<div class="card">
<div class="card-header">
<a href="{{ route('saidas.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Nova Saída
</a>
</div>


<div class="card-body table-responsive p-0">
<table class="table table-hover text-nowrap">
<thead>
<tr>
<th>ID</th>
<th>Funcionário</th>
<th>Data</th>
<th>Produtos</th>

<th>Ações</th>


</tr>

</thead>
<tbody>
@foreach ($saidas as $saida)
<tr>
<td>{{ $saida->id }}</td>
<td>{{ $saida->funcionario->nome }}</td>
<td>{{ date('d/m/Y', strtotime($saida->data_saida)) }}</td>
<td>
    
<ul style="margin:0; padding-left:18px;">
@foreach ($saida->items as $item)
<li>
<strong>{{ $item->produto->nome }}</strong> —


{{ $item->quantidade }}


R$ = {{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}
</li>

@endforeach
</ul>
</td>
<td>
 
<a href="{{ route('saidas.show', $saida->id) }}" class="btn btn-info btn-sm">Ver</a>
<form action="{{ route('saidas.destroy', $saida->id) }}" method="POST" style="display:inline-block;">

@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Excluir esta saída?')">Excluir</button>
</form>
  
</td>

</tr>
@endforeach
</tbody>
</table>
</div>
<script>
function calcularTotal() {
    let total = 0;

    document.querySelectorAll('.produto-item').forEach(function(row) {
        let qtd = parseFloat(row.querySelector('[name*="[quantidade]"]').value) || 0;
        let preco = parseFloat(row.querySelector('[name*="[preco]"]').value) || 0;
        total += qtd * preco;
    });

    document.getElementById('total_geral').innerText =
        total.toFixed(2).replace('.', ',');
}

document.addEventListener('input', calcularTotal);
</script>
@stop