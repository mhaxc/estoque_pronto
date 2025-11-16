@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Editar Transferência</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transferencias.update', $transferencia->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="produto_id" class="form-label">Produto</label>
            <select class="form-select" id="produto_id" name="produto_id" required>
                <option value="">Selecione um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" 
                        {{ old('produto_id', $transferencia->produto_id) == $produto->id ? 'selected' : '' }}>
                        {{ $produto->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" 
                value="{{ old('quantidade', $transferencia->quantidade) }}" 
                min="1" required>
        </div>

        <div class="mb-3">
            <label for="data_transferencia" class="form-label">Data da Transferência</label>
            <input type="date" class="form-control" id="data_transferencia" name="data_transferencia"
                value="{{ old('data_transferencia', $transferencia->data_transferencia->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="origem" class="form-label">Origem</label>
            <input type="text" class="form-control" id="origem" name="origem"
                value="{{ old('origem', $transferencia->origem) }}" maxlength="255" required>
        </div>

        <div class="mb-3">
            <label for="destino" class="form-label">Destino</label>
            <input type="text" class="form-control" id="destino" name="destino"
                value="{{ old('destino', $transferencia->destino) }}" maxlength="255" required>
        </div>

        <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <textarea class="form-control" id="observacao" name="observacao" rows="3">{{ old('observacao', $transferencia->observacao) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="funcionario_id" class="form-label">Funcionário Responsável</label>
            <select class="form-select" id="funcionario_id" name="funcionario_id" required>
                <option value="">Selecione um funcionário</option>
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}"
                        {{ old('funcionario_id', $transferencia->funcionario_id) == $funcionario->id ? 'selected' : '' }}>
                        {{ $funcionario->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Transferência</button>
        <a href="{{ route('transferencias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection