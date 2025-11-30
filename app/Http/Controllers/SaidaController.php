<?php



namespace App\Http\Controllers;

use App\Models\Saida;
use App\Models\SaidaItem;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaidaController extends Controller
{
    /**
     * Listagem
     */
    public function index()
    {
        $saidas = Saida::with('funcionario')->orderBy('id', 'desc')->paginate(10);
        return view('saidas.index', compact('saidas'));
    }

    /**
     * Form de criação
     */
    public function create()
    {
        $funcionarios = Funcionario::all();
        $produtos = Produto::all();
        return view('saidas.create', compact('funcionarios', 'produtos'));
    }

    /**
     * Salvar nova saída + baixar estoque
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // cria saída
            $saida = Saida::create([
                'data_saida'     => $request->data_saida,
                'funcionario_id' => $request->funcionario_id,
                'observacao'     => $request->observacao
            ]);

            // itens
            foreach ($request->produtos as $item) {

                $produto = Produto::find($item['produto_id']);

                // proteção caso estoque seja insuficiente
                if ($produto->estoque_atual < $item['quantidade']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Estoque insuficiente para o produto: ' . $produto->nome);
                }

                // salva item da saída
                SaidaItem::create([
                    'saida_id'   => $saida->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade']
                ]);

                // baixa o estoque
                $produto->estoque_atual -= $item['quantidade'];
                $produto->save();
            }

            DB::commit();
            return redirect()->route('saidas.index')->with('success', 'Saída registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao salvar: ' . $e->getMessage());
        }
    }
        public function show($id)
        {
        $saida = Saida::with(['funcionario', 'items.produto'])->findOrFail($id);

        return view('saidas.show', compact('saida'));
        }
    public function edit($id)
    {
        $saida = Saida::with('items')->findOrFail($id);
        $funcionarios = Funcionario::all();
        $produtos = Produto::all();

        return view('saidas.edit', compact('saida', 'funcionarios', 'produtos'));
    }

    /**
     * Atualizar saída (repor estoque anterior e registrar novo)
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $saida = Saida::findOrFail($id);

            // 1) repõe estoque dos itens antigos
            foreach ($saida->itens as $itemAntigo) {
                $produto = Produto::find($itemAntigo->produto_id);
                $produto->estoque_atual += $itemAntigo->quantidade;
                $produto->save();
            }

            // 2) deleta itens antigos
            $saida->itens()->delete();

            // 3) atualiza dados da saída
            $saida->update([
                'data_saida'     => $request->data_saida,
                'funcionario_id' => $request->funcionario_id,
                'observacao'     => $request->observacao
            ]);

            // 4) insere novos itens
            foreach ($request->produtos as $item) {

                $produto = Produto::find($item['produto_id']);

                if ($produto->estoque_atual < $item['quantidade']) {
                    DB::rollBack();
                    return back()->with('error', 'Estoque insuficiente para: ' . $produto->nome);
                }

                SaidaItem::create([
                    'saida_id' => $saida->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade']
                ]);

                // baixa estoque
                $produto->estoque_atual -= $item['quantidade'];
                $produto->save();
            }

            DB::commit();
            return redirect()->route('saidas.index')->with('success', 'Saída atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    /**
     * Excluir saída (repor estoque automaticamente)
     */
   public function destroy($id)
{
    
    $saida = Saida::findOrFail($id);
    $saida->delete();

    return redirect()
        ->route('saidas.index')
        ->with('success', 'Saída excluída com sucesso!');

}

}