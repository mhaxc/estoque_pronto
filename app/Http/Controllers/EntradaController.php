<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::orderBy('id', 'desc')->paginate(20);
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $produtos = Produto::orderBy('nome')->get();
        $funcionarios = Funcionario::all();
        return view('entradas.create', compact('produtos','funcionarios'));
    }

    public function store(Request $request)
{
    $request->validate([
        'data_entrada' => 'required|date',
        'numero_nota' => 'nullable|string',
        'observacao' => 'nullable|string',
        'produtos.*.produto_id' => 'required|exists:produtos,id',
        'produtos.*.quantidade' => 'required|integer|min:1',
    ]);

    // 1. Criar a entrada
    $entrada = Entrada::create([
        'data_entrada' => $request->data_entrada,
        'numero_nota'  => $request->numero_nota,
        'observacao'   => $request->observacao,
        'funcionario_id' => $request->funcionario_id, // se quiser pegar automático
    ]);

    // 2. Salvar os produtos relacionados
    foreach ($request->produtos as $item) {

        // Vincula entrada ao produto
        $entrada->produtos()->attach($item['produto_id'], [
            'quantidade' => $item['quantidade']
        ]);

        // 3. Atualiza automaticamente o estoque do produto
        $produto = Produto::find($item['produto_id']);
        $produto->estoque_atual += $item['quantidade'];
        $produto->save();
    }

    return redirect()->route('entradas.index')
        ->with('success', 'Entrada registrada com sucesso!');
}
    public function show($id)
    {
        $entrada = Entrada::findOrFail($id);
        return view('entradas.show', compact('entrada'));
    }

    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $produtos = Produto::orderBy('nome')->get();
         $funcionarios = Funcionario::all();
        return view('entradas.edit', compact('entrada', 'produtos','funcionarios'));
    }

   public function update(Request $request, $id)
{
    $entrada = Entrada::findOrFail($id);

    $request->validate([
        'data_entrada' => 'required|date',
        'numero_nota' => 'nullable|string',
        'observacao' => 'nullable|string',
        'produtos.*.produto_id' => 'required|exists:produtos,id',
        'produtos.*.quantidade' => 'required|integer|min:1',
    ]);

    // 1. Reverter o estoque dos produtos antigos
    foreach ($entrada->produtos as $produtoAntigo) {
        $produto = Produto::find($produtoAntigo->id);
        if ($produto) {
            $produto->estoque_atual -= $produtoAntigo->pivot->quantidade;
            $produto->save();
        }
    }

    // 2. Atualizar os dados básicos da entrada
    $entrada->update([
        'data_entrada' => $request->data_entrada,
        'numero_nota' => $request->numero_nota,
        'observacao' => $request->observacao,
        'funcionario_id' => $request->funcionario_id,
    ]);

    // 3. Remover produtos antigos
    $entrada->produtos()->detach();

    // 4. Adicionar novos produtos e atualizar estoque
    foreach ($request->produtos as $item) {
        $entrada->produtos()->attach($item['produto_id'], [
            'quantidade' => $item['quantidade']
        ]);

        $produto = Produto::find($item['produto_id']);
        $produto->estoque_atual += $item['quantidade'];
        $produto->save();
    }

    return redirect()->route('entradas.index')
        ->with('success', 'Entrada atualizada com sucesso!');
}

    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);

        // restaura estoque antes de excluir
        foreach ($entrada->produtos as $item) {
            $produto = Produto::find($item->id);
            if ($produto) {
                $produto->estoque_atual -= $item->pivot->quantidade;
                $produto->save();
            }
        }

        $entrada->delete();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada removida com sucesso!');
    }
}
