@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>{{ isset($entrada) ? 'Editar' : 'Nova' }} Entrada</h1>
    
    <form action="{{ isset($entrada) ? route('entradas.update', $entrada) : route('entradas.store') }}" method="POST">
        @csrf
        @if(isset($entrada))
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
                            {{ (isset($entrada) && $entrada->produto_id == $produto->id) ? 'selected' : '' }}>
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
                            {{ (isset($entrada) && $entrada->funcionario_id == $funcionario->id) ? 'selected' : '' }}>
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
                           class="form-control" value="{{ $entrada->quantidade ?? old('quantidade') }}" 
                           min="1" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="data_entrada" class="form-label">Data de Entrada</label>
                    <input type="date" name="data_entrada" id="data_entrada" 
                           class="form-control" value="{{ $entrada->data_entrada ?? old('data_entrada') }}" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="numero_nota" class="form-label">Número da Nota</label>
                    <input type="text" name="numero_nota" id="numero_nota" 
                           class="form-control" value="{{ $entrada->numero_nota ?? old('numero_nota') }}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="observacao" class="form-label">Observações</label>
            <textarea name="observacao" id="observacao" rows="3" 
                      class="form-control">{{ $entrada->observacao ?? old('observacao') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ isset($entrada) ? 'Atualizar' : 'Salvar' }}
            </button>
            <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection