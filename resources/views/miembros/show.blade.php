@extends('layouts.app')

@section('title', 'Detalle Miembro - SilverGym')

@section('styles')
<style>
    .member-header {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        display: flex;
        gap: 30px;
        align-items: start;
    }

    .member-photo {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        object-fit: cover;
        border: 3px solid #e0e0e0;
    }

    .member-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 10px;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        border: 3px solid #e0e0e0;
    }

    .member-info {
        flex: 1;
    }

    .member-name {
        font-size: 28px;
        font-weight: 700;
        color: #212121;
        margin-bottom: 10px;
    }

    .member-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .meta-label {
        font-size: 12px;
        color: #757575;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .meta-value {
        font-size: 15px;
        color: #212121;
        font-weight: 500;
    }

    .membership-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .membership-status.active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .membership-status.expired {
        background: #ffebee;
        color: #c62828;
    }

    .membership-status.none {
        background: #f5f5f5;
        color: #616161;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #212121;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .membership-card {
        background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        border-radius: 10px;
        padding: 25px;
        color: white;
        margin-bottom: 20px;
    }

    .membership-card h3 {
        font-size: 20px;
        margin-bottom: 15px;
    }

    .membership-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .membership-detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .membership-detail-label {
        font-size: 12px;
        opacity: 0.9;
    }

    .membership-detail-value {
        font-size: 18px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('miembros.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="member-header">
    @if($miembro->foto)
        <img src="{{ asset('storage/' . $miembro->foto) }}" alt="{{ $miembro->nombre_completo }}" class="member-photo">
    @else
        <div class="member-photo-placeholder">👤</div>
    @endif

    <div class="member-info">
        <h1 class="member-name">{{ $miembro->nombre_completo }}</h1>
        
        @if($miembro->tieneMembresiaActiva())
            <span class="membership-status active">
                <span>✓</span> MEMBRESÍA ACTIVA
            </span>
        @elseif($miembro->ultimoPago)
            <span class="membership-status expired">
                <span>✗</span> MEMBRESÍA VENCIDA
            </span>
        @else
            <span class="membership-status none">
                <span>○</span> SIN MEMBRESÍA
            </span>
        @endif

        <div class="member-meta">
            <div class="meta-item">
                <div class="meta-label">Documento</div>
                <div class="meta-value">{{ $miembro->documento }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Teléfono</div>
                <div class="meta-value">{{ $miembro->telefono ?? 'No registrado' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Email</div>
                <div class="meta-value">{{ $miembro->email ?? 'No registrado' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Género</div>
                <div class="meta-value">{{ ucfirst($miembro->genero ?? 'No especificado') }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Fecha Nacimiento</div>
                <div class="meta-value">{{ $miembro->fecha_nacimiento ? $miembro->fecha_nacimiento->format('d/m/Y') : 'No registrada' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Miembro Desde</div>
                <div class="meta-value">{{ $miembro->fecha_inscripcion->format('d/m/Y') }}</div>
            </div>
        </div>

        @if($miembro->direccion)
        <div class="meta-item" style="margin-top: 15px;">
            <div class="meta-label">Dirección</div>
            <div class="meta-value">{{ $miembro->direccion }}</div>
        </div>
        @endif

        @if($miembro->contacto_emergencia_nombre)
        <div style="margin-top: 20px; padding: 15px; background: #fff3e0; border-radius: 8px; border-left: 4px solid #fb8c00;">
            <div style="font-size: 14px; font-weight: 600; color: #e65100; margin-bottom: 10px;">🚨 Contacto de Emergencia</div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <div style="font-size: 12px; color: #757575;">Nombre</div>
                    <div style="font-size: 14px; color: #212121; font-weight: 500;">{{ $miembro->contacto_emergencia_nombre }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #757575;">Teléfono</div>
                    <div style="font-size: 14px; color: #212121; font-weight: 500;">{{ $miembro->contacto_emergencia_telefono ?? 'No registrado' }}</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: #757575;">Relación</div>
                    <div style="font-size: 14px; color: #212121; font-weight: 500;">{{ $miembro->contacto_emergencia_relacion ?? 'No especificada' }}</div>
                </div>
            </div>
        </div>
        @endif

        <div class="action-buttons">
            <a href="{{ route('miembros.edit', $miembro) }}" class="btn btn-primary">✏️ Editar</a>
            <a href="{{ route('miembros.credencial', $miembro) }}" class="btn" style="background: #8e24aa; color: white;">🎫 Ver Credencial</a>
            <a href="{{ route('pagos.create', ['miembro_id' => $miembro->id]) }}" class="btn btn-success">💰 Registrar Pago</a>
        </div>
    </div>
</div>

<!-- Membresía Actual -->
@if($miembro->ultimoPago)
<div class="card" style="margin-bottom: 25px;">
    <h2 class="section-title">
        <span>💳</span> Membresía Actual
    </h2>
    
    <div class="membership-card" style="background: linear-gradient(135deg, {{ $miembro->tieneMembresiaActiva() ? '#43a047 0%, #2e7d32' : '#e53935 0%, #c62828' }} 100%);">
        <h3>{{ $miembro->ultimoPago->membresia->nombre }}</h3>
        <p style="opacity: 0.9; margin-bottom: 0;">{{ $miembro->ultimoPago->membresia->descripcion }}</p>
        
        <div class="membership-details">
            <div class="membership-detail-item">
                <div class="membership-detail-label">Fecha Inicio</div>
                <div class="membership-detail-value">{{ $miembro->ultimoPago->fecha_inicio->format('d/m/Y') }}</div>
            </div>
            <div class="membership-detail-item">
                <div class="membership-detail-label">Fecha Vencimiento</div>
                <div class="membership-detail-value">{{ $miembro->ultimoPago->fecha_vencimiento->format('d/m/Y') }}</div>
            </div>
            <div class="membership-detail-item">
                <div class="membership-detail-label">Días Restantes</div>
                <div class="membership-detail-value">
                    @php
                        $diasRestantes = now()->diffInDays($miembro->ultimoPago->fecha_vencimiento, false);
                    @endphp
                    {{ $diasRestantes > 0 ? $diasRestantes : 0 }} días
                </div>
            </div>
        </div>

        @if(!$miembro->tieneMembresiaActiva())
        <div style="margin-top: 20px; padding: 15px; background: rgba(255,255,255,0.2); border-radius: 8px;">
            <strong>⚠️ Esta membresía ha vencido.</strong> Por favor, renueva para seguir utilizando los servicios del gimnasio.
        </div>
        @endif
    </div>
</div>
@else
<div class="card" style="margin-bottom: 25px;">
    <h2 class="section-title">
        <span>💳</span> Membresía
    </h2>
    <div style="text-align: center; padding: 40px; color: #757575;">
        <div style="font-size: 48px; margin-bottom: 15px;">📋</div>
        <p style="font-size: 16px;">Este miembro no tiene ninguna membresía registrada.</p>
        <a href="{{ route('pagos.create', ['miembro_id' => $miembro->id]) }}" class="btn btn-primary" style="margin-top: 15px;">Registrar Primera Membresía</a>
    </div>
</div>
@endif

<!-- Historial de Pagos -->
<div class="card" style="margin-bottom: 25px;">
    <h2 class="section-title">
        <span>💰</span> Historial de Pagos
    </h2>
    
    @if($miembro->pagos->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Fecha Pago</th>
                <th>Membresía</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Vigencia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($miembro->pagos->sortByDesc('fecha_pago') as $pago)
            <tr>
                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                <td>{{ $pago->membresia->nombre }}</td>
                <td>${{ number_format($pago->monto, 2) }}</td>
                <td>{{ ucfirst($pago->metodo_pago) }}</td>
                <td>{{ $pago->fecha_inicio->format('d/m/Y') }} - {{ $pago->fecha_vencimiento->format('d/m/Y') }}</td>
                <td>
                    @if($pago->fecha_vencimiento >= now()->toDateString())
                        <span class="badge badge-success">ACTIVO</span>
                    @else
                        <span class="badge badge-danger">VENCIDO</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #999;">
        No hay pagos registrados
    </div>
    @endif
</div>

<!-- Historial de Visitas -->
<div class="card">
    <h2 class="section-title">
        <span>📅</span> Últimas Visitas
    </h2>
    
    @if($miembro->visitas->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Duración</th>
            </tr>
        </thead>
        <tbody>
            @foreach($miembro->visitas->sortByDesc('fecha_hora_entrada')->take(10) as $visita)
            <tr>
                <td>{{ $visita->fecha_hora_entrada->format('d/m/Y') }}</td>
                <td>{{ $visita->fecha_hora_entrada->format('H:i') }}</td>
                <td>
                    @if($visita->fecha_hora_salida)
                        {{ $visita->fecha_hora_salida->format('H:i') }}
                    @else
                        <span class="badge badge-warning">En gimnasio</span>
                    @endif
                </td>
                <td>
                    @if($visita->fecha_hora_salida)
                        {{ $visita->fecha_hora_entrada->diffInMinutes($visita->fecha_hora_salida) }} min
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #999;">
        No hay visitas registradas
    </div>
    @endif
</div>
@endsection
