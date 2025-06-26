<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

       
        $fincas = Ganado::select('destino')
            ->distinct()
            ->orderBy('destino')
            ->get();

        $ganados = Ganado::all();

        return view('dashboard', compact('user', 'fincas', 'ganados'));
    }
}
