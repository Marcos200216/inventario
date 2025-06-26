@extends('layout')

@section('content')
<style>
   .container {
    width: 95%;
    max-width: 1200px;
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

    /* Estilos uniformes para todos los inputs */
    .form-group input:not([type="checkbox"]):not([type="radio"]),
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        height: 40px;
        box-sizing: border-box;
        background-color: white;
        transition: border-color 0.3s;
    }

    /* Estilo para selects */
    .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 30px;
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

    /* Botones */
    /* Base común para todos los botones */
.btn-form {
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
    color: white;
}

.btn-save {
    background-color: #0d94b6;
}
.btn-save:hover {
    background-color: #08576b;
}

.btn-cancel {
    background-color: #dc3545;
}
.btn-cancel:hover {
    background-color: #b02a37;
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
        .container {
            margin: 20px 10px;
            padding: 15px;
        }

        h2 {
            font-size: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .btn-save,
        .btn-cancel {
            grid-column: span 1;
            width: 100%;
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<div class="container">
  <h2>Editar Ganado (Arete: {{ $ganado->arete }})</h2>


    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ganados.update', $ganado->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-grid">
            <div class="form-group">
                <label>Arete:</label>
                <input type="number" name="arete" value="{{ old('arete', $ganado->arete) }}" min="1" step="1" required>
            </div>

            <div class="form-group">
                <label>Sexo:</label>
                <select name="sexo" required>
                    <option value="">Seleccione</option>
                    <option value="masculino" {{ old('sexo', $ganado->sexo) == 'masculino' ? 'selected' : '' }}>Macho</option>
                    <option value="femenino" {{ old('sexo', $ganado->sexo) == 'femenino' ? 'selected' : '' }}>Hembra</option>
                </select>
            </div>

            <div class="form-group">
                <label>Subasta:</label>
                <input type="text" name="subasta" value="{{ old('subasta', $ganado->subasta) }}" required>
            </div>

            <div class="form-group">
                <label>N° Subasta:</label>
                <input type="number" name="numero_subasta" value="{{ old('numero_subasta', $ganado->numero_subasta) }}" min="1" step="1" required>
            </div>

            <div class="form-group">
                <label>Peso Total (kg):</label>
                <input type="number" name="peso_total" id="peso_total" value="{{ old('peso_total', $ganado->peso_total) }}" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Precio/Kg:</label>
                <input type="number" name="precio_kg" id="precio_kg" value="{{ old('precio_kg', $ganado->precio_kg) }}" min="0" step="1" required>
            </div>

            <div class="form-group">
                <label>Monto:</label>
                <input type="text" name="monto" id="monto" value="{{ old('monto', $ganado->monto) }}" readonly class="input-readonly">
            </div>

            <div class="form-group">
                <label>Lote (Fecha):</label>
                <input type="date" name="lote" value="{{ old('lote', $ganado->lote) }}" required>
            </div>

            <div class="form-group">
                <label>Antigüedad:</label>
                <input type="text" id="antiguedad" value="{{ $ganado->lote ? \Carbon\Carbon::parse($ganado->lote)->diffForHumans() : '' }}" readonly class="input-readonly">
            </div>

            <div class="form-group">
                <label>Destino:</label>
                <input type="text" name="destino" value="{{ old('destino', $ganado->destino) }}" required>
            </div>

            <div class="form-group">
                <label>Rev1:</label>
                <input type="date" name="rev1" value="{{ old('rev1', $ganado->rev1) }}">
            </div>

            <div class="form-group">
                <label>Rev2:</label>
                <input type="date" name="rev2" value="{{ old('rev2', $ganado->rev2) }}">
            </div>

            <div class="form-group">
                <label>Rev3:</label>
                <input type="date" name="rev3" value="{{ old('rev3', $ganado->rev3) }}">
            </div>

            <div class="form-group">
                <label>Estado:</label>
                <select name="estado" required>
                    <option value="">Seleccione estado</option>
                    <option value="Vendido" {{ old('estado', $ganado->estado) == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                    <option value="Muerto" {{ old('estado', $ganado->estado) == 'Muerto' ? 'selected' : '' }}>Muerto</option>
                    <option value="Robado" {{ old('estado', $ganado->estado) == 'Robado' ? 'selected' : '' }}>Robado</option>

                </select>
            </div>
        </div>

        <div style="grid-column: span 3; display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
    <button type="submit" class="btn-form btn-save">Actualizar</button>
    <button type="button" class="btn-form btn-cancel" onclick="window.history.back();">Cancelar</button>
</div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pesoInput = document.getElementById('peso_total');
        const precioInput = document.getElementById('precio_kg');
        const montoInput = document.getElementById('monto');
        const loteInput = document.querySelector('input[name="lote"]');
        const antiguedadInput = document.getElementById('antiguedad');

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

        function calcularAntiguedad() {
            if (loteInput.value) {
                const fechaLote = new Date(loteInput.value);
                const hoy = new Date();
                const diff = new Date(hoy - fechaLote);
                
                const years = hoy.getFullYear() - fechaLote.getFullYear();
                const months = hoy.getMonth() - fechaLote.getMonth();
                const days = hoy.getDate() - fechaLote.getDate();
                
                antiguedadInput.value = `${years} años - ${months} meses - ${days} días`;
            } else {
                antiguedadInput.value = '';
            }
        }

        pesoInput.addEventListener('input', calcularMonto);
        precioInput.addEventListener('input', calcularMonto);
        loteInput.addEventListener('change', calcularAntiguedad);

        // Calcular valores iniciales
        calcularMonto();
        calcularAntiguedad();
    });
</script>

@endsection