<?php

namespace App\Exports;

use App\Models\Entrada;
use App\Models\Saida;
use App\Models\Transferencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RelatorioExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        return view('relatorios.excel', [
            'entradas' => Entrada::all(),
            'saidas' => Saida::all(),
            'transferencias' => Transferencia::all(),
        ]);
    }
}
