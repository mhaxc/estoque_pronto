@extends('adminlte::page')

@section('title', 'Editar Saída')

@section('content_header')
<h1>Editar Saída</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Saída #{{ $saida->id }}</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('saidas.update', $saida->id) }}" method="POST" id="form-saida">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="funcionario_id">Funcionário *</label>
                        <select name="funcionario_id" id="funcionario_id" class="form-control @error('funcionario_id') is-invalid @enderror" required>
                            <option value="">Selecione um funcionário</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->id }}" 
                                    {{ old('funcionario_id', $saida->funcionario_id) == $funcionario->id ? 'selected' : '' }}>
                                    {{ $funcionario->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('funcionario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_saida">Data da Saída *</label>
                        <input type="date" name="data_saida" id="data_saida" 
                               class="form-control @error('data_saida') is-invalid @enderror"
                              value="{{ old('data_saida', isset($saida->data_saida) ? (is_string($saida->data_saida) ? $saida->data_saida : $saida->data_saida->format('Y-m-d')) : '') }}"
                        @error('data_saida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h4>Produtos</h4>
            
            <div id="produtos-container">
                @foreach($saida->items as $index => $item)
                <div class="produto-item border p-3 mb-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Produto *</label>
                                <select name="items[{{ $index }}][produto_id]" 
                                        class="form-control produto-select @error('items.'.$index.'.produto_id') is-invalid @enderror" required>
                                    <option value="">Selecione um produto</option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->id }}" 
                                            data-preco="{{ $produto->preco }}"
                                            {{ old('items.'.$index.'.produto_id', $item->produto_id) == $produto->id ? 'selected' : '' }}>
                                            {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('items.'.$index.'.produto_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantidade *</label>
                                <input type="number" name="items[{{ $index }}][quantidade]" 
                                       class="form-control quantidade @error('items.'.$index.'.quantidade') is-invalid @enderror"
                                       value="{{ old('items.'.$index.'.quantidade', $item->quantidade) }}" 
                                       min="1" step="1" required>
                                @error('items.'.$index.'.quantidade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Preço Unitário</label>
                                <input type="text" class="form-control preco-unitario" 
                                       value="R$ {{ number_format($item->produto->preco, 2, ',', '.') }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                @if($index > 0)
                                <button type="button" class="btn btn-danger btn-block remover-produto">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Subtotal: R$ <span class="subtotal">{{ number_format($item->produto->preco * $item->quantidade, 2, ',', '.') }}</span></strong>
                        </div>
                    </div>
                    
                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                </div>
                @endforeach
            </div>

            <button type="button" id="adicionar-produto" class="btn btn-secondary mb-3">
                <i class="fas fa-plus"></i> Adicionar Produto
            </button>

            <div class="row mt-4">
                <div class="col-md-12 text-right">
                    <h3>Total Geral: R$ <span id="total_geral">0,00</span></h3>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Saída
                </button>
                <a href="{{ route('saidas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .produto-item {
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    
    .preco-unitario, .subtotal {
        font-weight: bold;
        color: #28a745;
    }
</style>
@stop

@section('js')
<script>
    let produtoIndex = {{ count($saida->items) }};

    document.addEventListener('DOMContentLoaded', function() {
        calcularTotal();
        
        // Adicionar novo produto
        document.getElementById('adicionar-produto').addEventListener('click', function() {
            const container = document.getElementById('produtos-container');
            const template = `
                <div class="produto-item border p-3 mb-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Produto *</label>
                                <select name="items[${produtoIndex}][produto_id]" 
                                        class="form-control produto-select" required>
                                    <option value="">Selecione um produto</option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->id }}" 
                                            data-preco="{{ $produto->preco }}">
                                            {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantidade *</label>
                                <input type="number" name="items[${produtoIndex}][quantidade]" 
                                       class="form-control quantidade" value="1" min="1" step="1" required>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Preço Unitário</label>
                                <input type="text" class="form-control preco-unitario" value="R$ 0,00" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-block remover-produto">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Subtotal: R$ <span class="subtotal">0,00</span></strong>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', template);
            produtoIndex++;
            
            // Adicionar eventos ao novo elemento
            const novoItem = container.lastElementChild;
            adicionarEventosProduto(novoItem);
        });

        // Adicionar eventos a todos os produtos existentes
        document.querySelectorAll('.produto-item').forEach(item => {
            adicionarEventosProduto(item);
        });

        function adicionarEventosProduto(item) {
            const select = item.querySelector('.produto-select');
            const quantidade = item.querySelector('.quantidade');
            const precoUnitario = item.querySelector('.preco-unitario');
            const subtotal = item.querySelector('.subtotal');
            const removerBtn = item.querySelector('.remover-produto');

            // Evento para mudança de produto
            select.addEventListener('change', function() {
                const preco = this.options[this.selectedIndex]?.getAttribute('data-preco') || 0;
                precoUnitario.value = 'R$ ' + parseFloat(preco).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                calcularSubtotal(item);
                calcularTotal();
            });

            // Evento para mudança de quantidade
            quantidade.addEventListener('input', function() {
                calcularSubtotal(item);
                calcularTotal();
            });

            // Evento para remover produto
            if (removerBtn) {
                removerBtn.addEventListener('click', function() {
                    item.remove();
                    calcularTotal();
                    reordenarIndexes();
                });
            }

            // Calcular subtotal inicial
            calcularSubtotal(item);
        }

        function calcularSubtotal(item) {
            const select = item.querySelector('.produto-select');
            const quantidade = item.querySelector('.quantidade');
            const subtotal = item.querySelector('.subtotal');
            
            const preco = select.options[select.selectedIndex]?.getAttribute('data-preco') || 0;
            const qtd = parseFloat(quantidade.value) || 0;
            const total = preco * qtd;
            
            subtotal.textContent = total.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function calcularTotal() {
            let total = 0;
            
            document.querySelectorAll('.produto-item').forEach(item => {
                const subtotalText = item.querySelector('.subtotal').textContent;
                const subtotalValue = parseFloat(subtotalText.replace('.', '').replace(',', '.')) || 0;
                total += subtotalValue;
            });
            
            document.getElementById('total_geral').textContent = total.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function reordenarIndexes() {
            const container = document.getElementById('produtos-container');
            const items = container.querySelectorAll('.produto-item');
            
            items.forEach((item, index) => {
                // Atualizar os names dos inputs
                const selects = item.querySelectorAll('select[name^="items["]');
                const inputs = item.querySelectorAll('input[name^="items["]');
                
                selects.forEach(select => {
                    select.name = select.name.replace(/items\[\d+\]/, `items[${index}]`);
                });
                
                inputs.forEach(input => {
                    if (input.type !== 'hidden' || !input.name.includes('[id]')) {
                        input.name = input.name.replace(/items\[\d+\]/, `items[${index}]`);
                    }
                });
            });
            
            produtoIndex = items.length;
        }

        // Validar formulário antes de enviar
        document.getElementById('form-saida').addEventListener('submit', function(e) {
            const produtos = document.querySelectorAll('.produto-item');
            if (produtos.length === 0) {
                e.preventDefault();
                alert('Adicione pelo menos um produto!');
                return false;
            }
            
            let temErro = false;
            produtos.forEach(item => {
                const select = item.querySelector('.produto-select');
                const quantidade = item.querySelector('.quantidade');
                
                if (!select.value || !quantidade.value || quantidade.value < 1) {
                    temErro = true;
                    select.classList.add('is-invalid');
                    quantidade.classList.add('is-invalid');
                }
            });
            
            if (temErro) {
                e.preventDefault();
                alert('Preencha todos os campos obrigatórios dos produtos!');
            }
        });
    });
</script>
@stop