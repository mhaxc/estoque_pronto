@extends('adminlte::page')

@section('title', 'Nova Saída')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Cadastrar Saída de Produtos</h1>
        <a href="{{ route('saidas.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Voltar para Lista
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('saidas.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_saida" class="font-weight-bold">Data da Saída *</label>
                        <input type="date" name="data_saida" id="data_saida" 
                               class="form-control @error('data_saida') is-invalid @enderror" 
                               value="{{ old('data_saida', date('Y-m-d')) }}" required>
                        @error('data_saida')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="funcionario_id" class="font-weight-bold">Funcionário *</label>
                        <select name="funcionario_id" id="funcionario_id" 
                                class="form-control @error('funcionario_id') is-invalid @enderror" required>
                            <option value="">Selecione um funcionário</option>
                            @foreach($funcionarios as $f)
                                <option value="{{ $f->id }}" {{ old('funcionario_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('funcionario_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="observacao" class="font-weight-bold">Observação</label>
                        <textarea name="observacao" id="observacao" class="form-control" 
                                  rows="1" placeholder="Opcional">{{ old('observacao') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="font-weight-bold mb-0">Produtos da Saída</h4>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalProduto">
                    <i class="fas fa-plus mr-1"></i> Adicionar Produto
                </button>
            </div>

            @if($errors->has('produtos'))
                <div class="alert alert-danger">
                    {{ $errors->first('produtos') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabela-produtos">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40%">Produto</th>
                            <th width="15%">Estoque Atual</th>
                            <th width="15%">Quantidade</th>
                            <th width="20%">Preço Unitário</th>
                            <th width="10%" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="produtos-tbody">
                        <!-- Produtos serão adicionados aqui via JavaScript -->
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <td colspan="3" class="text-right font-weight-bold">Total Geral:</td>
                            <td colspan="2" class="font-weight-bold text-success" id="total-geral">
                                R$ 0,00
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="alert alert-warning {{ count(old('produtos', [])) > 0 ? '' : 'd-none' }}" id="alerta-lista-vazia">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Nenhum produto adicionado à saída.
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg" id="btn-finalizar">
                    <i class="fas fa-check mr-2"></i> Finalizar Saída
                </button>
                <a href="{{ route('saidas.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Adicionar Produto -->
<div class="modal fade" id="modalProduto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">
                    <i class="fas fa-cube mr-2"></i> Adicionar Produto
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="produto_id" class="font-weight-bold">Produto *</label>
                    <select id="produto_id" class="form-control">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $p)
                            <option value="{{ $p->id }}"
                                data-nome="{{ $p->nome }}"
                                data-estoque="{{ $p->estoque_atual }}"
                                data-preco="{{ $p->preco }}">
                                {{ $p->nome }} — Estoque: {{ number_format($p->estoque_atual, 3, ',', '.') }} — R$ {{ number_format($p->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantidade" class="font-weight-bold">Quantidade *</label>
                    <input type="number" step="0.001" min="0.001" id="quantidade" class="form-control" 
                           placeholder="Informe a quantidade (ex: 0.5, 1.25)">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estoque Disponível</label>
                            <input type="text" id="estoque-disponivel" class="form-control" readonly value="0,000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Preço Unitário</label>
                            <input type="text" id="preco-unitario" class="form-control" readonly value="R$ 0,00">
                        </div>
                    </div>
                </div>

                <div id="alerta-estoque" class="alert alert-danger mt-3" style="display:none;">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span id="mensagem-alerta"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <button type="button" id="btnAddLista" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Adicionar à Lista
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table th {
        border-top: none;
    }
    .produto-item {
        vertical-align: middle;
    }
    #alerta-lista-vazia {
        border-left: 4px solid #ffc107;
    }
</style>
@stop

@section('js')
<script>
let linha = 0;
let produtosAdicionados = [];

document.addEventListener('DOMContentLoaded', function() {
    // Atualizar informações quando selecionar produto no modal
    document.getElementById("produto_id").addEventListener("change", function() {
        const option = this.options[this.selectedIndex];
        if (option && option.value !== "") {
            document.getElementById("estoque-disponivel").value = 
                parseFloat(option.dataset.estoque).toLocaleString('pt-BR', {
                    minimumFractionDigits: 3,
                    maximumFractionDigits: 3
                });
            document.getElementById("preco-unitario").value = 'R$ ' + 
                parseFloat(option.dataset.preco).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            document.getElementById("quantidade").value = '';
            document.getElementById("alerta-estoque").style.display = 'none';
        } else {
            document.getElementById("estoque-disponivel").value = '0,000';
            document.getElementById("preco-unitario").value = 'R$ 0,00';
        }
    });

    // Validação de estoque em tempo real
    document.getElementById("quantidade").addEventListener("input", function() {
        validarEstoque();
    });

    // Adicionar produto à lista
    document.getElementById("btnAddLista").addEventListener("click", function() {
        adicionarProdutoLista();
    });

    // Permitir Enter no campo quantidade
    document.getElementById("quantidade").addEventListener("keypress", function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            adicionarProdutoLista();
        }
    });

    // Carregar produtos do old() se houver erro de validação
    @if(old('produtos'))
        @foreach(old('produtos') as $index => $produto)
            const produtoOld = {
                id: '{{ $produto["produto_id"] }}',
                nome: document.querySelector(`#produto_id option[value="{{ $produto['produto_id'] }}"]`)?.dataset.nome || 'Produto',
                estoque: document.querySelector(`#produto_id option[value="{{ $produto['produto_id'] }}"]`)?.dataset.estoque || 0,
                preco: document.querySelector(`#produto_id option[value="{{ $produto['produto_id'] }}"]`)?.dataset.preco || 0,
                quantidade: '{{ $produto["quantidade"] }}'
            };
            adicionarLinhaTabela(produtoOld);
        @endforeach
        atualizarTotalGeral();
    @endif
});

function validarEstoque() {
    const produtoSelect = document.getElementById("produto_id");
    const quantidadeInput = document.getElementById("quantidade");
    const alerta = document.getElementById("alerta-estoque");
    const mensagem = document.getElementById("mensagem-alerta");
    
    if (!produtoSelect.value) {
        alerta.style.display = 'none';
        return false;
    }

    const quantidade = parseFloat(quantidadeInput.value.replace(',', '.'));
    const estoque = parseFloat(produtoSelect.options[produtoSelect.selectedIndex].dataset.estoque);
    const produtoId = produtoSelect.value;

    // Verificar se produto já foi adicionado
    const produtoJaAdicionado = produtosAdicionados.find(p => p.id === produtoId);
    const quantidadeTotal = produtoJaAdicionado ? 
        (parseFloat(produtoJaAdicionado.quantidade) + quantidade) : quantidade;

    if (quantidade <= 0 || isNaN(quantidade)) {
        alerta.style.display = 'block';
        mensagem.textContent = 'Informe uma quantidade válida (maior que zero)';
        return false;
    }

    if (quantidade > estoque) {
        alerta.style.display = 'block';
        mensagem.textContent = `Quantidade solicitada (${quantidade.toFixed(3).replace('.', ',')}) maior que estoque disponível (${estoque.toFixed(3).replace('.', ',')})`;
        return false;
    }

    if (quantidadeTotal > estoque) {
        alerta.style.display = 'block';
        mensagem.textContent = `Quantidade total para este produto (${quantidadeTotal.toFixed(3).replace('.', ',')}) excede o estoque disponível (${estoque.toFixed(3).replace('.', ',')})`;
        return false;
    }

    alerta.style.display = 'none';
    return true;
}

function adicionarProdutoLista() {
    const produtoSelect = document.getElementById("produto_id");
    const quantidadeInput = document.getElementById("quantidade");
    
    if (!produtoSelect.value) {
        alert("Selecione um produto");
        produtoSelect.focus();
        return;
    }

    if (!quantidadeInput.value || parseFloat(quantidadeInput.value.replace(',', '.')) <= 0) {
        alert("Informe uma quantidade válida");
        quantidadeInput.focus();
        return;
    }

    if (!validarEstoque()) {
        return;
    }

    const option = produtoSelect.options[produtoSelect.selectedIndex];
    const produto = {
        id: option.value,
        nome: option.dataset.nome,
        estoque: option.dataset.estoque,
        preco: option.dataset.preco,
        quantidade: parseFloat(quantidadeInput.value.replace(',', '.'))
    };

    // Verificar se produto já existe na lista
    const indexExistente = produtosAdicionados.findIndex(p => p.id === produto.id);
    if (indexExistente !== -1) {
        // Atualizar quantidade do produto existente
        produtosAdicionados[indexExistente].quantidade += produto.quantidade;
        atualizarLinhaTabela(produtosAdicionados[indexExistente]);
    } else {
        // Adicionar novo produto
        produtosAdicionados.push(produto);
        adicionarLinhaTabela(produto);
    }

    atualizarTotalGeral();
    limparModal();
    $('#modalProduto').modal('hide');
}

function adicionarLinhaTabela(produto) {
    const tbody = document.getElementById("produtos-tbody");
    const totalItem = produto.preco * produto.quantidade;

    const html = `
        <tr class="produto-item" data-produto-id="${produto.id}">
            <td>
                <strong>${produto.nome}</strong>
                <input type="hidden" name="produtos[${linha}][produto_id]" value="${produto.id}">
                <input type="hidden" name="produtos[${linha}][quantidade]" value="${produto.quantidade}">
            </td>
            <td class="text-center">${parseFloat(produto.estoque).toLocaleString('pt-BR', {
                minimumFractionDigits: 3,
                maximumFractionDigits: 3
            })}</td>
            <td class="text-center">
                <span class="badge badge-primary badge-pill" style="font-size: 1em;">
                    ${produto.quantidade.toLocaleString('pt-BR', {
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3
                    })}
                </span>
            </td>
            <td class="text-right">
                R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-remover" 
                        data-produto-id="${produto.id}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

    tbody.insertAdjacentHTML("beforeend", html);
    linha++;

    // Atualizar alerta de lista vazia
    document.getElementById("alerta-lista-vazia").classList.add("d-none");
}

function atualizarLinhaTabela(produto) {
    const linha = document.querySelector(`tr[data-produto-id="${produto.id}"]`);
    if (linha) {
        linha.querySelector('.badge').textContent = produto.quantidade.toLocaleString('pt-BR', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        });
        linha.querySelector('input[name*="quantidade"]').value = produto.quantidade;
    }
}

function atualizarTotalGeral() {
    let totalGeral = 0;
    
    produtosAdicionados.forEach(produto => {
        totalGeral += produto.preco * produto.quantidade;
    });

    document.getElementById("total-geral").textContent = 
        'R$ ' + totalGeral.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    // Habilitar/desabilitar botão de finalizar
    document.getElementById("btn-finalizar").disabled = produtosAdicionados.length === 0;
}

function limparModal() {
    document.getElementById("produto_id").value = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("estoque-disponivel").value = "0,000";
    document.getElementById("preco-unitario").value = "R$ 0,00";
    document.getElementById("alerta-estoque").style.display = "none";
}

// Remover produto da lista
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-remover") || e.target.closest(".btn-remover")) {
        const button = e.target.classList.contains("btn-remover") ? e.target : e.target.closest(".btn-remover");
        const produtoId = button.getAttribute("data-produto-id");
        
        // Remover do array
        produtosAdicionados = produtosAdicionados.filter(p => p.id !== produtoId);
        
        // Remover da tabela
        const linha = document.querySelector(`tr[data-produto-id="${produtoId}"]`);
        if (linha) {
            linha.remove();
        }
        
        atualizarTotalGeral();
        
        // Mostrar alerta se lista estiver vazia
        if (produtosAdicionados.length === 0) {
            document.getElementById("alerta-lista-vazia").classList.remove("d-none");
        }
    }
});
</script>
@stop