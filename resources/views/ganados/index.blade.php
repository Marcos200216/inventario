@extends('layout')

@section('content')
<style>
    .container {
        max-width: 95%;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .btn-create {
        display: inline-block;
        background-color: #087282;
        color: #fff;
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 15px;
         border: none; /* Elimina cualquier borde */
    }

    .btn-create:hover {
        background-color: #05454f;
    }

    /* Nuevo contenedor para la tabla con scroll */
    .table-container {
      
        overflow-y: auto; /* Scroll siempre activo pero solo visible cuando se necesita */
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 6px;
        
    }
     /* Ocultar la barra de scroll cuando no sea necesaria */
    .table-container {
        overflow-y: hidden; /* Por defecto oculto */
    }
    
    .table-container.scroll-active {
        overflow-y: auto; /* Solo se activa cuando hay más de 4 registros */
    }
   
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    
    /* Encabezado fijo al hacer scroll */
    table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    th {
        font-size: 12px;
    }

    thead {
        background-color: #087282;
        color: white;
    }
    
    table thead th {
        font-size: 12px;
        font-weight: bold; /* Opcional, para que el texto quede en negrita */
    }

    th, td {
        padding: 8px 5px;
        border: 1px solid #ddd;
            text-align: center !important; /* Centra el texto horizontalmente */
    vertical-align: middle !important; /* Centra el contenido verticalmente */
        font-size: 12px;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Altura fija para las filas */
    tbody tr {
        height: 40px;
    }

       /* Ajustes específicos de ancho para columnas */
th:nth-child(1), td:nth-child(1) { width: 5%; }   /* Arete */
th:nth-child(2), td:nth-child(2) { width: 4%; }   /* Color */
th:nth-child(3), td:nth-child(3) { width: 3%; }   /* Sexo */
th:nth-child(4), td:nth-child(4) { width: 7%; }   /* Subasta */
th:nth-child(5), td:nth-child(5) { width: 5%; }   /* N° Subasta */
th:nth-child(6), td:nth-child(6) { width: 6%; }   /* Peso Total */
th:nth-child(7), td:nth-child(7) { width: 6%; }   /* Precio/Kg */
th:nth-child(8), td:nth-child(8) { width: 6%; }   /* Monto */
th:nth-child(9), td:nth-child(9) { width: 6%; }   /* Lote */
th:nth-child(10), td:nth-child(10) { width: 8%; }  /* Antigüedad */
th:nth-child(11), td:nth-child(11) { width: 6%; }  /* Destino */
th:nth-child(12), td:nth-child(12) { width: 6%; }  /* Rev 1 */
th:nth-child(13), td:nth-child(13) { width: 6%; }  /* Rev 2 */
th:nth-child(14), td:nth-child(14) { width: 6%; }  /* Rev 3 */
th:nth-child(15), td:nth-child(15) { width: 7%; }  /* Estado */
th:nth-child(16), td:nth-child(16) { width: 5%; min-width: 60px; } /* Acciones */

    /* Para mostrar el texto completo al pasar el mouse */
    td:hover {
        overflow: visible;
        white-space: normal;
        text-overflow: clip;
        z-index: 1;
        position: relative;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Estilos para la columna de Acciones */
    td:nth-child(16) {
        padding: 4px !important; /* Reducir el padding */
        white-space: normal !important; /* Permitir múltiples líneas */
    }
    
    /* Estilos para la columna de Acciones */
    .action-links {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: center;
        justify-content: center;
    }

    .action-links a, 
    .action-links button {
        padding: 4px 8px;
        font-size: 12px;
        text-transform: none;
        width: 100%;
        max-width: 70px;
        min-width: 60px;
        text-align: center;
        margin: 0;
        border-radius: 4px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    
    /* Asegurar que la columna tenga suficiente ancho */
    th:nth-child(16),
    td:nth-child(16) {
        width: 120px !important; /* Ancho fijo suficiente */
        min-width: 120px;
        max-width: 120px;
        box-sizing: border-box;
    }

    /* Botón Editar */
    .action-links a {
        background-color: #087282;
        color: white;
        width: 60px; /* Añade esta línea con el mismo ancho que el botón Eliminar */
        display: inline-block; /* Asegura que el ancho se aplique correctamente */
        box-sizing: border-box; /* Incluye padding en el ancho total */
    }

    /* Hover Editar */
    .action-links a:hover {
       background-color: #05454f;
        border-color: #05454f;
    }

    /* Botón Eliminar */
    .action-links button {
        background-color: #dc3545;
        color: white;
    }

    /* Hover Eliminar */
    .action-links button:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .alert-success {
        color: rgb(16, 150, 184);
        margin-bottom: 10px;
        font-weight: bold;
    }

    @media screen and (max-width: 768px) {
        th, td {
            font-size: 12px;
            padding: 8px 6px;
        }

        h2 {
            font-size: 20px;
        }

        .btn-create {
            padding: 8px 12px;
            font-size: 14px;
        }
    }
    
    /* Modal overlay */
    .modal {
        display: none;                /* oculto por defecto */
        position: fixed;              
        z-index: 1000;                
        left: 0;                     
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;               
        overflow-y: auto;            
    }

    /* Cuando el modal está visible */
    .modal.active {
        display: flex;               /* solo se aplica cuando tiene la clase active */
        align-items: center;         
        justify-content: center;     
    }

    .modal-content {
        background-color: #fff;
        border-radius: 12px;
        padding: 30px 40px; /* <<< más padding horizontal para simetría */
        width: 100%;
        max-width: 950px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Animación de aparición */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Encabezado */
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

    /* Grid de formulario 3 columnas iguales */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        column-gap: 30px;
        row-gap: 20px;
    }

    /* Cada campo */
    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: bold;
        margin-bottom: 6px;
        color: #333;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    /* Botón guardar */
    .btn-save {
        grid-column: span 3;
        margin-top: 30px;
        padding: 14px;
        background-color: #0d94b6;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-save:hover {
        background-color: #08576b;
    }

    /* Errores */
    .error {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }

    /* Responsivo para móviles */
    @media screen and (max-width: 768px) {
        .modal-content {
            padding: 25px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .btn-save {
            grid-column: span 1;
        }
    }
    
    /* Estilos uniformes para todos los inputs */
    .form-group input:not([type="checkbox"]):not([type="radio"]),
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        height: 40px; /* Altura fija para todos */
        box-sizing: border-box;
        background-color: white;
        transition: border-color 0.3s;
    }

    /* Estilo para selects */
    .form-group select {
        appearance: none; /* Elimina el estilo nativo del select */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 30px; /* Espacio para el ícono */
    }

    /* Estilo para inputs de fecha */
    .form-group input[type="date"] {
        appearance: none; /* Elimina el estilo nativo en algunos navegadores */
        padding-right: 10px;
    }

    /* Estilo para inputs de solo lectura */
    .form-group input[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    /* Estilo para hover y focus */
    .form-group input:not([readonly]):hover,
    .form-group select:hover,
    .form-group input:not([readonly]):focus,
    .form-group select:focus {
        border-color: #087282;
        outline: none;
    }

    /* Estilo para selects inválidos */
    .form-group select:required:invalid {
        color: #666;
    }

    /* Estilo para las opciones del select */
    .form-group select option {
        color: #333;
        padding: 5px;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        margin-top: -18px; /* Misma altura que en tu ejemplo */
    }

    .search-input {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        width: 180px;
         height: 30px; /* Altura fija para igualar con el botón */
        box-sizing: border-box;
    }

    .search-button {
        background-color: #087282;
        color: white;
        border: none;
        padding: 7px 14px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-button:hover {
        background-color: #05454f;
    }

    .btn-exportar {
        background-color: #04803a;
        color: white;
        padding: 7px 14px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 14px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .btn-exportar:hover {
        background-color:#045b29;
    }
    
.custom-pagination {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 15px;
    align-items: center;
    font-size: 12px;
    flex-wrap: wrap;
}

.custom-pagination a,
.custom-pagination span {
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 4px;
    border: 1px solid #ccc;
    text-decoration: none;
    background-color: #f8f9fa;
    color: #333;
}

.custom-pagination a:hover {
    background-color: #087282;
    color: white;
    border-color: #087282;
}

.custom-pagination .disabled {
    color: #aaa;
    border-color: #ddd;
    background-color: #f0f0f0;
    cursor: not-allowed;
}

.custom-pagination .pagination-info {
    font-size: 12px;
    color: #666;
    border: none;
    background: none;
    padding: 0;
}

</style>

<div class="container">
    <h2>Ganados</h2>

    <!-- Contenedor para botón Agregar y barra de búsqueda -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 20px;">
        <button class="btn-create" onclick="document.getElementById('ganadoModal').classList.add('active')">Agregar Ganado</button>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('ganados.index') }}" class="search-form">
            <input 
                type="text" 
                name="arete" 
                value="{{ request('buscar_arete') }}" 
                placeholder="Buscar por arete..." 
                class="search-input"
            >
            <button type="submit" class="search-button">
                Buscar
            </button>
        </form>
    </div>
    
    <!-- Botón Exportar Excel alineado a la derecha con mismo estilo que Buscar -->
    <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
        <a href="{{ route('ganados.exportar') }}" class="btn-exportar">
            Exportar Excel
        </a>
    </div>
<div id="ganadoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Agregar Ganado</h2>
 <span class="close" onclick="document.getElementById('ganadoModal').classList.remove('active')">&times;</span>        </div>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                      
                    @endforeach
                </ul>
            </div>
        @endif

       <form method="POST" action="{{ route('ganados.store') }}">
    @csrf
    <div class="form-grid">
        {{-- Arete (entero) --}}
        <div class="form-group">
            <label>Arete:</label>
         <input type="text" name="arete" value="{{ old('arete') }}" required pattern="\d+">
        </div>
   {{-- Color (texto) --}}
<div class="form-group">
    <label>Color:</label>
<input type="text" name="color" value="{{ old('color') }}">
</div>
      {{-- Sexo (select) --}}
<div class="form-group">
    <label>Sexo:</label>
    <select name="sexo" required>
        <option value="">Seleccione</option>
        <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Macho</option>
        <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Hembra</option>
    </select>
</div>


        {{-- Subasta (texto) --}}
        <div class="form-group">
            <label>Subasta:</label>
            <input type="text" name="subasta" value="{{ old('subasta') }}" required>
        </div>

        {{-- N° Subasta (entero) --}}
        <div class="form-group">
            <label>N° Subasta:</label>
<input 
    type="text" 
    name="numero_subasta" 
    value="{{ old('numero_subasta') }}" 
    required 
    pattern="\d+"
    title="Solo números"
>
        </div>

        {{-- Peso Total (decimal) --}}
        <div class="form-group">
            <label>Peso Total (kg):</label>
            <input type="number" name="peso_total" id="peso_total" value="{{ old('peso_total') }}" min="0" step="0.01" required>
        </div>

        {{-- Precio por Kg (entero) --}}
        <div class="form-group">
            <label>Precio/Kg:</label>
            <input type="number" name="precio_kg" id="precio_kg" value="{{ old('precio_kg') }}" min="0" step="1" required>
        </div>

        {{-- Monto (autocalculado) --}}
        <div class="form-group">
            <label>Monto:</label>
            <input type="text" name="monto" id="monto" readonly>
        </div>

        {{-- Lote (fecha) --}}
        <div class="form-group">
            <label>Lote (Fecha):</label>
            <input type="date" name="lote" value="{{ old('lote') }}" required>
        </div>
<div class="form-group">
    <label>Antigüedad:</label>
<input type="text" id="antiguedad" class="input-readonly" readonly>
</div>

        {{-- Destino (texto) --}}
        <div class="form-group">
            <label>Destino:</label>
            <input type="text" name="destino" value="{{ old('destino') }}" required>
        </div>

        {{-- Rev1 (fecha) --}}
        <div class="form-group">
            <label>Rev1:</label>
            <input type="date" name="rev1" value="{{ old('rev1') }}">
        </div>

        {{-- Rev2 (fecha) --}}
        <div class="form-group">
            <label>Rev2:</label>
            <input type="date" name="rev2" value="{{ old('rev2') }}">
        </div>

        {{-- Rev3 (fecha) --}}
        <div class="form-group">
            <label>Rev3:</label>
            <input type="date" name="rev3" value="{{ old('rev3') }}">
        </div>

        {{-- Estado (select) --}}
{{-- Estado (select) --}}
<div class="form-group">
    <label>Estado:</label>
    <select name="estado" required>
        <option value="">Seleccione estado</option>
        <option value="Vendido" {{ old('estado') == 'Vendido' ? 'selected' : '' }}>Vendido</option>
        <option value="Muerto" {{ old('estado') == 'Muerto' ? 'selected' : '' }}>Muerto</option>
        <option value="Robado" {{ old('estado') == 'Robado' ? 'selected' : '' }}>Robado</option>
        <option value="En Finca" {{ old('estado') == 'En Finca' ? 'selected' : '' }}>En Finca</option>
    </select>
</div>


    </div>

    <button type="submit" class="btn-save">Guardar</button>
</form>

    </div>
</div>
    <!-- Contenedor de la tabla con scroll -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Arete</th>
                    <th>Color</th>
                    <th>Sexo</th>
                    <th>Subasta</th>
                    <th>N° Subasta</th>
                    <th>Peso</th>
                    <th>Precio/Kg</th>
                    <th>Monto</th>
                    <th>Lote</th>
                    <th>Antigüedad</th>
                    <th>Destino</th>
                    <th>Rev 1</th>
                    <th>Rev 2</th>
                    <th>Rev 3</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    @foreach($ganados as $ganado)
    @php
        $fechaLote = \Carbon\Carbon::parse($ganado->lote);
        $hoy = \Carbon\Carbon::now();
        $antiguedad = $fechaLote->diff($hoy);
    @endphp
    <tr>
        <td>{{ $ganado->arete }}</td>
        <td>{{ $ganado->color }}</td>
        <td>{{ $ganado->sexo === 'masculino' ? 'M' : ($ganado->sexo === 'femenino' ? 'H' : '-') }}</td>
        <td>{{ $ganado->subasta }}</td>
       <td>{{ $ganado->numero_subasta }}</td>
        <td>{{ number_format($ganado->peso_total, 2, ',', '.') }} kg</td>
        <td>₡{{ number_format($ganado->precio_kg, 0, ',', '.') }}</td>
        <td>₡{{ number_format($ganado->monto, 0, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($ganado->lote)->format('d-m-Y') }}</td>
        <td>{{ $antiguedad->y }} años - {{ $antiguedad->m }} meses - {{ $antiguedad->d }} días</td>
        <td>{{ $ganado->destino }}</td>
        <td>{{ $ganado->rev1 ? \Carbon\Carbon::parse($ganado->rev1)->format('d-m-Y') : '' }}</td>
        <td>{{ $ganado->rev2 ? \Carbon\Carbon::parse($ganado->rev2)->format('d-m-Y') : '' }}</td>
        <td>{{ $ganado->rev3 ? \Carbon\Carbon::parse($ganado->rev3)->format('d-m-Y') : '' }}</td>
        <td style="
    color:
        {{ $ganado->estado == 'Vendido' ? 'green' :
           ($ganado->estado == 'Muerto' ? 'red' :
           ($ganado->estado == 'Robado' ? 'orange' :
           ($ganado->estado == 'En Finca' ? '#6f42c1' : 'black'))) }};
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

        @case('En Finca')
            🏡 En Finca
            @break

        @default
            {{ $ganado->estado }}
    @endswitch
</td>



        <td class="action-links">
            <a href="{{ route('ganados.edit', $ganado->id) }}">Editar</a>
            <form class="form-eliminar" data-id="{{ $ganado->id }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>
    {{-- Mostrar la paginación solo si hay más de 1 página --}}
@if ($ganados->lastPage() > 1)
    <div class="custom-pagination">
        {{-- Botón Anterior --}}
        @if ($ganados->onFirstPage())
            <span class="disabled">Anterior</span>
        @else
            <a href="{{ $ganados->previousPageUrl() }}">Anterior</a>
        @endif

        {{-- Texto de rango --}}
        <span class="pagination-info">
            Mostrando {{ $ganados->firstItem() }} a {{ $ganados->lastItem() }} de {{ $ganados->total() }} resultados
        </span>

        {{-- Botón Siguiente --}}
        @if ($ganados->hasMorePages())
            <a href="{{ $ganados->nextPageUrl() }}">Siguiente</a>
        @else
            <span class="disabled">Siguiente</span>
        @endif
    </div>
@endif


</div>

<!-- Resto de tu código (modal, scripts, etc.) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pesoInput = document.getElementById('peso_total');
        const precioInput = document.getElementById('precio_kg');
        const montoInput = document.getElementById('monto');

        function calcularMonto() {
            const peso = parseFloat(pesoInput.value);
            const precio = parseInt(precioInput.value);

            if (!isNaN(peso) && !isNaN(precio)) {
                const monto = peso * precio;
                montoInput.value = monto.toLocaleString('es-CR', {
                    style: 'currency',
                    currency: 'CRC',
                    minimumFractionDigits: 0
                });
            } else {
                montoInput.value = '';
            }
        }

        pesoInput.addEventListener('input', calcularMonto);
        precioInput.addEventListener('input', calcularMonto);
    });


    document.addEventListener('DOMContentLoaded', () => {
    // Calcular monto automáticamente
    const pesoInput = document.getElementById('peso_total');
    const precioInput = document.getElementById('precio_kg');
    const montoInput = document.getElementById('monto');

    function calcularMonto() {
        const peso = parseFloat(pesoInput?.value);
        const precio = parseFloat(precioInput?.value);
        if (!isNaN(peso) && !isNaN(precio)) {
            const monto = peso * precio;
            montoInput.value = monto.toLocaleString('es-CR', {
                style: 'currency',
                currency: 'CRC',
                minimumFractionDigits: 0
            });
        } else {
            montoInput.value = '';
        }
    }

    pesoInput?.addEventListener('input', calcularMonto);
    precioInput?.addEventListener('input', calcularMonto);

    // Confirmar eliminación con SweetAlert
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#087282',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear un formulario real y enviarlo
                    const formReal = document.createElement('form');
                    formReal.method = 'POST';
                    formReal.action = `/ganados/${id}`;
                    
                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    formReal.appendChild(token);
                    formReal.appendChild(method);
                    document.body.appendChild(formReal);
                    formReal.submit();
                }
            });
        });
    });
});
</script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if ($errors->any())
    <script>
        // Mostrar el modal automáticamente
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('ganadoModal')?.classList.add('active');

            let mensaje = '';
            @foreach ($errors->all() as $error)
                mensaje += `{{ $error }}\n`;
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Arete duplicado',
                text: 'Ya existe un ganado con ese número de arete. Por favor, ingrese un número diferente.',
                 confirmButtonText: 'Entendido',
                 confirmButtonColor: '#087282'
            });
        });
    </script>
@endif

@if (old('peso_total') && old('precio_kg'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const peso = parseFloat({{ old('peso_total') }});
            const precio = parseFloat({{ old('precio_kg') }});
            if (!isNaN(peso) && !isNaN(precio)) {
                const monto = peso * precio;
                document.getElementById('monto').value = monto.toLocaleString('es-CR', {
                    style: 'currency',
                    currency: 'CRC',
                    minimumFractionDigits: 0
                });
            }
        });
    </script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loteInput = document.querySelector('input[name="lote"]');
    const antiguedadInput = document.getElementById('antiguedad');

    function calcularAntiguedad(fechaLote) {
        const hoy = new Date();
        const lote = new Date(fechaLote);

        if (isNaN(lote)) {
            return '';
        }

        let years = hoy.getFullYear() - lote.getFullYear();
        let months = hoy.getMonth() - lote.getMonth();
        let days = hoy.getDate() - lote.getDate();

        if (days < 0) {
            months--;
            days += new Date(hoy.getFullYear(), hoy.getMonth(), 0).getDate();
        }
        if (months < 0) {
            years--;
            months += 12;
        }

        return `${years} años - ${months} meses - ${days} días`;
    }

    loteInput.addEventListener('change', function() {
        antiguedadInput.value = calcularAntiguedad(this.value);
    });

    // Si ya tiene un valor cuando se carga la página, mostrar antigüedad:
    if (loteInput.value) {
        antiguedadInput.value = calcularAntiguedad(loteInput.value);
    }
});



document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.querySelector('.table-container');
    const rowCount = document.querySelectorAll('tbody tr').length;
    
    // Activar scroll solo si hay más de 4 registros
    if (rowCount > 4) {
        tableContainer.classList.add('scroll-active');
    }
});
</script>

@endsection
