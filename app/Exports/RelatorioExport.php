<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RelatorioExport implements FromCollection, WithHeadings
{
    private $dados;
    private $tipo;

    public function __construct($dados, $tipo)
    {
        $this->dados = $dados;
        $this->tipo = $tipo;
    }

    public function collection()
    {
        return $this->dados->map(function ($d) {
            return [
                'Data' => $this->tipo == 'entrada'
                    ? $d->entrada->data_entrada
                    : ($this->tipo == 'saida'
                        ? $d->saida->data_saida
                        : $d->transferencia->data_transferencia),

                'Funcionário' => $this->tipo == 'entrada'
                    ? $d->entrada->funcionario->nome
                    : ($this->tipo == 'saida'
                        ? $d->saida->funcionario->nome
                        : $d->transferencia->funcionario->nome),

                'Produto' => $d->produto->nome,
                'Categoria' => $d->produto->categoria->nome,
                'Quantidade' => $d->quantidade,
                'Preco' => $d->produto->preco,
                'Tipo' => ucfirst($this->tipo),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Data',
            'Funcionário',
            'Produto',
            'Categoria',
            'Quantidade',
            'Preco',
            'Tipo'
        ];
    }
}
