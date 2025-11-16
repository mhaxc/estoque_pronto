<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EntradaController extends Controller
{
    /**
     * Lista todas as entradas
     */
    public function index(): View
    {
        $entradas = Entrada::with(['produto', 'funcionario'])->paginate(10);
        
        return view('entradas.index', compact('entradas'));
    }

    /**
     * Mostra o formulário para criar uma nova entrada
     */
    public function create(): View
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        
        return view('entradas.create', compact('produtos', 'funcionarios'));
    }

    /**
     * Armazena uma nova entrada no banco de dados
     */
    public function store(Request $request): RedirectResponse
    {
         $request->validate(rules: [
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_entrada' => 'required|date',
            'observacao' => 'nullable|string',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'numero_nota' => 'nullable|string|max:255'
        ]);

        Entrada::create($request->all());
       
        $produto = Produto::find($request->produto_id);
        $produto->estoque_atual += $request->quantidade;
        $produto->save();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada registrada com sucesso!');
    }

    /**
     * Exibe uma entrada específica
     */
    public function show(Entrada $entrada): View
    {
        $entrada->load(['produto', 'funcionario']);
        
        return view('entradas.show', compact('entrada'));
    }

    /**
     * Mostra o formulário para editar uma entrada
     */
    public function edit(Entrada $entrada): View
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        
        return view('entradas.edit', compact('entrada', 'produtos', 'funcionarios'));
    }

    /**
     * Atualiza uma entrada no banco de dados
     */
    public function update(Request $request, Entrada $entrada): RedirectResponse
    {
         $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_entrada' => 'required|date',
            'observacao' => 'nullable|string',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'numero_nota' => 'nullable|string|max:255'
        ]);
        // Reverter a quantidade anterior no estoque
        $produto = Produto::find($entrada->produto_id);
        $produto->estoque_atual -= $entrada->quantidade;
        $produto->save();
       
        $entrada->update($request->all());

        // Atualizar o estoque com a nova quantidade
        $produto = Produto::find($request->produto_id);
        $produto->estoque_atual += $request->quantidade;
        $produto->save();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada atualizada com sucesso!');
    }

    /**
     * Remove uma entrada do banco de dados
     */
    public function destroy(Entrada $entrada): RedirectResponse
    {
       // Reverter a quantidade no estoque
        $produto = Produto::find($entrada->produto_id);
        $produto->estoque_atual -= $entrada->quantidade;
        $produto->save();
       
        $entrada->delete();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada excluída com sucesso!');
    }
}