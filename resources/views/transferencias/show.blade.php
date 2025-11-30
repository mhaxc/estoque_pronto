@extends('adminlte::page')
@section('title','Detalhes da Transferência')
@section('content_header') <h1>Detalhes</h1> @endsection
@section('content')
<div class="card p-3">



<p><strong>Origem:</strong> {{ $transferencias->origem }}</p>
<p><strong>Destino:</strong> {{ $transferencias->destino }}</p>
<p><strong>Data:</strong> {{ date('d/m/Y', strtotime($transferencias->data_transferencia)) }}</p>
<p><strong>Funcionário:</strong> {{ $transferencias->funcionario->nome }}</p>
<p><strong>Observação:</strong> {{ $transferencias->observacao }}</p>

<h4>Itens</h4>
<table class="table table-bordered">
<thead>
<tr><th>Produto</th>
<th>Quantidade</th>
<th>Preço </th>

</tr>
</thead>
<tbody>
@foreach($transferencias->items as $i)
<tr>
<td>{{ $i->produto->nome }}</td>
<td>{{ $i->quantidade }}</td>
<td>R$ {{ number_format($i->produto->preco, 2, ',', '.') }}</td>
</tr>
@endforeach
</tbody>
</table>
 
</div>
<table>
       <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total Geral:</th>
                        <th>R$ {{ number_format($transferencias->items->sum(function($item) {
                            return $item->produto->preco * $item->quantidade;
                        }), 2, ',', '.') }}</th>
                    </tr>
        </tfoot>
</table>

            <div class="mt-3">
                <a href="{{ route('transferencias.index') }}" class="btn btn-secondary">Voltar</a>
                <a href="{{ route('transferencias.edit', $transferencias) }}"class="btn btn-warning " title="Editar">Editar</a>
            </div>

            <br>
            <form action="{{ route('transferencias.destroy', $transferencias->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
            </div>

@endsection

    

    



        