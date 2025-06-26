@extends('layout')

@section('content')
<h1 style="font-size: 18px;">Reportes por Finca</h1>

@php
    use Illuminate\Support\Str;
@endphp

@foreach ($dataPorFinca as $finca => $data)
<div style="margin-bottom: 30px; background:#fff; padding:15px; border-radius:8px; box-shadow: 0 0 8px #ccc;">
    <h2 style="font-size: 16px; color: #087282;">Finca: {{ $finca }}</h2>

    <div style="display:flex; flex-wrap: wrap; gap: 10px;">

        <div style="flex: 1; min-width: 250px;">
            <canvas id="registroPorMes_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <canvas id="estadoCount_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <canvas id="sexoCount_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 250px; padding: 15px; background: #e7f5f7; border-radius: 6px;">
            <h3 style="font-size: 14px;">Resumen</h3>
            <p><strong style="font-size: 12px;">Peso total:</strong> {{ number_format($data['pesoTotal'], 2) }} kg</p>
            <p><strong style="font-size: 12px;">Peso promedio:</strong> {{ number_format($data['pesoPromedio'], 2) }} kg</p>
            <p><strong style="font-size: 12px;">Monto total:</strong> ₡{{ number_format($data['montoTotal'], 0) }}</p>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @foreach ($dataPorFinca as $finca => $data)
        const ctxRegistro_{{ Str::slug($finca) }} = document.getElementById('registroPorMes_{{ Str::slug($finca) }}').getContext('2d');
        new Chart(ctxRegistro_{{ Str::slug($finca) }}, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data['meses']) !!},
                datasets: [{
                    label: 'Animales registrados por mes',
                    data: {!! json_encode($data['registroPorMes']) !!},
                    backgroundColor: 'rgba(8, 114, 130, 0.7)',
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, precision: 0 }
                }
            }
        });

        const ctxEstado_{{ Str::slug($finca) }} = document.getElementById('estadoCount_{{ Str::slug($finca) }}').getContext('2d');

        // Obtener las etiquetas y datos de estado
        const estadoLabels_{{ Str::slug($finca) }} = Object.keys(@json($data['estadoCount']));
        const estadoData_{{ Str::slug($finca) }} = Object.values(@json($data['estadoCount']));

        // Mapear colores según estado
        const estadoColors_{{ Str::slug($finca) }} = estadoLabels_{{ Str::slug($finca) }}.map(estado => {
            if (estado === 'Vendido') return '#28a745'; // verde
            if (estado === 'Muerto') return '#dc3545';  // rojo
            if (estado === 'Robado') return '#f0ad4e';  // anaranjado
            return '#6c757d'; // gris para otros (opcional)
        });

        new Chart(ctxEstado_{{ Str::slug($finca) }}, {
            type: 'doughnut',
            data: {
                labels: estadoLabels_{{ Str::slug($finca) }},
                datasets: [{
                    label: 'Estado',
                    data: estadoData_{{ Str::slug($finca) }},
                    backgroundColor: estadoColors_{{ Str::slug($finca) }},
                }]
            },
        });

        const ctxSexo_{{ Str::slug($finca) }} = document.getElementById('sexoCount_{{ Str::slug($finca) }}').getContext('2d');
        new Chart(ctxSexo_{{ Str::slug($finca) }}, {
            type: 'pie',
            data: {
                labels: Object.keys(@json($data['sexoCount'])).map(s => s === 'masculino' ? 'Macho' : 'Hembra'),
                datasets: [{
                    label: 'Sexo',
                    data: Object.values(@json($data['sexoCount'])),
                    backgroundColor: ['#e83e8c', '#007bff'],
                }]
            },
        });
    @endforeach
</script>

@endsection
