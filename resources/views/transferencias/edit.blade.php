@extends('adminlte::page')

@section('title', 'Editar Transferência')

@section('content_header')
    <h1>Editar Transferência</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('transferencias.update', $transferencia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="origem">Origem:</label>
                    <input type="text" name="origem" class="form-control" value="{{ $transferencia->origem }}" required>
                </div>
                <div class="form-group">
                    <label for="destino">Destino:</label>
                    <input type="text" name="destino" class="form-control" value="{{ $transferencia->destino }}" required>
                </div>
                <div class="form-group">
                    <label for="data_transferencia">Data da Transferência:</label>
                    <input type="datetime-local" name="data_transferencia" class="form-control" value="{{ \Carbon\Carbon::parse($transferencia->data_transferencia)->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="form-group">
                    <label for="funcionario_id">Funcionário:</label>
                    <select name="funcionario_id" class="form-control" required>
                        @foreach($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}" {{ $transferencia->funcionario_id == $funcionario->id ? 'selected' : '' }}>{{ $funcionario->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacao">Observação:</label>
                    <textarea name="observacao" class="form-control">{{ $transferencia->observacao }}</textarea>
                </div>

                <h4>Produtos</h4>
                <div id="produtos">
                    @foreach($transferencia->produtos as $index => $produto)
                    <div class="row produto">
                        <div class="col-md-5">
                            <label>Produto</label>
                            <select name="produtos[{{ $index }}][produto_id]" class="form-control" required>
                                <option value="">Selecione</option>
                                @foreach($produtos as $p)
                                <option value="{{ $p->id }}" {{ $produto->produto_id == $p->id ? 'selected' : '' }}>{{ $p->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Quantidade</label>
                            <input type="number" name="produtos[{{ $index }}][quantidade]" class="form-control" min="1" value="{{ $produto->quantidade }}" required>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block remover-produto">Remover</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">Adicionar Produto</button>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let index = {{ count($transferencia->produtos) }};
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