@extends('layouts.app')

@section('title', 'Reporte de Visitas - SilverGym')

@section('content')
<div style="padding: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 32px; font-weight: bold; color: #1e88e5;">
            <i class="fas fa-chart-area"></i> Reporte de Visitas
        </h1>
        <a href="{{ route('visitas.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #4caf50, #45a049); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s;">
            <i class="fas fa-plus"></i> Registrar Entrada
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 25px;">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;">
            <i class="fas fa-filter"></i> Filtros
        </h3>
        <form method="GET" action="{{ route('visitas.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ $fechaFin }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Tipo de Visita</label>
                <select name="tipo" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                    <option value="">Todas</option>
                    <option value="miembro" {{ request('tipo') == 'miembro' ? 'selected' : '' }}>Miembros</option>
                    <option value="regular" {{ request('tipo') == 'regular' ? 'selected' : '' }}>Visitas Regulares</option>
                </select>
            </div>
            <div style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" style="flex: 1; padding: 10px; background: linear-gradient(135deg, #1e88e5, #1565c0); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Filtrar
                </button>
                <a href="{{ route('visitas.index') }}" style="flex: 1; padding: 10px; background: #757575; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; text-align: center;">
                    <i class="fas fa-redo"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Resumen de Estadísticas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: linear-gradient(135deg, #9c27b0, #7b1fa2); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Total Visitas</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">{{ $totalVisitas }}</h2>
                </div>
                <i class="fas fa-door-open" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #2196f3, #1976d2); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Visitas Miembros</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">{{ $visitasMiembros }}</h2>
                </div>
                <i class="fas fa-id-card" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ff9800, #f57c00); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Visitas Regulares</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">{{ $visitasRegulares }}</h2>
                </div>
                <i class="fas fa-user-clock" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #4caf50, #45a049); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Ingresos Regulares</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">${{ number_format($ingresoRegulares, 2) }}</h2>
                </div>
                <i class="fas fa-dollar-sign" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <!-- Visitas por Hora -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #9c27b0; padding-bottom: 10px;">
                <i class="fas fa-clock"></i> Visitas por Hora del Día
            </h3>
            <canvas id="visitasPorHoraChart"></canvas>
        </div>

        <!-- Visitas por Día de la Semana -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #2196f3; padding-bottom: 10px;">
                <i class="fas fa-calendar-week"></i> Visitas por Día de la Semana
            </h3>
            <canvas id="visitasPorDiaChart"></canvas>
        </div>
    </div>

    <!-- Top 10 Miembros -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 25px;">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #ff9800; padding-bottom: 10px;">
            <i class="fas fa-trophy"></i> Top 10 Miembros Más Activos
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Posición</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Miembro</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #666;">Total Visitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($miembrosTopVisitas as $index => $item)
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 12px;">
                            @if($index == 0)
                                <span style="display: inline-block; width: 30px; height: 30px; background: gold; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold;">🥇</span>
                            @elseif($index == 1)
                                <span style="display: inline-block; width: 30px; height: 30px; background: silver; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold;">🥈</span>
                            @elseif($index == 2)
                                <span style="display: inline-block; width: 30px; height: 30px; background: #cd7f32; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold;">🥉</span>
                            @else
                                <span style="display: inline-block; width: 30px; height: 30px; background: #e0e0e0; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold;">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <a href="{{ route('miembros.show', $item->miembro) }}" style="color: #1e88e5; text-decoration: none; font-weight: 600;">
                                {{ $item->miembro->nombre }} {{ $item->miembro->apellidos }}
                            </a>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="padding: 6px 12px; background: #e3f2fd; color: #1565c0; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                {{ $item->total_visitas }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 30px; text-align: center; color: #999;">No hay datos disponibles</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla de Visitas Detalladas -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;">
            <i class="fas fa-list"></i> Detalle de Visitas
        </h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: linear-gradient(135deg, #9c27b0, #7b1fa2); color: white;">
                    <th style="padding: 15px; text-align: left; border-radius: 8px 0 0 0;">Tipo</th>
                    <th style="padding: 15px; text-align: left;">Nombre/Miembro</th>
                    <th style="padding: 15px; text-align: left;">Entrada</th>
                    <th style="padding: 15px; text-align: left;">Salida</th>
                    <th style="padding: 15px; text-align: left;">Duración</th>
                    <th style="padding: 15px; text-align: center; border-radius: 0 8px 0 0;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitas as $visita)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px;">
                        @if($visita->tipo == 'miembro')
                            <span style="padding: 6px 12px; background: #e3f2fd; color: #1565c0; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                MIEMBRO
                            </span>
                        @else
                            <span style="padding: 6px 12px; background: #fff3e0; color: #f57c00; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                REGULAR
                            </span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if($visita->tipo == 'miembro' && $visita->miembro)
                            <a href="{{ route('miembros.show', $visita->miembro) }}" style="color: #1e88e5; text-decoration: none; font-weight: 600;">
                                {{ $visita->miembro->nombre }} {{ $visita->miembro->apellidos }}
                            </a>
                        @else
                            {{ $visita->nombre_visitante }}
                            @if($visita->monto)
                                <br><small style="color: #4caf50; font-weight: 600;">${{ number_format($visita->monto, 2) }}</small>
                            @endif
                        @endif
                    </td>
                    <td style="padding: 15px;">{{ \Carbon\Carbon::parse($visita->fecha_hora_entrada)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 15px;">
                        @if($visita->fecha_hora_salida)
                            {{ \Carbon\Carbon::parse($visita->fecha_hora_salida)->format('H:i') }}
                        @else
                            <span style="padding: 6px 12px; background: #fff9c4; color: #f57f17; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                EN GIMNASIO
                            </span>
                        @endif
                    </td>
                    <td style="padding: 15px;">
                        @if($visita->fecha_hora_salida)
                            {{ \Carbon\Carbon::parse($visita->fecha_hora_entrada)->diffInMinutes(\Carbon\Carbon::parse($visita->fecha_hora_salida)) }} min
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if(!$visita->fecha_hora_salida)
                            <form action="{{ route('visitas.salida', $visita) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="padding: 8px 16px; background: linear-gradient(135deg, #f44336, #d32f2f); color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i> Registrar Salida
                                </button>
                            </form>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: #666;">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                        No hay visitas registradas en el período seleccionado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $visitas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Visitas por Hora
    const visitasPorHoraData = @json($visitasPorHora);
    const horasLabels = Array.from({length: 24}, (_, i) => i + ':00');
    const horasData = horasLabels.map((_, i) => visitasPorHoraData[i] || 0);

    new Chart(document.getElementById('visitasPorHoraChart'), {
        type: 'bar',
        data: {
            labels: horasLabels,
            datasets: [{
                label: 'Visitas',
                data: horasData,
                backgroundColor: 'rgba(156, 39, 176, 0.6)',
                borderColor: 'rgba(156, 39, 176, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Visitas por Día de la Semana
    const visitasPorDiaData = @json($visitasPorDia);
    const diasLabels = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const diasData = [1, 2, 3, 4, 5, 6, 7].map(dia => visitasPorDiaData[dia] || 0);

    new Chart(document.getElementById('visitasPorDiaChart'), {
        type: 'line',
        data: {
            labels: diasLabels,
            datasets: [{
                label: 'Visitas',
                data: diasData,
                backgroundColor: 'rgba(33, 150, 243, 0.2)',
                borderColor: 'rgba(33, 150, 243, 1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection
