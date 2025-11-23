<?php

namespace App\Http\Controllers;


use App\Models\Saida;
use App\Models\SaidaItem;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;


class SaidaController extends Controller
{
public function index()
{
$saidas = Saida::with(['funcionario', 'items.produto'])->paginate(20);
return view('saidas.index', compact('saidas'));
}


public function create()
{
$produtos = Produto::all();
$funcionarios = Funcionario::all();
return view('saidas.create', compact('produtos','funcionarios'));
}


public function store(Request $request)
{
$request->validate([
'funcionario_id' => 'required|exists:funcionarios,id',
'data_saida' => 'required|date',
'items.*.produto_id' => 'required|exists:produtos,id',
'items.*.quantidade' => 'required|numeric|min:1',
]);
        



// Criar saída principal
$saida = Saida::create([
'funcionario_id' => $request->funcionario_id,
'data_saida' => $request->data_saida,
'observacao' => $request->observacao,
]);


// Inserir itens vinculados
foreach ($request->input('produtos', []) as $item) {
SaidaItem::create([
'saida_id' => $saida->id,
'produto_id' => $item['produto_id'],
'quantidade' => $item['quantidade'],

]);
        
}
      

return redirect()->route('saidas.index')->with('success', 'Saída registrada com sucesso!');
}


public function show(Saida $saida)
{
$saida->load(['funcionario', 'items.produto']);
return view('saidas.show', compact('saida'));
}


public function destroy(Saida $saida)
{
    $saida->delete();
 return redirect()->route('saidas.index')->with('success', 'Saída excluída!');

}
}