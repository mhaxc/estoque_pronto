@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Editar Saída #{{ $saida->id }}</h1>

    <form action="{{ route('saidas.update', $saida->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Mesmos campos do create, mas com valores preenchidos -->
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select name="produto_id" class="form-control" required>
                @foreach($produtos as $produto)
                <option value="{{ $produto->id }}" {{ $saida->produto_id == $produto->id ? 'selected' : '' }}>
                    {{ $produto->nome }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="{{ $saida->quantidade }}" required min="1">
        </div>

        <div class="form-group">
            <label for="data_saida">Data da Saída</label>
            <input type="date" name="data_saida" class="form-control" value="{{ $saida->data_saida->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="valor">Valor (R$)</label>
            <input type="text" name="valor" class="form-control" value="{{ number_format($saida->valor, 2, ',', '') }}" required>
        </div>

        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" class="form-control" rows="3">{{ $saida->observacao }}</textarea>
        </div>

        <div class="form-group">
            <label for="funcionario_id">Funcionário Responsável</label>
            <select name="funcionario_id" class="form-control" required>
                @foreach($funcionarios as $funcionario)
                <option value="{{ $funcionario->id }}" {{ $saida->funcionario_id == $funcionario->id ? 'selected' : '' }}>
                    {{ $funcionario->nome }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection