@extends('adminlte::page')
@section('title','Nova Transferência')
@section('content_header')<h1>Nova Transferência</h1>@endsection
@section('content')
<form action="{{ route('transferencias.store') }}" method="POST"> @csrf
<div class="card p-3">

{{-- CAMPOS --}}
<div class="row">
<div class="col-md-4">
<label>Origem</label>
<input type="text" class="form-control" name="origem" value="{{ old('origem') }}" required>
</div>
<div class="col-md-4">
<label>Destino</label>
<input type="text" class="form-control" name="destino" value="{{ old('destino') }}" required>
</div>
<div class="col-md-4">
<label>Data</label>
<input type="date" class="form-control" name="data_transferencia" value="{{ old('data_transferencia', date('Y-m-d')) }}" required>
</div>
</div>

<div class="row mt-3">
<div class="col-md-6">
<label>Funcionário</label>
<select name="funcionario_id" class="form-control" required>
<option value="">Selecione</option>
@foreach($funcionarios as $f)
<option value="{{ $f->id }}" {{ old('funcionario_id') == $f->id ? 'selected' : '' }}>{{ $f->nome }}</option>
@endforeach
</select>
</div>
<div class="col-md-6">
<label>Observação</label>
<input type="text" class="form-control" name="observacao" value="{{ old('observacao') }}">
</div>
</div>

{{-- ITENS --}}
<hr>
<h4>Itens da Transferência</h4>
<table class="table table-bordered" id="tabela-itens">
<thead class="thead-dark">
<tr>
    <th>Produto</th>
    <th>Estoque Atual</th>
    <th>Preço Unitário</th>
    <th>Quantidade</th>
    <th>Ações</th>
</tr>
</thead>
<tbody></tbody>
</table>

<div class="alert alert-warning d-none" id="alerta-estoque-insuficiente">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    <span id="mensagem-alerta"></span>
</div>

<button type="button" class="btn btn-secondary" id="add-item">
    <i class="fas fa-plus mr-1"></i> Adicionar Item
</button>
<button class="btn btn-success mt-3" id="btn-salvar">
    <i class="fas fa-save mr-1"></i> Salvar Transferência
</button>
</div>
</form>

<script>
let index = 0;
let produtosAdicionados = [];

document.getElementById('add-item').addEventListener('click', function(){
    let html = `
    <tr class="item-transferencia" data-index="${index}">
        <td>
            <select name="produtos[${index}][produto_id]" class="form-control select-produto" required onchange="atualizarInfoProduto(this)">
                <option value="">Selecione um produto</option>
                @foreach($produtos as $p)
                <option value="{{ $p->id }}" 
                    data-estoque="{{ $p->estoque_atual }}" 
                    data-preco="{{ $p->preco }}"
                    data-nome="{{ $p->nome }}">
                    {{ $p->nome }} - Estoque: {{ $p->estoque_atual }} - R$ {{ number_format($p->preco, 2, ',', '.') }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="text-center">
            <span class="estoque-atual">0</span>
        </td>
        <td class="text-right">
            <span class="preco-unitario">R$ 0,00</span>
        </td>
        <td>
            <input type="number" min="0.1" step="0.1" class="form-control input-quantidade" 
                   name="produtos[${index}][quantidade]" required 
                   oninput="validarEstoque(this)">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm btn-remove">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>`;
    
    document.querySelector('#tabela-itens tbody').insertAdjacentHTML('beforeend', html);
    index++;
});

// Atualizar informações do produto quando selecionado
function atualizarInfoProduto(select) {
    const option = select.options[select.selectedIndex];
    const tr = select.closest('tr');
    
    if (option && option.value !== "") {
        const estoque = option.getAttribute('data-estoque');
        const preco = option.getAttribute('data-preco');
        
        tr.querySelector('.estoque-atual').textContent = estoque;
        tr.querySelector('.preco-unitario').textContent = 'R$ ' + parseFloat(preco).toFixed(2).replace('.', ',');
        
        // Limpar quantidade e validação
        tr.querySelector('.input-quantidade').value = '';
        tr.classList.remove('table-danger');
        document.getElementById('alerta-estoque-insuficiente').classList.add('d-none');
    } else {
        tr.querySelector('.estoque-atual').textContent = '0';
        tr.querySelector('.preco-unitario').textContent = 'R$ 0,00';
    }
}

// Validar estoque em tempo real
function validarEstoque(input) {
    const tr = input.closest('tr');
    const select = tr.querySelector('.select-produto');
    const quantidade = parseFloat(input.value);
    
    if (!select.value || isNaN(quantidade) || quantidade <= 0) {
        tr.classList.remove('table-danger');
        document.getElementById('alerta-estoque-insuficiente').classList.add('d-none');
        return;
    }
    
    const estoque = parseFloat(select.options[select.selectedIndex].getAttribute('data-estoque'));
    const produtoNome = select.options[select.selectedIndex].getAttribute('data-nome');
    
    if (quantidade > estoque) {
        // Mostrar alerta
        tr.classList.add('table-danger');
        document.getElementById('alerta-estoque-insuficiente').classList.remove('d-none');
        document.getElementById('mensagem-alerta').textContent = 
            `Estoque insuficiente para ${produtoNome}! Quantidade solicitada: ${quantidade}, Estoque disponível: ${estoque}`;
        
        // Desabilitar botão salvar
        document.getElementById('btn-salvar').disabled = true;
    } else {
        // Remover alerta
        tr.classList.remove('table-danger');
        document.getElementById('alerta-estoque-insuficiente').classList.add('d-none');
        document.getElementById('btn-salvar').disabled = false;
    }
}

// Remover item
document.addEventListener('click', function(e){
    if(e.target.classList.contains('btn-remove') || e.target.closest('.btn-remove')){
        const button = e.target.classList.contains('btn-remove') ? e.target : e.target.closest('.btn-remove');
        button.closest('tr').remove();
        
        // Verificar se ainda há itens com estoque insuficiente
        const itensComProblema = document.querySelectorAll('.table-danger');
        if (itensComProblema.length === 0) {
            document.getElementById('alerta-estoque-insuficiente').classList.add('d-none');
            document.getElementById('btn-salvar').disabled = false;
        }
    }
});

// Validação antes do envio do formulário
document.querySelector('form').addEventListener('submit', function(e) {
    let estoqueInsuficiente = false;
    const itens = document.querySelectorAll('.item-transferencia');
    
    for (let item of itens) {
        const select = item.querySelector('.select-produto');
        const inputQuantidade = item.querySelector('.input-quantidade');
        
        if (select.value && inputQuantidade.value) {
            const estoque = parseFloat(select.options[select.selectedIndex].getAttribute('data-estoque'));
            const quantidade = parseFloat(inputQuantidade.value);
            
            if (quantidade > estoque) {
                estoqueInsuficiente = true;
                break;
            }
        }
    }
    
    if (estoqueInsuficiente) {
        e.preventDefault();
        alert('Não é possível salvar a transferência. Existem itens com quantidade maior que o estoque disponível!');
    }
});

// Carregar dados antigos se houver erro de validação
@if(old('produtos'))
    @foreach(old('produtos') as $index => $produto)
        // Simular clique para adicionar linha
        document.getElementById('add-item').click();
        
        // Preencher dados na última linha adicionada
        const linhas = document.querySelectorAll('.item-transferencia');
        const ultimaLinha = linhas[linhas.length - 1];
        
        if (ultimaLinha) {
            const select = ultimaLinha.querySelector('.select-produto');
            const inputQuantidade = ultimaLinha.querySelector('.input-quantidade');
            
            // Selecionar produto
            select.value = '{{ $produto["produto_id"] }}';
            
            // Disparar change para carregar estoque e preço
            const event = new Event('change');
            select.dispatchEvent(event);
            
            // Preencher quantidade
            inputQuantidade.value = '{{ $produto["quantidade"] }}';
            
            // Validar estoque
            validarEstoque(inputQuantidade);
        }
    @endforeach
@endif
</script>

<style>
.table-danger {
    background-color: #f8d7da;
}
.estoque-atual, .preco-unitario {
    font-weight: bold;
    padding: 8px 0;
    display: block;
}
</style>
@endsection