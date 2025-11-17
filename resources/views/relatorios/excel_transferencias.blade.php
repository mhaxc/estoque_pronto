<table>
    <thead>
    <tr><th>Produto</th><th>Quantidade</th><th>Funcionário</th><th>Data</th></tr>
    </thead>
    <tbody>
    @foreach($transferencias as $t)
        <tr>
            <td>{{ $t->produto->nome ?? '-' }}</td>
            <td>{{ $t->quantidade }}</td>
            <td>{{ $t->funcionario->nome ?? '-' }}</td>
            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
