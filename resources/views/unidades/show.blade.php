@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalhes da unidade</h3>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $unidade->id }}</p>
                    <p><strong>Nome:</strong> {{ $unidade->nome }}</p>
                    <p><strong>sigla:</strong> {{ $unidade->sigla }}</p>
                    <a href="{{ route('unidades.edit', $unidade->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('unidades.destroy', $unidade->id) }}" method="POST" style="display:inline;">
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