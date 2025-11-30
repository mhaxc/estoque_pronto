@extends('adminlte::page')

@section('title', 'unidades')

@section('content_header')
    <h1>Unidades</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('unidades.create') }}" class="btn btn-primary">Nova unidade</a>
              
            @if(session('success'))
            <div class="alert alert-success">
            {{ session('success') }}
             </div>
             @endif
        
            </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>sigla</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unidades as $unidade)
                    <tr>
                        <td>{{ $unidade->id }}</td>
                        <td>{{ $unidade->nome }}</td>
                        <td>{{ $unidade->sigla }}</td>
                        <td>
                            <a href="{{ route('unidades.show', $unidade) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('unidades.edit', $unidade) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('unidades.destroy', $unidade) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">

                                    <i class="fas fa-trash"> excluir </i>

                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop