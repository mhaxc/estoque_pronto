@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Editar Entrada #{{ $entrada->id }}</h1>
    <form action="{{ route('entradas.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" class="form-control" required>
                @foreach($produtos as $produto)
                <option value="{{ $produto->id }}" {{ $entrada->produto_id == $produto->id ? 'selected' : '' }}>
                    {{ $produto->nome }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="{{ $entrada->quantidade }}" required>
        </div>

        <div class="form-group">
            <label for="data_entrada">Data de Entrada</label>
            <input type="date" name="data_entrada" class="form-control" value="{{ $entrada->data_entrada->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="funcionario_id">Funcionário</label>
            <select name="funcionario_id" class="form-control" required>
                @foreach($funcionarios as $funcionario)
                <option value="{{ $funcionario->id }}" {{ $entrada->funcionario_id == $funcionario->id ? 'selected' : '' }}>
                    {{ $funcionario->nome }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="numero_nota">Número da Nota</label>
            <input type="text" name="numero_nota" class="form-control" value="{{ $entrada->numero_nota }}">
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" class="form-control" rows="3">{{ $entrada->observacao }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Entrada</button>
    </form>
</div>
@endsection