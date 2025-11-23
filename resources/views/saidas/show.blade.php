@extends('adminlte::page')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($saida->items as $item)
        <tr>
            <td>{{ $item->produto->nome }}</td>
            <td>{{ $item->quantidade }}</td>
            <td>R$ {{ number_format($item->produto->preco, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 class="text-end">
    Total da Saída: <strong>R$ {{ number_format($item->quantidade * $item->produto->preco  , 2, ',', '.') }}</strong>
</h3>
 <div class="mt-3">
                
                <a href="{{ route('saidas.index') }}" class="btn btn-secondary">Voltar</a>
            </div>

@endsection