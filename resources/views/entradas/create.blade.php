@extends('adminlte::page')

@section('title', 'Nova Entrada')

@section('content_header')
    <h1>Registrar Entrada de Produtos</h1>
@stop

@section('content')
<form action="{{ route('entradas.store') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data da Entrada*</label>
                        <input type="date" name="data_entrada" class="form-control" value="{{ old('data_entrada', now()->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Número da Nota</label>
                        <input type="text" name="numero_nota" class="form-control" value="{{ old('numero_nota') }}" placeholder="Opcional">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Funcionário Responsável*</label>
                        <select name="funcionario_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->id }}" {{ old('funcionario_id') == $funcionario->id ? 'selected' : '' }}>
                                    {{ $funcionario->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Observação</label>
                        <input type="text" name="observacao" class="form-control" value="{{ old('observacao') }}" placeholder="Opcional">
                    </div>
                </div>
            </div>

            <hr>

            <h4 class="mb-3">
                <i class="fas fa-boxes"></i>
                Produtos
            </h4>

            <div id="lista-produtos">
                <div class="row produto-item mb-3 border-bottom pb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Produto*</label>
                            <select name="produtos[0][produto_id]" class="form-control select-produto" required>
                                <option value="">Selecione um produto</option>
                                @foreach($produtos as $p)
                                    <option value="{{ $p->id }}" data-estoque="{{ $p->estoque_atual }}" data-preco="{{ $p->preco }}">
                                        {{ $p->nome }} - Estoque: {{ $p->estoque_atual }} - Preço: R$ {{ number_format($p->preco, 2, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Quantidade*</label>
                            <input type="number" name="produtos[0][quantidade]" class="form-control" min="1" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Preço Unitário (R$)</label>
                            <input type="text" name="produtos[0][preco]" class="form-control preco" readonly>
                        </div>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remover mb-3">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-produto" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> Adicionar Produto
            </button>

            <div class="mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Registrar Entrada
                </button>
                <a href="{{ route('entradas.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@stop

@section('css')
<style>
    .select-produto {
        width: 100%;
    }
    .preco {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .produto-item {
        transition: all 0.3s ease;
    }
</style>
@stop

@section('js')
<script>
let index = 1;

document.getElementById("add-produto").addEventListener("click", () => {
    let novoItem = `
        <div class="row produto-item mb-3 border-bottom pb-3">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Produto*</label>
                    <select name="produtos[${index}][produto_id]" class="form-control select-produto" required>
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $p)
                            <option value="{{ $p->id }}" data-estoque="{{ $p->estoque_atual }}" data-preco="{{ $p->preco }}">
                                {{ $p->nome }} - Estoque: {{ $p->estoque_atual }} - Preço: R$ {{ number_format($p->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Quantidade*</label>
                    <input type="number" name="produtos[${index}][quantidade]" class="form-control" min="1" required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Preço Unitário (R$)</label>
                    <input type="text" name="produtos[${index}][preco]" class="form-control preco" readonly>
                </div>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger remover mb-3">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    document.getElementById("lista-produtos").insertAdjacentHTML("beforeend", novoItem);
    index++;
});

// Event delegation para selects dinâmicos
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('select-produto')) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const preco = selectedOption.getAttribute('data-preco');
        const precoInput = e.target.closest('.produto-item').querySelector('.preco');
        
        if (preco) {
            precoInput.value = parseFloat(preco).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            precoInput.value = '';
        }
    }
});

document.addEventListener("click", function(e) {
    if (e.target.classList.contains("remover") || e.target.closest('.remover')) {
        const btn = e.target.classList.contains('remover') ? e.target : e.target.closest('.remover');
        if (document.querySelectorAll('.produto-item').length > 1) {
            btn.closest(".produto-item").remove();
        } else {
            alert('É necessário pelo menos um produto!');
        }
    }
});

// Inicializar preço do primeiro item
document.addEventListener('DOMContentLoaded', function() {
    const primeiroSelect = document.querySelector('.select-produto');
    if (primeiroSelect) {
        const selectedOption = primeiroSelect.options[primeiroSelect.selectedIndex];
        const preco = selectedOption.getAttribute('data-preco');
        const precoInput = document.querySelector('.preco');
        
        if (preco && precoInput) {
            precoInput.value = parseFloat(preco).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }
});
</script>
@stop