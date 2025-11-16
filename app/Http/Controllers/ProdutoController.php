<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Unidade;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['categoria', 'unidade'])->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $unidades = Unidade::all();
        return view('produtos.create', compact('categorias', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'unidade_id' => 'required|exists:unidades,id',
            'preco' => 'required|numeric|min:0',
            'estoque_minimo' => 'nullable|integer|min:0',
            'estoque_atual' => 'nullable|integer|min:0',
        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        $produto->load(['categoria', 'unidade']);
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::all();
        $unidades = Unidade::all();
        return view('produtos.edit', compact('produto', 'categorias', 'unidades'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'unidade_id' => 'required|exists:unidades,id',
            'preco' => 'required|numeric|min:0',
            'estoque_minimo' => 'nullable|integer|min:0',
            'estoque_atual' => 'nullable|integer|min:0',
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}