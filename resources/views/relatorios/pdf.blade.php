<!DOCTYPE html>
<html>
<head>
    <title>Relatório PDF</title>
</head>
<body>
    <h1>Relatório Detalhado</h1>

    <h2>Produtos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Unidade</th>
                <th>Estoque Mínimo</th>
                <th>Estoque Atual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->categoria->nome }}</td>
                <td>{{ $produto->unidade->nome }}</td>
                <td>{{ $produto->estoque_minimo }}</td>
                <td>{{ $produto->estoque_atual }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Entradas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Data Entrada</th>
                <th>Funcionário</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entradas as $entrada)
            <tr>
                <td>{{ $entrada->produto->nome }}</td>
                <td>{{ $entrada->quantidade }}</td>
                <td>{{ $entrada->data_entrada }}</td>
                <td>{{ $entrada->funcionario->nome }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Saídas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Data Saída</th>
                <th>Funcionário</th>
            </tr>
        </thead>
        <tbody>
            @foreach($saidas as $saida)
            <tr>
                <td>{{ $saida->produto->nome }}</td>
                <td>{{ $saida->quantidade }}</td>
                <td>{{ $saida->data_saida }}</td>
                <td>{{ $saida->funcionario->nome }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Transferências</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Data Transferência</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Funcionário</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transferencias as $transferencia)
            <tr>
                <td>{{ $transferencia->produto->nome }}</td>
                <td>{{ $transferencia->quantidade }}</td>
                <td>{{ $transferencia->data_transferencia }}</td>
                <td>{{ $transferencia->origem }}</td>
                <td>{{ $transferencia->destino }}</td>
                <td>{{ $transferencia->funcionario->nome }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

