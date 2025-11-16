<?php

namespace App\Http\Controllers;

use App\Models\Transferencia;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    public function index()
    {
        $transferencias = Transferencia::with(['produto', 'funcionario'])->paginate(10);
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
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_transferencia' => 'required|date',
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'observacao' => 'nullable|string',
            'funcionario_id' => 'required|exists:funcionarios,id'
        ]);

        Transferencia::create($request->all());

        return redirect()->route('transferencias.index')
            ->with('success', 'Transferência registrada com sucesso!');
    }

    public function show(Transferencia $transferencia)
    {
        return view('transferencias.show', compact('transferencia'));
    }

    public function edit(Transferencia $transferencia)
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        return view('transferencias.edit', compact('transferencia', 'produtos', 'funcionarios'));
    }

    public function update(Request $request, Transferencia $transferencia)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_transferencia' => 'required|date',
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'observacao' => 'nullable|string',
            'funcionario_id' => 'required|exists:funcionarios,id'
        ]);

       


        return redirect()->route('transferencias.index')
            ->with('success', 'Transferência atualizada com sucesso!');
    }

    public function destroy(Transferencia $transferencia)
    {
        $transferencia->delete();

        return redirect()->route('transferencias.index')
            ->with('success', 'Transferência excluída com sucesso!');
    }
}