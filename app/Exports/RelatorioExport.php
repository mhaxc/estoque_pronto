<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RelatorioExport implements WithMultipleSheets
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new class($this->request) implements FromView {
            private $r;
            public function __construct($r){ $this->r = $r; }
            public function view(): View {
                $func = $this->r->funcionario_id;
                $inicio = $this->r->inicio;
                $fim = $this->r->fim;

                $entradas = \App\Models\Entrada::when($func, fn($q) => $q->where('funcionario_id', $func))
                    ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                    ->with('produto', 'funcionario')->get();

                return view('relatorios.excel_entradas', ['entradas' => $entradas]);
            }
        };

        $sheets[] = new class($this->request) implements FromView {
            private $r;
            public function __construct($r){ $this->r = $r; }
            public function view(): View {
                $func = $this->r->funcionario_id;
                $inicio = $this->r->inicio;
                $fim = $this->r->fim;

                $saidas = \App\Models\Saida::when($func, fn($q) => $q->where('funcionario_id', $func))
                    ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                    ->with('produto', 'funcionario')->get();

                return view('relatorios.excel_saidas', ['saidas' => $saidas]);
            }
        };

        $sheets[] = new class($this->request) implements FromView {
            private $r;
            public function __construct($r){ $this->r = $r; }
            public function view(): View {
                $func = $this->r->funcionario_id;
                $inicio = $this->r->inicio;
                $fim = $this->r->fim;

                $transferencias = \App\Models\Transferencia::when($func, fn($q) => $q->where('funcionario_id', $func))
                    ->when($inicio && $fim, fn($q) => $q->whereBetween('created_at', [$inicio, $fim]))
                    ->with('produto', 'funcionario')->get();

                return view('relatorios.excel_transferencias', ['transferencias' => $transferencias]);
            }
        };

        return $sheets;
    }
}
