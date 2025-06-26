@extends('layout')

@section('content')
<h1>Reportes por Finca</h1>

@foreach ($dataPorFinca as $finca => $data)
<div style="margin-bottom: 50px; background:#fff; padding:20px; border-radius:10px; box-shadow: 0 0 10px #ccc;">
    <h2>Finca: {{ $finca }}</h2>

    <div style="display:flex; flex-wrap: wrap; gap: 20px;">

        <div style="flex: 1; min-width: 300px;">
            <canvas id="registroPorMes_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <canvas id="estadoCount_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <canvas id="sexoCount_{{ Str::slug($finca) }}"></canvas>
        </div>

        <div style="flex: 1; min-width: 300px; padding: 20px; background: #e7f5f7; border-radius: 8px;">
            <h3>Resumen</h3>
            <p><strong>Peso total:</strong> {{ number_format($data['pesoTotal'], 2) }} kg</p>
            <p><strong>Peso promedio:</strong> {{ number_format($data['pesoPromedio'], 2) }} kg</p>
            <p><strong>Monto total:</strong> ₡{{ number_format($data['montoTotal'], 0) }}</p>
        </div>
    </div>
</div>
@endforeach

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
        new Chart(ctxEstado_{{ Str::slug($finca) }}, {
            type: 'doughnut',
            data: {
                labels: Object.keys(@json($data['estadoCount'])),
                datasets: [{
                    label: 'Estado',
                    data: Object.values(@json($data['estadoCount'])),
                    backgroundColor: ['#28a745', '#dc3545'],
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
                    backgroundColor: ['#007bff', '#e83e8c'],
                }]
            },
        });
    @endforeach
</script>
@endsection
