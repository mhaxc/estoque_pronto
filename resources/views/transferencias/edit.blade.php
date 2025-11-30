{{-- resources/views/transferencias/edit.blade.php --}}
@extends('adminlte::page')
@section('title','Editar Transferência')
@section('content_header')<h1>Editar Transferência</h1>@endsection
@section('content')
<form action="{{ route('transferencias.update',$transferencias->id) }}" method="POST"> @csrf @method('PUT')
<div class="card p-3">



{{-- CAMPOS --}}
<div class="row">
<div class="col-md-4">
<label>Origem</label>
<input type="text" class="form-control" name="origem" value="{{ $transferencias->origem }}" required>
</div>
<div class="col-md-4">
<label>Destino</label>
<input type="text" class="form-control" name="destino" value="{{ $transferencias->destino }}" required>
</div>
<div class="col-md-4">
<label>Data</label>
<input type="date" class="form-control" name="data_transferencia" value="{{ $transferencias->data_transferencia }}" required>
</div>
</div>


<div class="row mt-3">
<div class="col-md-6">
<label>Funcionário</label>
<select name="funcionario_id" class="form-control" required>
@foreach($funcionarios as $f)
<option value="{{ $f->id }}" @selected($transferencias->funcionario_id == $f->id)>{{ $f->nome }}</option>
@endforeach
</select>
</div>
<div class="col-md-6">
<label>Observação</label>
<input type="text" class="form-control" name="observacao" value="{{ $transferencias->observacao }}">
</div>
</div>


{{-- ITENS --}}
<hr>
<h4>Itens da Transferência</h4>
<table class="table" id="tabela-itens">
<thead>
<tr>
<th>Produto</th>
<th>Quantidade</th>
<th></th>
</tr>
<tbody>


@foreach($transferencias->items as $index => $item)
<tr>
<td>
<select name="produtos[{{ $index }}][produto_id]" class="form-control" required>
@foreach($produtos as $p)
<option value="{{ $p->id }}" @selected($p->id == $item->produto_id)>{{ $p->nome }}</option>
@endforeach
</select>
</td>
<td>
<input type="number" step="0.1" min="0.1" class="form-control" name="produtos[{{ $index }}][quantidade]" value="{{ $item->quantidade }}" required>
</td>
<td><button type="button" class="btn btn-danger btn-remove">X</button></td>
</tr>
@endforeach
</tbody>
</table>


<button type="button" class="btn btn-secondary" id="add-item">Adicionar Item</button>
<button class="btn btn-primary mt-3">Atualizar</button>
</div>
</form>


<script>
let index = {{ count($transferencias->items) }};


document.getElementById('add-item').addEventListener('click', function(){
let html = `
<tr>
<td>
<select name="produtos[${index}][produto_id]" class="form-control" required>
<option value="">Selecione</option>
@foreach($produtos as $p)
<option value="


{{ $p->id }}">

{{ $p->nome }} 


 - R$ {{ number_format($p->preco, 2, ',', '.') }}


estoque ({{ $p->estoque_atual }} )
</option>
@endforeach
</select>
</td>
<td><input type="number" min="0.1" step="0.1" class="form-control" name="produtos[${index}][quantidade]" required></td>
<td><button type="button" class="btn btn-danger btn-remove">X</button></td>
</tr>`;


document.querySelector('#tabela-itens tbody').insertAdjacentHTML('beforeend', html);
index++;
});


document.addEventListener('click',function(e){
if(e.target.classList.contains('btn-remove')){
e.target.closest('tr').remove();
}
});
</script>
@endsection