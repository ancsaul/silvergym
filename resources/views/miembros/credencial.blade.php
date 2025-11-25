<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial - {{ $miembro->nombre_completo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .credencial {
            width: 350px;
            background: linear-gradient(135deg, #0088ff 0%, #0066ff 100%);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .credencial-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }

        .gym-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .credencial-type {
            font-size: 14px;
            opacity: 0.9;
        }

        .foto-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .foto {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            background: white;
        }

        .foto-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            background: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            margin: 0 auto;
        }

        .info-section {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-active {
            background: #00c853;
        }

        .status-inactive {
            background: #ff3d00;
        }

        .print-btn {
            width: 100%;
            padding: 12px;
            background: white;
            color: #0066ff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-btn {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .print-btn,
            .back-btn {
                display: none;
            }

            .credencial {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="credencial">
        <div class="credencial-header">
            <div class="gym-name">🏋️ SilverGym</div>
            <div class="credencial-type">CREDENCIAL DE MIEMBRO</div>
        </div>

        <div class="foto-container">
            @if($miembro->foto)
                <img src="{{ asset('storage/' . $miembro->foto) }}" alt="{{ $miembro->nombre_completo }}" class="foto">
            @else
                <div class="foto-placeholder">👤</div>
            @endif
        </div>

        <div class="info-section">
            <div class="info-item">
                <div class="info-label">NOMBRE COMPLETO</div>
                <div class="info-value">{{ $miembro->nombre_completo }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">DOCUMENTO</div>
                <div class="info-value">{{ $miembro->documento }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">MIEMBRO DESDE</div>
                <div class="info-value">{{ $miembro->fecha_inscripcion->format('d/m/Y') }}</div>
            </div>

            @if($miembro->ultimoPago)
            <div class="info-item">
                <div class="info-label">VENCIMIENTO</div>
                <div class="info-value">{{ $miembro->ultimoPago->fecha_vencimiento->format('d/m/Y') }}</div>
            </div>
            @endif

            <div class="info-item" style="text-align: center; margin-top: 20px;">
                @if($miembro->tieneMembresiaActiva())
                    <span class="status-badge status-active">MEMBRESÍA ACTIVA</span>
                @else
                    <span class="status-badge status-inactive">MEMBRESÍA VENCIDA</span>
                @endif
            </div>
        </div>

        <button onclick="window.print()" class="print-btn">🖨️ Imprimir Credencial</button>
        <a href="{{ route('miembros.show', $miembro) }}" class="back-btn">← Volver</a>
    </div>
</body>
</html>
