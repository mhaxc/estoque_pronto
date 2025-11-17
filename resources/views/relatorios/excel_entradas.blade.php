<table>
    <thead>
    <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
    </thead>
    <tbody>
    @foreach($entradas as $e)
        <tr>
            <td>{{ $e->produto->nome ?? '-' }}</td>
            <td>{{ $e->quantidade }}</td>
            <td>{{ $e->funcionario->nome ?? '-' }}</td>
            <td>{{ $e->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
