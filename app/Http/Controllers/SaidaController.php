<?php

namespace App\Http\Controllers;

use App\Models\Saida;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saidas = Saida::with(['produto', 'funcionario'])->paginate(10);
        
        return view('saidas.index', compact('saidas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        
        return view('saidas.create', compact('produtos', 'funcionarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request): RedirectResponse
    {
         $request->validate(rules: [
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_saida' => 'required|date',
            'observacao' => 'nullable|string',
            'funcionario_id' => 'required|exists:funcionarios,id',
            
        ]);

        Saida::create($request->all());
       
    

        return redirect()->route('saidas.index')
            ->with('success', 'Saida registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Saida $saida)
    {
        $saida->load(['produto', 'funcionario']);
        
        return view('saidas.show', compact('saida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saida $saida)
    {
        $produtos = Produto::all();
        $funcionarios = Funcionario::all();
        
        return view('saidas.edit', compact('saida', 'produtos', 'funcionarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saida $saida)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'data_saida' => 'required|date',
            'valor' => 'required|numeric|min:0',
            'observacao' => 'nullable|string|max:500',
            'funcionario_id' => 'required|exists:funcionarios,id'
        ]);

        try {
            DB::transaction(function () use ($saida, $validated) {
                $saida->update($validated);
            });

            return redirect()->route('saidas.index')
                ->with('success', 'Saída atualizada com sucesso!');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar saída: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saida $saida)
    {
        try {
            $saida->delete();

            return redirect()->route('saidas.index')
                ->with('success', 'Saída excluída com sucesso!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir saída: ' . $e->getMessage());
        }
    }
}