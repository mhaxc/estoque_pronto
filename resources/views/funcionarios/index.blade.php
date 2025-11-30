@extends('adminlte::page')

@section('title', 'Funcionários')

@section('content_header')
    <h1 class="m-0 text-dark">Funcionários</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Funcionários</h3>
                    <div class="card-tools">
                        <a href="{{ route('funcionarios.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                            Novo Funcionário
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">ID</th>
                                    <th width="25%">Nome</th>
                                    <th width="20%">Telefone</th>
                                    <th width="22%">Cargo</th>
                                    <th width="25%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($funcionarios as $funcionario)
                                <tr>
                                    <td>{{ $funcionario->id }}</td>
                                    <td>{{ $funcionario->nome }}</td>
                                    <td>{{ $funcionario->telefone }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $funcionario->cargo }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('funcionarios.show', $funcionario) }}" 
                                               class="btn btn-info btn-sm"
                                               title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('funcionarios.edit', $funcionario) }}" 
                                               class="btn btn-warning btn-sm"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('funcionarios.destroy', $funcionario) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja excluir este funcionário?')"
                                                        title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($funcionarios->hasPages())
                <div class="card-footer clearfix">
                    {{ $funcionarios->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-group form {
            display: inline-block;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.6em;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop