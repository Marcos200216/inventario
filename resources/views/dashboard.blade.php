@extends('layout')

@section('content')
<style>
    .dashboard-container {
        max-width: 95%;
        margin: 40px auto;
        padding: 20px;
    }

    .welcome {
        font-size: 32px;
        font-weight: bold;
        color: #087282;
        margin-bottom: 10px;
    }

    .intro-text {
        font-size: 17px;
        color: #555;
        margin-bottom: 40px;
    }

    .finca-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }

    .finca-card {
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        border: 2px solid #08728222;
        border-radius: 16px;
        padding: 25px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        transition: all 0.25s ease-in-out;
        cursor: pointer;
        position: relative;
    }

    .finca-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(8, 114, 130, 0.15);
    }

    .finca-card::before {
        font-size: 36px;
        position: absolute;
        top: 15px;
        right: 20px;
        opacity: 0.2;
    }

    .finca-title {
        font-size: 20px;
        font-weight: 600;
        color: #087282;
        margin-bottom: 8px;
    }

    .finca-sub {
        font-size: 14px;
        color: #777;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow-y: auto;
        padding: 40px 10px;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 12px;
        padding: 30px 40px;
        max-width: 950px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s ease-in-out;
        max-height: 90vh; /* Limita el alto del contenido del modal */
        overflow-y: auto;  /* Activa scroll interno si es necesario */
    }
     .modal-content::-webkit-scrollbar {
    width: 8px;
}
.modal-content::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
}


    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 22px;
        color: #333;
    }

    .close {
        font-size: 26px;
        font-weight: bold;
        color: #888;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    .summary-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .summary-card {
        flex: 1;
        min-width: 180px;
        background: #f1fdfd;
        padding: 15px 20px;
        border-left: 5px solid #087282;
        border-radius: 8px;
    }

    .summary-card strong {
        color: #087282;
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }



    thead {
        background-color: #087282;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    @media screen and (max-width: 600px) {
        .welcome {
            font-size: 24px;
        }

        .finca-title {
            font-size: 18px;
        }

        .finca-sub {
            font-size: 13px;
        }

        .modal-content {
            padding: 20px;
        }

        table, th, td {
            font-size: 12px;
        }
    }
  .btn-exportar {
    background-color: #087282;
    color: white;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    transition: background-color 0.2s ease-in-out;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-exportar:hover {
    background-color: #065e6a;
    color: #fff;
}

.table-scroll-container {
    max-height: calc(4 * 40px);
    overflow-y: auto;
    overflow-x: auto;
    position: relative;
    margin-top: 20px;
    border: 1px solid #ccc;
    width: 100%; /* Asegura que use todo el ancho disponible */
}

table {
    width: 100%; /* Ocupa todo el ancho del contenedor */
    border-collapse: collapse;
    font-size: 12px;
    table-layout: auto; /* Permite que las columnas se ajusten al contenido */
}

thead {
    position: sticky;
    top: 0;
    z-index: 10;
}

th, td {
    border: 1px solid #ddd;
    white-space: normal; /* Permite que el texto se ajuste */
    word-wrap: break-word; /* Rompe palabras largas si es necesario */
     padding: 5px 8px; /* menos espacio interior */
    font-size: 11px;  /* texto más pequeño */
        text-align: center !important; /* Centra el texto horizontalmente */
    vertical-align: middle !important; /* Centra el contenido verticalmente */
}

thead {
    background-color: #087282;
    color: white;
      position: sticky;
    top: 0;
    z-index: 10;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}
th:nth-child(1), td:nth-child(1) { width: 30px; }  /* Arete */
th:nth-child(3), td:nth-child(3) { width: 80px; }  /* Subasta */
th:nth-child(5), td:nth-child(5) { width: 90px; }  /* Peso */
th:nth-child(6), td:nth-child(6) { width: 90px; }  /* Precio/Kg */
th:nth-child(7), td:nth-child(7) { width: 100px; } /* Monto */
th:nth-child(8), td:nth-child(8) { width: 90px; }  /* Lote */
th:nth-child(9), td:nth-child(9) { width: 150px; } /* Antigüedad */
th:nth-child(10), td:nth-child(10) { width: 80px; } /* Rev 1 */
th:nth-child(11), td:nth-child(11) { width: 80px; } /* Rev 2 */
th:nth-child(12), td:nth-child(12) { width: 80px; } /* Rev 3 */
th:nth-child(13), td:nth-child(13) { width: 90px; } /* Estado */


</style>

<div class="dashboard-container">
    <p class="welcome">¡Bienvenido, {{ $user->name }}!</p>
    <p class="intro-text">
        Selecciona una finca para ver el inventario asociado. Estas son las fincas registradas:
    </p>

    <div class="finca-grid">
        @forelse ($fincas as $finca)
            <div class="finca-card" onclick="document.getElementById('modalFinca{{ $loop->index }}').classList.add('active')">
                <div class="finca-title">{{ $finca->destino }}</div>
                <div class="finca-sub">Registro activo en el sistema</div>
            </div>

            <!-- Modal de esta finca -->
            <div id="modalFinca{{ $loop->index }}" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Ganados en Finca: {{ $finca->destino }}</h2>
                        <span class="close" onclick="document.getElementById('modalFinca{{ $loop->index }}').classList.remove('active')">&times;</span>
                    </div>

                    @php
    $ganadosFinca = $ganados->where('destino', $finca->destino);
    $totalAnimales = $ganadosFinca->count();
    $totalPeso = $ganadosFinca->sum('peso_total');
    $montoTotal = $ganadosFinca->sum('monto');

    $pesoPromedio = $totalAnimales > 0 ? $totalPeso / $totalAnimales : 0;
    $precioPromedio = $totalPeso > 0 ? $montoTotal / $totalPeso : 0;
    $valorPorAnimal = $totalAnimales > 0 ? $montoTotal / $totalAnimales : 0;
@endphp


                    @if($totalAnimales > 0)
                     <!-- Botón Exportar Excel -->
         
      <div class="summary-cards">
    <div class="summary-card">
        <strong>Total de animales:</strong>
        {{ $totalAnimales }}
    </div>
    <div class="summary-card">
        <strong>Peso promedio:</strong>
        {{ number_format($pesoPromedio, 2) }} kg
    </div>
    <div class="summary-card">
        <strong>Valor por animal:</strong>
        ₡{{ number_format($valorPorAnimal, 0) }}
    </div>
    <div class="summary-card">
        <strong>Precio promedio:</strong>
        ₡{{ number_format($precioPromedio, 2) }}
    </div>
</div>

      <!-- Botón Exportar Excel, ahora debajo de las summary-cards -->
    <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
<a href="{{ route('ganados.exportar.finca', ['destino' => urlencode($finca->destino)]) }}" class="btn-exportar">
    Exportar Excel
</a>

    </div>
                        <div class="table-scroll-container">
    <table>
        <thead>
            <tr>
                <th>Arete</th>
                <th>Sexo</th>
                <th>Subasta</th>
                <th>N° Subasta</th>
                <th>Peso</th>
                <th>Precio/Kg</th>
                <th>Monto</th>
                <th>Lote</th>
                <th>Antigüedad</th>
                <th>Rev 1</th>
                <th>Rev 2</th>
                <th>Rev 3</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($ganadosFinca as $ganado)
        @php
            $fechaLote = \Carbon\Carbon::parse($ganado->lote);
            $hoy = \Carbon\Carbon::now();
            $antiguedad = $fechaLote->diff($hoy);
        @endphp
        <tr>
            <td>{{ $ganado->arete }}</td>
            <td>{{ $ganado->sexo === 'masculino' ? 'M' : ($ganado->sexo === 'femenino' ? 'H' : '-') }}</td>
            <td>{{ $ganado->subasta }}</td>
            <td>{{ $ganado->numero_subasta }}</td>
            <td>{{ number_format($ganado->peso_total, 2) }} kg</td>
            <td>₡{{ number_format($ganado->precio_kg, 0) }}</td>
            <td>₡{{ number_format($ganado->monto, 0) }}</td>
            <td>{{ \Carbon\Carbon::parse($ganado->lote)->format('d-m-Y') }}</td>
            <td>{{ $antiguedad->y }} años - {{ $antiguedad->m }} meses - {{ $antiguedad->d }} días</td>
            <td>{{ $ganado->rev1 ? \Carbon\Carbon::parse($ganado->rev1)->format('d-m-Y') : '' }}</td>
            <td>{{ $ganado->rev2 ? \Carbon\Carbon::parse($ganado->rev2)->format('d-m-Y') : '' }}</td>
            <td>{{ $ganado->rev3 ? \Carbon\Carbon::parse($ganado->rev3)->format('d-m-Y') : '' }}</td>
           <td style="
    color:
        {{ $ganado->estado == 'Vendido' ? 'green' :
           ($ganado->estado == 'Muerto' ? 'red' :
           ($ganado->estado == 'Robado' ? 'orange' : 'black')) }};
">
    @switch($ganado->estado)
        @case('Vendido')
            ✅ Vendido
            @break

        @case('Muerto')
            ❌ Muerto
            @break

        @case('Robado')
            ⚠️ Robado
            @break

        @default
            {{ $ganado->estado }}
    @endswitch
</td>
        </tr>
    @endforeach
</tbody>
    </table>
</div>


                        
                    @else
                        <p style="text-align: center;">No hay ganado registrado para esta finca.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="finca-card">
                <div class="finca-title">No hay fincas registradas</div>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal.active').forEach(modal => modal.classList.remove('active'));
        }
    });
</script>
@endsection
