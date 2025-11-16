@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar funcionario</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nome">Nome</label>
                              <label for="telefone">Telefone</label>
                                <label for="cargo">Cargo</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $funcionario->nome }}" required>
                            <br/>
                            <input type="number" class="form-control" id="telefone" name="telefone" value="{{ $funcionario->telefone }}" required>
                            <br/>
                            <input type="text" class="form-control" id="cargo" name="cargo" value="{{ $funcionario->cargo }}" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Atualizar funcionario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection