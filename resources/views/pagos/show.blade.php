@extends('layouts.app')

@section('title', 'Detalle Pago - SilverGym')

@section('styles')
<style>
    .payment-receipt {
        background: white;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .receipt-header {
        text-align: center;
        border-bottom: 2px solid #1e88e5;
        padding-bottom: 25px;
        margin-bottom: 30px;
    }

    .receipt-title {
        font-size: 32px;
        font-weight: 700;
        color: #1e88e5;
        margin-bottom: 10px;
    }

    .receipt-subtitle {
        font-size: 14px;
        color: #757575;
    }

    .receipt-section {
        margin-bottom: 30px;
    }

    .receipt-section-title {
        font-size: 14px;
        color: #757575;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .receipt-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .receipt-info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .receipt-info-label {
        font-size: 13px;
        color: #757575;
    }

    .receipt-info-value {
        font-size: 16px;
        color: #212121;
        font-weight: 600;
    }

    .receipt-total {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .receipt-total-label {
        font-size: 18px;
        color: #757575;
        font-weight: 600;
    }

    .receipt-total-amount {
        font-size: 32px;
        color: #1e88e5;
        font-weight: 700;
    }

    .print-button {
        margin-top: 30px;
        text-align: center;
    }

    @media print {
        .btn, .print-button {
            display: none !important;
        }
        
        body {
            background: white;
        }

        .payment-receipt {
            box-shadow: none;
        }
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('pagos.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="payment-receipt">
    <div class="receipt-header">
        <div style="font-size: 48px; margin-bottom: 10px;">🏋️</div>
        <div class="receipt-title">SilverGym</div>
        <div class="receipt-subtitle">Comprobante de Pago</div>
        <div style="margin-top: 15px; font-size: 13px; color: #757575;">
            Recibo #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="receipt-section">
        <div class="receipt-section-title">Información del Miembro</div>
        <div class="receipt-info-grid">
            <div class="receipt-info-item">
                <div class="receipt-info-label">Nombre Completo</div>
                <div class="receipt-info-value">{{ $pago->miembro->nombre_completo }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Documento</div>
                <div class="receipt-info-value">{{ $pago->miembro->documento }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Teléfono</div>
                <div class="receipt-info-value">{{ $pago->miembro->telefono ?? 'No registrado' }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Email</div>
                <div class="receipt-info-value">{{ $pago->miembro->email ?? 'No registrado' }}</div>
            </div>
        </div>
    </div>

    <div class="receipt-section">
        <div class="receipt-section-title">Información de la Membresía</div>
        <div class="receipt-info-grid">
            <div class="receipt-info-item">
                <div class="receipt-info-label">Plan</div>
                <div class="receipt-info-value">{{ $pago->membresia->nombre }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Duración</div>
                <div class="receipt-info-value">{{ $pago->membresia->duracion_dias }} días</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Fecha Inicio</div>
                <div class="receipt-info-value">{{ $pago->fecha_inicio->format('d/m/Y') }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Fecha Vencimiento</div>
                <div class="receipt-info-value">{{ $pago->fecha_vencimiento->format('d/m/Y') }}</div>
            </div>
        </div>

        @if($pago->membresia->descripcion)
        <div style="margin-top: 15px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
            <div style="font-size: 13px; color: #757575; margin-bottom: 5px;">Descripción</div>
            <div style="font-size: 14px; color: #212121;">{{ $pago->membresia->descripcion }}</div>
        </div>
        @endif

        <div style="margin-top: 15px; text-align: center;">
            @if($pago->fecha_vencimiento >= now()->toDateString())
                <span class="badge badge-success" style="font-size: 16px; padding: 10px 20px;">MEMBRESÍA ACTIVA</span>
            @else
                <span class="badge badge-danger" style="font-size: 16px; padding: 10px 20px;">MEMBRESÍA VENCIDA</span>
            @endif
        </div>
    </div>

    <div class="receipt-section">
        <div class="receipt-section-title">Información del Pago</div>
        <div class="receipt-info-grid">
            <div class="receipt-info-item">
                <div class="receipt-info-label">Fecha de Pago</div>
                <div class="receipt-info-value">{{ $pago->fecha_pago->format('d/m/Y') }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Método de Pago</div>
                <div class="receipt-info-value">{{ ucfirst($pago->metodo_pago) }}</div>
            </div>
            <div class="receipt-info-item">
                <div class="receipt-info-label">Atendido por</div>
                <div class="receipt-info-value">{{ $pago->usuario->name }}</div>
            </div>
        </div>

        @if($pago->observaciones)
        <div style="margin-top: 15px;">
            <div class="receipt-info-label">Observaciones</div>
            <div style="margin-top: 5px; font-size: 14px; color: #212121;">{{ $pago->observaciones }}</div>
        </div>
        @endif
    </div>

    <div class="receipt-total">
        <div class="receipt-total-label">Total Pagado</div>
        <div class="receipt-total-amount">${{ number_format($pago->monto, 2) }}</div>
    </div>

    <div style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #e0e0e0; text-align: center; color: #757575; font-size: 13px;">
        <p>Gracias por confiar en nosotros</p>
        <p style="margin-top: 10px;">Este comprobante es válido como documento de pago</p>
        <p style="margin-top: 5px;">Fecha de emisión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="print-button">
        <button onclick="window.print()" class="btn btn-primary" style="padding: 12px 30px;">
            🖨️ Imprimir Comprobante
        </button>
        <a href="{{ route('miembros.show', $pago->miembro) }}" class="btn btn-success" style="padding: 12px 30px;">
            Ver Miembro
        </a>
    </div>
</div>
@endsection
