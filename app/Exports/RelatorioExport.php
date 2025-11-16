<?php

namespace App\Exports;

use App\Models\Produto;
use App\Models\Entrada;
use App\Models\Saida;
use App\Models\Transferencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RelatorioExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [
            new ProdutosSheet(),
            new EntradasSheet(),
            new SaidasSheet(),
            new TransferenciasSheet(),
        ];

        return $sheets;
    }
}

class ProdutosSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Produto::with('categoria', 'unidade')->get()->map(function($produto) {
            return [
                'Nome' => $produto->nome,
                'Categoria' => $produto->categoria->nome,
                'Unidade' => $produto->unidade->nome,
                'Estoque Mínimo' => $produto->estoque_minimo,
                'Estoque Atual' => $produto->estoque_atual,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nome',
            'Categoria',
            'Unidade',
            'Estoque Mínimo',
            'Estoque Atual'
        ];
    }

    public function title(): string
    {
        return 'Produtos';
    }
}

class EntradasSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Entrada::with('produto', 'funcionario')->get()->map(function($entrada) {
            return [
                'Produto' => $entrada->produto->nome,
                'Quantidade' => $entrada->quantidade,
                'Data Entrada' => $entrada->data_entrada,
                'Funcionário' => $entrada->funcionario->nome,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Produto',
            'Quantidade',
            'Data Entrada',
            'Funcionário'
        ];
    }

    public function title(): string
    {
        return 'Entradas';
    }
}

class SaidasSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Saida::with('produto', 'funcionario')->get()->map(function($saida) {
            return [
                'Produto' => $saida->produto->nome,
                'Quantidade' => $saida->quantidade,
                'Data Saída' => $saida->data_saida,
                'Funcionário' => $saida->funcionario->nome,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Produto',
            'Quantidade',
            'Data Saída',
            'Funcionário'
        ];
    }

    public function title(): string
    {
        return 'Saídas';
    }
}

class TransferenciasSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Transferencia::with('produto', 'funcionario')->get()->map(function($transferencia) {
            return [
                'Produto' => $transferencia->produto->nome,
                'Quantidade' => $transferencia->quantidade,
                'Data Transferência' => $transferencia->data_transferencia,
                'Origem' => $transferencia->origem,
                'Destino' => $transferencia->destino,
                'Funcionário' => $transferencia->funcionario->nome,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Produto',
            'Quantidade',
            'Data Transferência',
            'Origem',
            'Destino',
            'Funcionário'
        ];
    }

    public function title(): string
    {
        return 'Transferências';
    }
}