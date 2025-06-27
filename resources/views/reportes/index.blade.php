@extends('layout')

@section('content')
<h1 style="font-size: 18px;">Reportes por Finca</h1>

@php
    use Illuminate\Support\Str;
@endphp

@foreach ($dataPorFinca as $finca => $data)
    @php
        $slug = Str::slug($finca, '_');

        // Asegurar que existan las claves 'Vendido', 'Muerto', 'Robado' en estadoCount con valor 0 si no existen
        $estadosBase = ['Vendido' => 0, 'Muerto' => 0, 'Robado' => 0];
        $estadoCountCompleto = array_merge($estadosBase, $data['estadoCount']);
    @endphp

    <div style="margin-bottom: 30px; background:#fff; padding:15px; border-radius:8px; box-shadow: 0 0 8px #ccc;">
        <h2 style="font-size: 16px; color: #087282;">Finca: {{ $finca }}</h2>

        <div style="display:flex; flex-wrap: wrap; gap: 10px;">

            <div style="flex: 1; min-width: 250px;">
                <canvas id="registroPorMes_{{ $slug }}"></canvas>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <canvas id="estadoCount_{{ $slug }}"></canvas>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <canvas id="sexoCount_{{ $slug }}"></canvas>
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
<script>
    @foreach ($dataPorFinca as $finca => $data)
        @php
            $slug = Str::slug($finca, '_');
            $estadosBase = ['Vendido' => 0, 'Muerto' => 0, 'Robado' => 0];
            $estadoCountCompleto = array_merge($estadosBase, $data['estadoCount']);
        @endphp

        const ctxRegistro_{{ $slug }} = document.getElementById('registroPorMes_{{ $slug }}').getContext('2d');
        new Chart(ctxRegistro_{{ $slug }}, {
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

        const ctxEstado_{{ $slug }} = document.getElementById('estadoCount_{{ $slug }}').getContext('2d');

        const estadoLabels_{{ $slug }} = Object.keys(@json($estadoCountCompleto));
        const estadoData_{{ $slug }} = Object.values(@json($estadoCountCompleto));

        const estadoColors_{{ $slug }} = estadoLabels_{{ $slug }}.map(estado => {
            if (estado === 'Vendido') return '#28a745'; // verde
            if (estado === 'Muerto') return '#dc3545';  // rojo
            if (estado === 'Robado') return '#f0ad4e';  // anaranjado
            return '#6c757d'; // gris
        });

       new Chart(ctxEstado_{{ $slug }}, {
    type: 'doughnut',
    data: {
        labels: estadoLabels_{{ $slug }},
        datasets: [{
            label: 'Estado',
            data: estadoData_{{ $slug }},
            backgroundColor: estadoColors_{{ $slug }},
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'top', // Leyenda arriba
                rtl: false, // No usar dirección right-to-left (evita desorden)
                labels: {
                    boxWidth: 12, // Ancho del cuadro de color pequeño
                    padding: 10, // Espaciado entre items
                    usePointStyle: true, // Usar estilo de punto (más compacto)
                    font: {
                        size: 11, // Tamaño de fuente ajustable
                    }
                }
            }
        }
    }
});

        const ctxSexo_{{ $slug }} = document.getElementById('sexoCount_{{ $slug }}').getContext('2d');
        new Chart(ctxSexo_{{ $slug }}, {
    type: 'pie',
    data: {
        labels: Object.keys(@json($data['sexoCount'])).map(s => s === 'masculino' ? 'Macho' : 'Hembra'),
        datasets: [{
            label: 'Sexo',
            data: Object.values(@json($data['sexoCount'])),
            backgroundColor: ['#e83e8c', '#007bff'],
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'top',
                rtl: false,
                labels: {
                    boxWidth: 12,
                    padding: 10,
                    usePointStyle: true,
                    font: {
                        size: 11,
                    }
                }
            }
        }
    }
});

    @endforeach
</script>

@endsection
