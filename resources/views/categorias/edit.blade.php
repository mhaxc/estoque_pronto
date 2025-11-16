@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Categoria</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $categoria->nome }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Atualizar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection