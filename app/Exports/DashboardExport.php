<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DashboardExport implements FromView, ShouldAutoSize
{
    protected $dadosExport;

    public function __construct($dadosExport)
    {
        $this->dadosExport = $dadosExport;
    }

    public function view(): View
    {
        return view('dashboard', [
            'dadosExport' => $this->dadosExport
        ]);
    }


}
