@extends('adminlte::page')

@section('content')
<h3>Produtos mais saídos</h3>

<table class="table table-bordered">
    <tr>
        <th>Produto</th>
        <th>Total Saído</th>
    </tr>
    @foreach ($produtos as $item)
        <tr>
            <td>{{ $item->produto->nome }}</td>
            <td>{{ $item->total }}</td>
        </tr>
    @endforeach
</table>

<a href="{{ route('relatorios.export.pdf') }}" class="btn btn-danger">Exportar PDF</a>
<a href="{{ route('relatorios.export.excel') }}" class="btn btn-success">Exportar Excel</a>
@endsection
