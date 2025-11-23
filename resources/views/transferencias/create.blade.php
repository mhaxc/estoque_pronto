@extends('adminlte::page')

@section('title', 'Nova Transferência')

@section('content_header')
    <h1>Nova Transferência</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('transferencias.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="origem">Origem:</label>
                    <input type="text" name="origem" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="destino">Destino:</label>
                    <input type="text" name="destino" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_transferencia">Data da Transferência:</label>
                    <input type="datetime-local" name="data_transferencia" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="funcionario_id">Funcionário:</label>
                    <select name="funcionario_id" class="form-control" required>
                        @foreach($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacao">Observação:</label>
                    <textarea name="observacao" class="form-control"></textarea>
                </div>

                <h4>Produtos</h4>
                <div id="produtos">
                    <div class="row produto">
                        <div class="col-md-5">
                            <label>Produto</label>
                            <select name="produtos[0][produto_id]" class="form-control" required>
                                <option value="">Selecione</option>
                                @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Quantidade</label>
                            <input type="number" name="produtos[0][quantidade]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block remover-produto">Remover</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">Adicionar Produto</button>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let index = 1;
        document.getElementById('adicionar-produto').addEventListener('click', function() {
            let novoProduto = document.querySelector('.produto').cloneNode(true);
            novoProduto.querySelectorAll('input, select').forEach(function(campo) {
                campo.name = campo.name.replace(/\[\d\]/, '[' + index + ']');
                campo.value = '';
            });
            document.getElementById('produtos').appendChild(novoProduto);
            index++;
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remover-produto')) {
                if (document.querySelectorAll('.produto').length > 1) {
                    e.target.closest('.produto').remove();
                } else {
                    alert('Pelo menos um produto é necessário.');
                }
            }
        });
    });
</script>
@stop