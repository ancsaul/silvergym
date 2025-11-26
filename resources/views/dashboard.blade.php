@extends('layouts.app')

@section('title', 'Dashboard - SilverGym')

@section('styles')
<style>
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #212121;
        margin: 0;
    }

    .page-subtitle {
        font-size: 14px;
        color: #757575;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Panel de Control</h1>
    <p class="page-subtitle">Bienvenido, {{ auth()->user()->name }} - {{ now()->format('d/m/Y') }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-content">
            <div class="stat-label">Total Miembros</div>
            <div class="stat-value">{{ $totalMiembros }}</div>
        </div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-icon">✓</div>
        <div class="stat-content">
            <div class="stat-label">Miembros Activos</div>
            <div class="stat-value">{{ $miembrosActivos }}</div>
        </div>
    </div>
    
    <div class="stat-card orange">
        <div class="stat-icon">📅</div>
        <div class="stat-content">
            <div class="stat-label">Visitas Hoy</div>
            <div class="stat-value">{{ $visitasHoy }}</div>
        </div>
    </div>
    
    <div class="stat-card purple">
        <div class="stat-icon">💰</div>
        <div class="stat-content">
            <div class="stat-label">Ingresos Hoy</div>
            <div class="stat-value">${{ number_format($ingresosHoy, 2) }}</div>
        </div>
    </div>
</div>

<!-- Gráficas -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
    <div class="card">
        <h2 class="card-title">📈 Visitas por Hora (Hoy)</h2>
        <canvas id="visitasHoraChart" style="max-height: 250px;"></canvas>
        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <h3 style="font-size: 14px; color: #757575; margin-bottom: 15px; font-weight: 600;">VISITAS REGISTRADAS POR HORA</h3>
            <table class="table" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th style="width: 25%;">09hrs</th>
                        <th style="width: 25%;">10hrs</th>
                        <th style="width: 25%;">11hrs</th>
                        <th style="width: 25%;">12hrs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $visitasPorHora[9] ?? 0 }}</td>
                        <td>{{ $visitasPorHora[10] ?? 0 }}</td>
                        <td>{{ $visitasPorHora[11] ?? 0 }}</td>
                        <td>{{ $visitasPorHora[12] ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px;">
        <div class="card">
            <h3 class="card-title">Visitas Semana</h3>
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <div style="font-size: 13px; color: #757575; margin-bottom: 8px;">VISITAS REGISTRADAS EN ESTA SEMANA</div>
                    @php
                        $diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    @endphp
                    @foreach([2, 1] as $dia)
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5f5f5;">
                        <span style="font-size: 13px;">{{ $diasSemana[$dia] ?? 'Día ' . $dia }}</span>
                        <span style="font-weight: 600; color: #1e88e5;">{{ $visitasPorDiaSemana[$dia] ?? 0 }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">Visitas Mes</h3>
            <div>
                <div style="font-size: 13px; color: #757575; margin-bottom: 8px;">VISITAS REGISTRAS POR DÍAS DE ESTE MES</div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5f5f5;">
                    <span style="font-size: 13px;">Día 1</span>
                    <span style="font-weight: 600; color: #1e88e5;">{{ $visitasPorDia[1] ?? 0 }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span style="font-size: 13px;">Total del mes</span>
                    <span style="font-weight: 600; font-size: 18px; color: #fb8c00;">{{ $visitasMes }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pagos -->
<div class="card" style="margin-bottom: 20px;">
    <h2 class="card-title">💰 Pagos por Mes</h2>
    <canvas id="pagosMesChart" style="max-height: 200px;"></canvas>
</div>

<!-- Tablas -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div class="card">
        <h2 class="card-title">Últimos Miembros Registrados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimosMiembros as $miembro)
                <tr>
                    <td>{{ $miembro->nombre_completo }}</td>
                    <td>{{ $miembro->documento }}</td>
                    <td>
                        @if($miembro->tieneMembresiaActiva())
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('miembros.show', $miembro) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">No hay miembros registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2 class="card-title">Próximos Vencimientos (7 días)</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Miembro</th>
                    <th>Membresía</th>
                    <th>Vence</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proximosVencimientos as $pago)
                <tr>
                    <td>{{ $pago->miembro->nombre_completo }}</td>
                    <td>{{ $pago->membresia->nombre }}</td>
                    <td>
                        <span class="badge badge-warning">
                            {{ $pago->fecha_vencimiento->format('d/m/Y') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999;">No hay vencimientos próximos</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfica de visitas por hora
    const visitasHoraCtx = document.getElementById('visitasHoraChart').getContext('2d');
    const visitasHoraData = @json($visitasPorHora);
    
    const horas = Array.from({length: 15}, (_, i) => i + 6); // 6am to 8pm
    const visitasValues = horas.map(h => visitasHoraData[h] || 0);

    new Chart(visitasHoraCtx, {
        type: 'line',
        data: {
            labels: horas.map(h => h + ':00'),
            datasets: [{
                label: 'Visitas',
                data: visitasValues,
                borderColor: '#fb8c00',
                backgroundColor: 'rgba(251, 140, 0, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfica de pagos por mes
    const pagosMesCtx = document.getElementById('pagosMesChart').getContext('2d');
    const pagosMesData = @json($pagosPorDia);
    
    const dias = Array.from({length: 30}, (_, i) => i + 1);
    const pagosValues = dias.map(d => pagosMesData[d] || 0);

    new Chart(pagosMesCtx, {
        type: 'line',
        data: {
            labels: dias,
            datasets: [{
                label: 'Ingresos ($)',
                data: pagosValues,
                borderColor: '#1e88e5',
                backgroundColor: 'rgba(30, 136, 229, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
