{{-- resources/views/transferencias/create.blade.php --}}
@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Nova Transferência</h1>
    
    <form action="{{ route('transferencias.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" id="produto_id" class="form-control" required>
                <option value="">Selecione...</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="data_transferencia">Data da Transferência</label>
            <input type="date" name="data_transferencia" id="data_transferencia" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="origem">Origem</label>
            <input type="text" name="origem" id="origem" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" id="observacao" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="funcionario_id">Funcionário Responsável</label>
            <select name="funcionario_id" id="funcionario_id" class="form-control" required>
                <option value="">Selecione...</option>
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar Transferência</button>
    </form>
</div>
@endsection