<table>
    <thead>
    <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
    </thead>
    <tbody>
    @foreach($saidas as $s)
        <tr>
            <td>{{ $s->produto->nome ?? '-' }}</td>
            <td>{{ $s->quantidade }}</td>
            <td>{{ $s->funcionario->nome ?? '-' }}</td>
            <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
        @endforeach
    </tbody>
</table>
