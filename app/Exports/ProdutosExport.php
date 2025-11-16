<?php

namespace App\Exports;

use App\Models\Produto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProdutosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data_inicial;
    protected $data_final;
    protected $nome;
    protected $categoria;

    public function __construct($data_inicial = null, $data_final = null, $nome = null, $categoria = null)
    {
        $this->data_inicial = $data_inicial;
        $this->data_final = $data_final;
        $this->nome = $nome;
        $this->categoria = $categoria;
    }

    public function collection()
    {
        $query = Produto::query();

        if ($this->data_inicial && $this->data_final) {
            $query->whereBetween('data', [$this->data_inicial, $this->data_final]);
        }

        if ($this->nome) {
            $query->where('nome', 'like', '%' . $this->nome . '%');
        }

        if ($this->categoria) {
            $query->where('categoria', 'like', '%' . $this->categoria . '%');
        }

        return $query->orderBy('data', 'desc')
                     ->get(['id', 'nome', 'categoria', 'quantidade', 'preco', 'data']);
    }

    public function headings(): array
    {
        return ['ID', 'Nome', 'Categoria', 'Quantidade', 'Preço', 'Data'];
    }
}
