<table>
    <thead>
        <tr>
            <th colspan="4">Entradas</th>
        </tr>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Funcionário</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entradas as $e)
        <tr>
            <td>{{ $e->produto->nome }}</td>
            <td>{{ $e->quantidade }}</td>
            <td>{{ $e->funcionario->nome }}</td>
            <td>{{ $e->created_at }}</td>
        </tr>
    @endforeach
    </tbody>

    <thead>
        <tr>
            <th colspan="4">Saídas</th>
        </tr>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Funcionário</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
    @foreach($saidas as $s)
        <tr>
            <td>{{ $s->produto->nome }}</td>
            <td>{{ $s->quantidade }}</td>
            <td>{{ $s->funcionario->nome }}</td>
            <td>{{ $s->created_at }}</td>
        </tr>
    @endforeach
    </tbody>

    <thead>
        <tr>
            <th colspan="4">Transferências</th>
        </tr>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Funcionário</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transferencias as $t)
        <tr>
            <td>{{ $t->produto->nome }}</td>
            <td>{{ $t->quantidade }}</td>
            <td>{{ $t->funcionario->nome }}</td>
            <td>{{ $t->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


