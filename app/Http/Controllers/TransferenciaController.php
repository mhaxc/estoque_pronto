<?php

namespace App\Http\Controllers;


use App\Models\Transferencia;
use App\Models\TransferenciaItem;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransferenciaController extends Controller
{
public function index()
{
$transferencias = Transferencia::with('funcionario')->orderBy('id','DESC')->paginate(20);
return view('transferencias.index', compact('transferencias'));
}


public function create()
{
$produtos = Produto::all();
$funcionarios = Funcionario::all();
return view('transferencias.create', compact('produtos','funcionarios'));
}


public function store(Request $request)
{
$request->validate([
'origem' => 'required',
'destino' => 'required',
'data_transferencia' => 'required|date',
'funcionario_id' => 'required|exists:funcionarios,id',
'produtos.*.produto_id' => 'required|exists:produtos,id',
'produtos.*.quantidade' => 'required|numeric|min:0.1',
]);


DB::transaction(function () use ($request) {
$t = Transferencia::create([
'origem' => $request->origem,
'destino' => $request->destino,
'data_transferencia' => $request->data_transferencia,
'funcionario_id' => $request->funcionario_id,
'observacao' => $request->observacao,
]);


foreach ($request->produtos as $item) {
TransferenciaItem::create([
'transferencia_id' => $t->id,
'produto_id' => $item['produto_id'],
'quantidade' => $item['quantidade'],
]);
}
});


return redirect()->route('transferencias.index')->with('success','Transferência criada com sucesso!');
}

public function show($id)
{
$transferencia = Transferencia::with(['items','funcionario'])->findOrFail($id);
return view('transferencias.show', compact('transferencia'));
}
public function edit($id)
{
$transferencias = Transferencia::with('items')->findOrFail($id);
$funcionarios = Funcionario::all();
$produtos = Produto::all();
return view('transferencias.edit', compact('transferencias','funcionarios','produtos'));
}


// UPDATE METHOD
public function update(Request $request, $id)
{
$data = $request->validate([
'origem' => 'required',
'destino' => 'required',
'data_transferencia' => 'required|date',
'funcionario_id' => 'required',
'observacao' => 'nullable',
]);


$transferencia = Transferencia::findOrFail($id);
$transferencia->update($data);


$transferencia->items()->delete();


if ($request->has('produtos')) {
foreach ($request->produtos as $item) {
$transferencia->items()->create([
'produto_id' => $item['produto_id'],
'quantidade' => $item['quantidade'],
]);
}
}


return redirect()->route('transferencias.index')
->with('success', 'Transferência atualizada com sucesso!');
}

}