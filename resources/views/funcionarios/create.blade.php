@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Novo Funcionario</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route(name: 'funcionarios.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                         <div class="form-group">
                            <label for="telefone">telefone</label>
                            <input type="number" class="form-control" id="telefone" name="telefone" required>
                        </div>
                         <div class="form-group">
                            <label for="cargo">cargo</label>
                            <input type="text" class="form-control" id="cargo" name="cargo" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Criar Funcionario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection