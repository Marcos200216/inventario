<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GanadoExportController;
use App\Http\Controllers\ReporteController;
// Redirigir la raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rutas de exportación (públicas o protegidas según necesites)
Route::get('/ganados/exportar', [GanadoExportController::class, 'export'])->name('ganados.exportar');
Route::get('/ganados/exportar-finca/{destino}', [GanadoExportController::class, 'exportarFinca'])->name('ganados.exportar.finca');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Dashboard con variable $user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('ganados', GanadoController::class);
       Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});