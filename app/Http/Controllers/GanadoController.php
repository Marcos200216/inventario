<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GanadosExport;

class GanadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Ganado::query();

        if ($request->filled('arete')) {
            $query->where('arete', $request->arete);
        }

        $ganados = $query->orderBy('id', 'asc')->paginate(4);

        return view('ganados.index', compact('ganados'));
    }

    public function create()
    {
        return view('ganados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'arete' => 'required|string|regex:/^\d+$/|unique:ganados,arete',
            'color' => 'required|string|max:50',
            'sexo' => 'required|in:masculino,femenino',
            'subasta' => 'required|string|max:100',
            'numero_subasta' => 'required|string|regex:/^\d+$/',
            'peso_total' => 'required|numeric|min:0',
            'precio_kg' => 'required|integer|min:0',
            'monto' => 'nullable|string',
            'lote' => 'required|date',
            'destino' => 'required|string|max:100',
            'peso1' => 'nullable|numeric|min:0',
            'peso2' => 'nullable|numeric|min:0',
            'peso3' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Vendido,Muerto,Robado,En Finca',
        ]);

        $validated['monto'] = $validated['peso_total'] * $validated['precio_kg'];

        Ganado::create($validated);

        return redirect()->route('ganados.index')->with('success', 'Ganado agregado exitosamente.');
    }

    public function show(Ganado $ganado)
    {
        return view('ganados.show', compact('ganado'));
    }

    public function edit(Ganado $ganado)
    {
        return view('ganados.edit', compact('ganado'));
    }

    public function update(Request $request, Ganado $ganado)
    {
        $validated = $request->validate([
            'arete' => 'required|string|regex:/^\d+$/|unique:ganados,arete,' . $ganado->id,
            'color' => 'required|string|max:50',
            'sexo' => 'required|in:masculino,femenino',
            'subasta' => 'required|string|max:100',
            'numero_subasta' => 'required|string|regex:/^\d+$/',
            'peso_total' => 'required|numeric|min:0',
            'precio_kg' => 'required|numeric|min:0',
            'lote' => 'required|date',
            'destino' => 'required|string|max:100',
            'peso1' => 'nullable|numeric|min:0',
            'peso2' => 'nullable|numeric|min:0',
            'peso3' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Vendido,Muerto,Robado,En Finca',
        ]);

        $validated['monto'] = $validated['peso_total'] * $validated['precio_kg'];

        $ganado->update($validated);

        return redirect()->route('ganados.index')->with('success', 'Ganado actualizado correctamente.');
    }

    public function destroy(Ganado $ganado)
    {
        $ganado->delete();
        return redirect()->route('ganados.index')->with('success', 'Registro eliminado con éxito');
    }

    public function exportar()
    {
        return Excel::download(new GanadosExport, 'ganados.xlsx');
    }
}
