@extends('layouts.app')

@section('title', 'Reporte de Pagos - SilverGym')

@section('content')
<div style="padding: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 32px; font-weight: bold; color: #1e88e5;">
            <i class="fas fa-chart-line"></i> Reporte de Pagos
        </h1>
        <a href="{{ route('pagos.create') }}" style="padding: 12px 24px; background: linear-gradient(135deg, #4caf50, #45a049); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s;">
            <i class="fas fa-plus"></i> Nuevo Pago
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filtros -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 25px;">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;">
            <i class="fas fa-filter"></i> Filtros
        </h3>
        <form method="GET" action="{{ route('pagos.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ $fechaFin }}" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Membresía</label>
                <select name="membresia_id" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                    <option value="">Todas</option>
                    @foreach($membresias as $membresia)
                        <option value="{{ $membresia->id }}" {{ request('membresia_id') == $membresia->id ? 'selected' : '' }}>
                            {{ $membresia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #666; font-weight: 600;">Método de Pago</label>
                <select name="metodo_pago" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                    <option value="">Todos</option>
                    <option value="efectivo" {{ request('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ request('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ request('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>
            <div style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" style="flex: 1; padding: 10px; background: linear-gradient(135deg, #1e88e5, #1565c0); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Filtrar
                </button>
                <a href="{{ route('pagos.index') }}" style="flex: 1; padding: 10px; background: #757575; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; text-align: center;">
                    <i class="fas fa-redo"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Resumen de Estadísticas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: linear-gradient(135deg, #4caf50, #45a049); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Total Ingresos</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">${{ number_format($totalIngresos, 2) }}</h2>
                </div>
                <i class="fas fa-dollar-sign" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #2196f3, #1976d2); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Total Pagos</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">{{ $totalPagos }}</h2>
                </div>
                <i class="fas fa-receipt" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ff9800, #f57c00); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Promedio por Pago</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">${{ $totalPagos > 0 ? number_format($totalIngresos / $totalPagos, 2) : '0.00' }}</h2>
                </div>
                <i class="fas fa-chart-bar" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Estadísticas Detalladas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <!-- Pagos por Membresía -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #1e88e5; padding-bottom: 10px;">
                <i class="fas fa-id-card"></i> Pagos por Membresía
            </h3>
            <div style="max-height: 300px; overflow-y: auto;">
                @forelse($pagosPorMembresia as $item)
                    <div style="padding: 12px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="color: #333;">{{ $item->membresia ? $item->membresia->nombre : 'VISITA REGULAR' }}</strong>
                            <br>
                            <small style="color: #666;">{{ $item->total_pagos }} pago(s)</small>
                        </div>
                        <div style="text-align: right;">
                            <strong style="color: #4caf50; font-size: 18px;">${{ number_format($item->total_monto, 2) }}</strong>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #999; padding: 20px;">No hay datos</p>
                @endforelse
            </div>
        </div>

        <!-- Pagos por Usuario -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #2196f3; padding-bottom: 10px;">
                <i class="fas fa-user-tie"></i> Pagos Registrados por Usuario
            </h3>
            <div style="max-height: 300px; overflow-y: auto;">
                @forelse($pagosPorUsuario as $item)
                    <div style="padding: 12px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="color: #333;">{{ $item->usuario->username }}</strong>
                            <br>
                            <small style="color: #666;">{{ $item->total_pagos }} pago(s)</small>
                        </div>
                        <div style="text-align: right;">
                            <strong style="color: #2196f3; font-size: 18px;">${{ number_format($item->total_monto, 2) }}</strong>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #999; padding: 20px;">No hay datos</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top 10 Miembros -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 25px;">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #ff9800; padding-bottom: 10px;">
            <i class="fas fa-trophy"></i> Top 10 Miembros con Mayores Pagos
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Posición</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Miembro</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #666;">Total Pagos</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: #666;">Total Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($miembrosTopPagos as $index => $item)
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
                                {{ $item->total_pagos }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: right;">
                            <strong style="color: #4caf50; font-size: 18px;">${{ number_format($item->total_monto, 2) }}</strong>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; text-align: center; color: #999;">No hay datos disponibles</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla de Pagos Detallados -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;">
            <i class="fas fa-list"></i> Detalle de Pagos
        </h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: linear-gradient(135deg, #1e88e5, #1565c0); color: white;">
                    <th style="padding: 15px; text-align: left; border-radius: 8px 0 0 0;">Fecha</th>
                    <th style="padding: 15px; text-align: left;">Miembro</th>
                    <th style="padding: 15px; text-align: left;">Membresía</th>
                    <th style="padding: 15px; text-align: left;">Monto</th>
                    <th style="padding: 15px; text-align: left;">Método</th>
                    <th style="padding: 15px; text-align: center; border-radius: 0 8px 0 0;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagos as $pago)
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td style="padding: 15px;">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</td>
                    <td style="padding: 15px;">{{ $pago->miembro->nombre }} {{ $pago->miembro->apellidos }}</td>
                    <td style="padding: 15px;">{{ $pago->membresia ? $pago->membresia->nombre : 'VISITA REGULAR' }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4caf50;">${{ number_format($pago->monto, 2) }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 6px 12px; background: #e3f2fd; color: #1565c0; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            {{ strtoupper($pago->metodo_pago) }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route('pagos.show', $pago) }}" style="padding: 8px 16px; background: linear-gradient(135deg, #2196f3, #1976d2); color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; margin: 0 5px;">
                            <i class="fas fa-eye"></i> Ver Recibo
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: #666;">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                        No hay pagos registrados en el período seleccionado
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $pagos->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
