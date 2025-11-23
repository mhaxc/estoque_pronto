<?php

// app/Http/Controllers/TransferenciaController.php
namespace App\Http\Controllers;

use App\Models\Transferencia;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    public function index()
    {
        $transferencias = Transferencia::with('funcionario')->get();
        return view('transferencias.index', compact('transferencias'));
    }

    public function create()
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        return view('transferencias.create', compact('produtos', 'funcionarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origem' => 'required|string',
            'destino' => 'required|string',
            'data_transferencia' => 'required|date',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'observacao' => 'nullable|string',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1'
        ]);

        $transferencia = Transferencia::create($request->only(['origem', 'destino', 'data_transferencia', 'funcionario_id', 'observacao']));

        foreach ($request->produtos as $produto) {
            $transferencia->produtos()->create([
                'produto_id' => $produto['produto_id'],
                'quantidade' => $produto['quantidade']
            ]);
        }

        return redirect()->route('transferencias.index')->with('success', 'Transferência criada com sucesso.');
    }

    public function show(Transferencia $transferencia)
    {
        $transferencia->load('produtos.produto', 'funcionario');
        return view('transferencias.show', compact('transferencia'));
    }

    public function edit(Transferencia $transferencia)
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        $transferencia->load('produtos');
        return view('transferencias.edit', compact('transferencia', 'produtos', 'funcionarios'));
    }

    public function update(Request $request, Transferencia $transferencia)
    {
        $request->validate([
            'origem' => 'required|string',
            'destino' => 'required|string',
            'data_transferencia' => 'required|date',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'observacao' => 'nullable|string',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1'
        ]);

        $transferencia->update($request->only(['origem', 'destino', 'data_transferencia', 'funcionario_id', 'observacao']));

        // Remover produtos antigos e adicionar os novos
        $transferencia->produtos()->delete();
        foreach ($request->produtos as $produto) {
            $transferencia->produtos()->create([
                'produto_id' => $produto['produto_id'],
                'quantidade' => $produto['quantidade']
            ]);
        }

        return redirect()->route('transferencias.index')->with('success', 'Transferência atualizada com sucesso.');
    }

    public function destroy(Transferencia $transferencia)
    {
        $transferencia->produtos()->delete();
        $transferencia->delete();

        return redirect()->route('transferencias.index')->with('success', 'Transferência excluída com sucesso.');
    }
}