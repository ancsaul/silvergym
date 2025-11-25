@extends('layouts.app')

@section('title', 'Dashboard - SilverGym')

@section('content')
<h1 style="margin-bottom: 30px; color: #333;">Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Miembros</div>
        <div class="stat-value">{{ $totalMiembros }}</div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-label">Miembros Activos</div>
        <div class="stat-value">{{ $miembrosActivos }}</div>
    </div>
    
    <div class="stat-card orange">
        <div class="stat-label">Visitas Hoy</div>
        <div class="stat-value">{{ $visitasHoy }}</div>
    </div>
    
    <div class="stat-card purple">
        <div class="stat-label">Ingresos Hoy</div>
        <div class="stat-value">${{ number_format($ingresosHoy, 2) }}</div>
    </div>
</div>

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
