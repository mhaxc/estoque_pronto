<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = Unidade::all();
        return view('unidades.index', compact('unidades'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
             'sigla' => 'required|string|max:2'
        ]);

        Unidade::create($request->all());

        return redirect()->route('unidades.index')
        ->with('success', 'unidades criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidade $unidade)
    {
        return view('unidades.show', compact('unidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidade $unidade)
    {
        return view('unidades.edit', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidade $unidade)
    {
         $request->validate([
             'nome' => 'required|string|max:255',
             'sigla' => 'required|string|max:2',
            
        ]);

        $unidade->update($request->all());

        return redirect()->route('unidades.index')
        ->with('success', 'Unidades atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidade $unidade)
    {
        $unidade->delete();

        return redirect()->route('unidades.index')
        ->with('success', 'Unidade excluída com sucesso.');
    }
}
