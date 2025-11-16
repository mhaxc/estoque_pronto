@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Criar Nova unidade</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route(name: 'unidades.store') }}" method="POST">
                        @csrf
                        @if(session('success'))
                        <div class="alert alert-success">
                          {{ session('success') }}
                             </div>
                             @endif
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="sigla">sigla</label>
                            <input type="text" class="form-control" id="sigla" name="sigla" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Criar unidade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection