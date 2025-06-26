<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Support\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        $ganados = Ganado::all();

        $dataPorFinca = [];

        foreach ($ganados->groupBy('destino') as $finca => $ganadosFinca) {
            // Animales registrados por mes
            $registroPorMes = [];
            $meses = [];

            foreach ($ganadosFinca as $ganado) {
                $mes = Carbon::parse($ganado->created_at)->translatedFormat('F Y');
                $registroPorMes[$mes] = ($registroPorMes[$mes] ?? 0) + 1;
            }

            $mesesOrdenados = collect($registroPorMes)->sortKeys();
            $meses = $mesesOrdenados->keys()->toArray();
            $valores = $mesesOrdenados->values()->toArray();

            // Conteo por estado
            $estadoCount = $ganadosFinca->groupBy('estado')->map->count()->toArray();

            // Conteo por sexo
            $sexoCount = $ganadosFinca->groupBy('sexo')->map->count()->toArray();

            // Peso total y promedio
            $pesoTotal = $ganadosFinca->sum('peso_total');
            $pesoPromedio = $ganadosFinca->count() > 0 ? $pesoTotal / $ganadosFinca->count() : 0;

            // Monto total
            $montoTotal = $ganadosFinca->sum('monto');

            $dataPorFinca[$finca] = [
                'meses' => $meses,
                'registroPorMes' => $valores,
                'estadoCount' => $estadoCount,
                'sexoCount' => $sexoCount,
                'pesoTotal' => $pesoTotal,
                'pesoPromedio' => $pesoPromedio,
                'montoTotal' => $montoTotal,
            ];
        }

        return view('reportes.index', compact('dataPorFinca'));
    }
}
