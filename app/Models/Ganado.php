<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ganado extends Model
{
    protected $fillable = [
        'arete', 'color', 'sexo', 'subasta', 'numero_subasta', 'peso_total',
        'precio_kg', 'monto', 'lote', 'destino', 'rev1', 'rev2', 'rev3', 'estado'
    ];
}
