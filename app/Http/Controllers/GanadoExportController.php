<?php

namespace App\Http\Controllers;

use App\Exports\GanadosExport;
use Maatwebsite\Excel\Facades\Excel;

class GanadoExportController extends Controller
{
    public function export()
    {
        return Excel::download(new GanadosExport, 'ganados.xlsx');
    }

    public function exportarFinca($destino)
    {
        return Excel::download(new GanadosExport($destino), 'ganados-finca-'.$destino.'.xlsx');
    }
}