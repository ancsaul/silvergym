@extends('layouts.app')

@section('title', 'Miembro Registrado - SilverGym')

@section('styles')
<style>
    .success-container {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        padding: 40px 20px;
    }

    .success-icon {
        font-size: 80px;
        margin-bottom: 20px;
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-title {
        font-size: 32px;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 15px;
    }

    .success-message {
        font-size: 18px;
        color: #757575;
        margin-bottom: 40px;
    }

    .member-summary {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
        text-align: left;
    }

    .member-summary-name {
        font-size: 24px;
        font-weight: 700;
        color: #212121;
        margin-bottom: 10px;
    }

    .member-summary-doc {
        font-size: 16px;
        color: #757575;
        margin-bottom: 20px;
    }

    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .option-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-color: #1e88e5;
    }

    .option-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .option-title {
        font-size: 18px;
        font-weight: 700;
        color: #212121;
        margin-bottom: 10px;
    }

    .option-description {
        font-size: 14px;
        color: #757575;
        line-height: 1.5;
    }

    .option-card.primary {
        background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        color: white;
    }

    .option-card.primary:hover {
        border-color: white;
    }

    .option-card.primary .option-title,
    .option-card.primary .option-description {
        color: white;
    }
</style>
@endsection

@section('content')
<div class="success-container">
    <div class="success-icon">✅</div>
    <h1 class="success-title">¡Miembro Registrado Exitosamente!</h1>
    <p class="success-message">El miembro ha sido agregado al sistema. ¿Qué deseas hacer ahora?</p>

    <div class="member-summary">
        <div class="member-summary-name">{{ $miembro->nombre_completo }}</div>
        <div class="member-summary-doc">Documento: {{ $miembro->documento }}</div>
        
        @if($miembro->contacto_emergencia_nombre)
        <div style="background: #fff3e0; padding: 15px; border-radius: 8px; margin-top: 15px;">
            <div style="font-size: 13px; color: #e65100; font-weight: 600; margin-bottom: 8px;">🚨 Contacto de Emergencia Registrado</div>
            <div style="font-size: 14px; color: #212121;">
                {{ $miembro->contacto_emergencia_nombre }} 
                @if($miembro->contacto_emergencia_telefono)
                    - {{ $miembro->contacto_emergencia_telefono }}
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="options-grid">
        <a href="{{ route('miembros.credencial', $miembro) }}" class="option-card">
            <div class="option-icon">🎫</div>
            <div class="option-title">Generar Credencial</div>
            <div class="option-description">Imprime la credencial del miembro con su foto e información</div>
        </a>

        <a href="{{ route('pagos.create', ['miembro_id' => $miembro->id]) }}" class="option-card primary">
            <div class="option-icon">💰</div>
            <div class="option-title">Realizar Pago</div>
            <div class="option-description">Registra la primera membresía y el pago correspondiente</div>
        </a>

        <a href="{{ route('miembros.show', $miembro) }}" class="option-card">
            <div class="option-icon">👤</div>
            <div class="option-title">Ver Perfil</div>
            <div class="option-description">Consulta toda la información del miembro registrado</div>
        </a>
    </div>

    <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
        <a href="{{ route('miembros.create') }}" class="btn btn-success" style="padding: 12px 30px;">
            ➕ Registrar Otro Miembro
        </a>
        <a href="{{ route('miembros.index') }}" class="btn" style="background: #6c757d; color: white; padding: 12px 30px;">
            📋 Ver Lista de Miembros
        </a>
    </div>
</div>
@endsection
