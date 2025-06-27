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
        $destino = urldecode($destino); // Esto es clave si el nombre tiene espacios
        return Excel::download(new GanadosExport($destino), 'ganados-finca-'.$destino.'.xlsx');
    }
}