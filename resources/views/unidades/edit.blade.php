@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Unidade</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('unidades.update', $unidade->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $unidade->nome }}" required>
                        </div>
                           <div class="form-group">
                            <label for="sigla">sigla</label>
                            <input type="text" class="form-control" id="sigla" name="sigla" value="{{ $unidade->sigla }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Atualizar unidade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection