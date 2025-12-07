<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de {{ ucfirst($tipo) }}</title>

    <style>
        @page { margin: 30px 25px; }

        body { 
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        /* CABEÇALHO */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header img {
            width: 110px;
            margin-bottom: 5px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #222;
        }

        .company-info {
            font-size: 12px;
            color: #555;
            margin-top: -4px;
        }

        /* TÍTULO */
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 2px solid #3c8dbc;
            color: #3c8dbc;
        }

        /* CARD */
        .card {
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            padding: 15px;
            background: #fafafa;
        }

        /* TABELA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table th {
            background: #3c8dbc;
            color: white;
            padding: 7px;
            font-size: 12px;
            border: 1px solid #2f6f95;
        }

        table td {
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        /* Zebra stripes */
        table tbody tr:nth-child(even) {
            background: #f5faff;
        }

        /* TOTAL */
        .totals {
            margin-top: 15px;
            font-size: 13px;
            font-weight: bold;
            text-align: right;
        }

        /* RODAPÉ */
        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    {{-- CABEÇALHO --}}
    <div class="header">
        <img src="{{ public_path('logo.png') }}" alt="LOGO">
        <div class="company-name">Minha Empresa Ltda</div>
        <div class="company-info">
            Rua Exemplo, 123 – Bairro Central – Cidade/UF<br>
            Telefone: (00) 00000-0000 • CNPJ: 00.000.000/0001-00
        </div>
    </div>

    {{-- TÍTULO --}}
    <div class="title">
        Relatório de {{ ucfirst($tipo) }}
    </div>

    <div class="card">

        {{-- TABELA DE DADOS --}}
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Funcionário</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Qtd</th>
                    <th>preco</th>
                    <th>Tipo</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $totalQuantidade = 0;
                @endphp

                @foreach ($dados as $d)
                    @php
                        $totalQuantidade += $d->quantidade;
                    @endphp

                    <tr>
                        <td>
                            @if($tipo=='entrada')
                                {{ $d->entrada->data_entrada }}
                            @elseif($tipo=='saida')
                                {{ $d->saida->data_saida }}
                            @else
                                {{ $d->transferencia->data_transferencia }}
                            @endif
                        </td>

                        <td>
                            @if($tipo=='entrada')
                                {{ $d->entrada->funcionario->nome }}
                            @elseif($tipo=='saida')
                                {{ $d->saida->funcionario->nome }}
                            @else
                                {{ $d->transferencia->funcionario->nome }}
                            @endif
                        </td>

                        <td>{{ $d->produto->nome }}</td>
                        <td>{{ $d->produto->categoria->nome }}</td>
                        <td>{{ $d->quantidade }}</td>
                        <td>{{ $d->produto->preco }}</td>
                        <td>{{ ucfirst($tipo) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTAL --}}
        <div class="totals">
            Total de itens movimentados: <span style="color:#3c8dbc">{{ $totalQuantidade }}</span>
        </div>

    </div>

    {{-- RODAPÉ --}}
    <div class="footer">
        Relatório gerado automaticamente em {{ date('d/m/Y H:i') }} —
        Sistema de Gestão de Estoque
    </div>

</body>
</html>
