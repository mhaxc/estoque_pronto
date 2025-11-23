@extends('adminlte::page')

@section('title', 'Nova Saída')

@section('content_header')
    <h1>Cadastrar Saída de Produtos</h1>
@stop

@section('content')

<form action="{{ route('saidas.store') }}" method="POST">
@csrf

<div class="row">
    <div class="col-md-4">
        <label>Data da Saída</label>
        <input type="date" name="data_saida" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label>Funcionário</label>
        <select name="funcionario_id" class="form-control" required>
            @foreach($funcionarios as $f)
                <option value="{{ $f->id }}">{{ $f->nome }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-12 mt-3">
    <label>Observação</label>
    <textarea name="observacao" class="form-control"></textarea>
</div>

<hr>

<h3>Produtos adicionados</h3>

<table class="table table-bordered" id="tabela-produtos">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th width="50">Ação</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalProduto">
    + Adicionar Produto
</button>

<br><br>

<button type="submit" class="btn btn-primary">Finalizar Saída</button>

</form>

{{-- Modal --}}
<div class="modal fade" id="modalProduto">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Adicionar Produto</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <label>Produto</label>
                <select id="produto_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($produtos as $p)
                        <option value="{{ $p->id }}"
                            data-nome="{{ $p->nome }}"
                            data-estoque="{{ $p->estoque_atual }}">
                            {{ $p->nome }} — Estoque: {{ $p->estoque_atual }}
                        </option>
                    @endforeach
                </select>

                <label class="mt-3">Quantidade</label>
                <input type="number" step="1" id="quantidade" class="form-control">

                <div id="alerta-estoque" class="text-danger mt-2" style="display:none;">
                    * Quantidade maior que o estoque disponível!
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" id="btnAddLista" class="btn btn-primary">Adicionar à Lista</button>
            </div>

        </div>
    </div>
</div>

@stop



@section('js')
<script>
let linha = 0;

// Validação de estoque ao digitar
document.getElementById("quantidade").addEventListener("input", function () {
    let qtd = parseFloat(this.value);
    let option = document.querySelector("#produto_id option:checked");

    if (!option.value) return;

    let estoque = parseFloat(option.dataset.estoque);

    if (qtd > estoque) {
        document.getElementById("alerta-estoque").style.display = "block";
    } else {
        document.getElementById("alerta-estoque").style.display = "none";
    }
});


// Botão para adicionar na lista
document.getElementById("btnAddLista").addEventListener("click", function () {

    let produto = document.querySelector("#produto_id option:checked");
    let quantidade = document.getElementById("quantidade").value;

    if (!produto.value || quantidade <= 0) {
        alert("Selecione um produto e informe quantidade válida");
        return;
    }

    // alerta de estoque
    if (quantidade <= produto.dataset.estoque) {
        alert("Quantidade maior que o estoque!");
        return;
    }

    // insere linha na tabela principal
    let html = `
    <tr>
        <td>${produto.dataset.nome}
            <input type="hidden" name="produtos[${linha}][produto_id]" value="${produto.value}">
        </td>

        <td>${quantidade}
            <input type="hidden" name="produtos[${linha}][quantidade]" value="${quantidade}">
        </td>

        <td><button type="button" class="btn btn-danger btn-remover">X</button></td>
    </tr>
    `;

    document.querySelector("#tabela-produtos tbody").insertAdjacentHTML("beforeend", html);
    linha++;

    // limpa modal
    document.getElementById("produto_id").value = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("alerta-estoque").style.display = "none";

    // fecha modal
    $("#modalProduto").modal("hide");
});

// Remover linha
document.addEventListener("click", function(e){
    if (e.target.classList.contains("btn-remover")) {
        e.target.closest("tr").remove();
    }
});
</script>
@stop
