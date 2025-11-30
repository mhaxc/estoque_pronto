@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-boxes mr-2"></i>
        Produtos
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-success">
                    <h3 class="card-title text-white">
                        <i class="fas fa-list mr-2"></i>
                        Lista de Produtos
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('produtos.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Novo Produto
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($produtos->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="icon fas fa-info-circle mr-2"></i>
                            Nenhum produto cadastrado ainda.
                            <a href="{{ route('produtos.create') }}" class="alert-link ml-1">
                                Clique aqui para criar o primeiro produto.
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="8%">ID</th>
                                        <th width="20%">Nome</th>
                                        <th width="15%">Categoria</th>
                                        <th width="12%">Preço</th>
                                        <th width="12%">Estoque Mínimo</th>
                                        <th width="12%">Estoque Atual</th>
                                        <th width="11%">Status</th>
                                        <th width="10%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produtos as $produto)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">#{{ $produto->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $produto->nome }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $produto->categoria->nome }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-success font-weight-bold">
                                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $produto->estoque_minimo }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold {{ $produto->estoque_atual <= $produto->estoque_minimo ? 'text-warning' : 'text-success' }}">
                                                {{ $produto->estoque_atual }}
                                            </span>
                                            @if($produto->estoque_atual <= $produto->estoque_minimo)
                                                <i class="fas fa-exclamation-triangle text-warning ml-1" title="Estoque baixo"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($produto->estoque_atual <= $produto->estoque_minimo)
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Baixo
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Normal
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('produtos.show', $produto->id) }}" 
                                                   class="btn btn-info"
                                                   title="Visualizar produto">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('produtos.edit', $produto->id) }}" 
                                                   class="btn btn-warning"
                                                   title="Editar produto">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Tem certeza que deseja excluir o produto \\'{{ $produto->nome }}\\'?')"
                                                            title="Excluir produto">
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

                @if($produtos->hasPages())
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $produtos->links() }}
                    </div>
                    <div class="float-left">
                        <small class="text-muted">
                            Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} registros
                        </small>
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
        .card-header.bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        }
        .thead-light th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .badge {
            font-size: 0.85em;
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

            // Adiciona confirmação para exclusão
            $('form').on('submit', function(e) {
                var form = this;
                e.preventDefault();
                
                swal({
                    title: 'Tem certeza?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: null,
                            visible: true,
                            className: "btn-secondary",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Sim, excluir!",
                            value: true,
                            visible: true,
                            className: "btn-danger",
                            closeModal: false
                        }
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@stop