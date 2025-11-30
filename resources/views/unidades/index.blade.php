@extends('adminlte::page')

@section('title', 'Unidades')

@section('content_header')
    <h1 class="m-0 text-dark">Unidades</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-building mr-2"></i>
                        Lista de Unidades
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('unidades.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle"></i>
                            Nova Unidade
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($unidades->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="icon fas fa-info-circle"></i>
                            Nenhuma unidade cadastrada ainda.
                            <a href="{{ route('unidades.create') }}" class="alert-link">Clique aqui para criar a primeira unidade.</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="40%">Nome</th>
                                        <th width="20%">Sigla</th>
                                        <th width="30%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unidades as $unidade)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">#{{ $unidade->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $unidade->nome }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary badge-lg">
                                                {{ $unidade->sigla }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('unidades.show', $unidade) }}" 
                                                   class="btn btn-info"
                                                   title="Visualizar detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('unidades.edit', $unidade) }}" 
                                                   class="btn btn-warning"
                                                   title="Editar unidade">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('unidades.destroy', $unidade) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Tem certeza que deseja excluir a unidade \\'{{ $unidade->nome }}\\'?')"
                                                            title="Excluir unidade">
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
                    @endif
                </div>

                @if($unidades->hasPages())
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $unidades->links() }}
                    </div>
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
        .badge-lg {
            font-size: 1em;
            padding: 0.5em 0.8em;
            font-weight: bold;
        }
        .card-header.bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        .thead-light th {
            background-color: #f8f9fa;
            font-weight: 600;
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

            // Tooltip para os botões
            $('[title]').tooltip();
        });
    </script>
@stop