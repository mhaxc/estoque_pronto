@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>{{ isset($saida) ? 'Editar' : 'Nova' }} Saida</h1>
    
    <form action="{{ isset($saida) ? route('saidas.update', $saida) : route('saidas.store') }}" method="POST">
        @csrf
        @if(isset($saida))
            @method('PUT')
        @endif
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="produto_id" class="form-label">Produto</label>
                    <select name="produto_id" id="produto_id" class="form-select" required>
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" 
                            {{ (isset($saida) && $saida->produto_id == $produto->id) ? 'selected' : '' }}>
                            {{ $produto->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="funcionario_id" class="form-label">Funcionário</label>
                    <select name="funcionario_id" id="funcionario_id" class="form-select" required>
                        <option value="">Selecione um funcionário</option>
                        @foreach($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}"
                            {{ (isset($saida) && $saida->funcionario_id == $funcionario->id) ? 'selected' : '' }}>
                            {{ $funcionario->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" name="quantidade" id="quantidade" 
                           class="form-control" value="{{ $saida->quantidade ?? old('quantidade') }}" 
                           min="1" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="data_saida" class="form-label">Data de Saida</label>
                    <input type="date" name="data_saida" id="data_entrada" 
                           class="form-control" value="{{ $saida->data_saida ?? old('data_saida') }}" required>
                </div>
            </div>
            
        </div>

        <div class="mb-3">
            <label for="observacao" class="form-label">Observações</label>
            <textarea name="observacao" id="observacao" rows="3" 
                      class="form-control">{{ $saida->observacao ?? old('observacao') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ isset($saida) ? 'Atualizar' : 'Salvar' }}
            </button>
            <a href="{{ route('saidas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection