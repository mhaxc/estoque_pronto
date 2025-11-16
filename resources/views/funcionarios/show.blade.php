@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalhes da Funcionarios </h3>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $funcionario->id }}</p>
                    <p><strong>Nome:</strong> {{ $funcionario->nome }}</p>
                    <p><strong>Telefone:</strong> {{ $funcionario->telefone }}</p>
                    <p><strong>Cargo:</strong> {{ $funcionario->cargo }}</p>
                    <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection