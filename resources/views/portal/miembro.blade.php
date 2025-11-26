<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Membresía - SilverGym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
        }

        .btn-back {
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border: 2px solid white;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .welcome-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #667eea;
        }

        .welcome-photo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
        }

        .welcome-info h1 {
            color: #333;
            margin-bottom: 5px;
        }

        .welcome-info p {
            color: #666;
            font-size: 16px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .status-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .status-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
        }

        .status-card.active::before {
            background: linear-gradient(90deg, #4caf50, #45a049);
        }

        .status-card.warning::before {
            background: linear-gradient(90deg, #ff9800, #f57c00);
        }

        .status-card.expired::before {
            background: linear-gradient(90deg, #f44336, #d32f2f);
        }

        .status-card.info::before {
            background: linear-gradient(90deg, #2196f3, #1976d2);
        }

        .status-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .status-card.active .status-icon {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
        }

        .status-card.warning .status-icon {
            background: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }

        .status-card.expired .status-icon {
            background: rgba(244, 67, 54, 0.1);
            color: #f44336;
        }

        .status-card.info .status-icon {
            background: rgba(33, 150, 243, 0.1);
            color: #2196f3;
        }

        .status-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .status-value {
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }

        .status-subtitle {
            font-size: 14px;
            color: #999;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }

        .badge-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-warning {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-expired {
            background: #ffebee;
            color: #c62828;
        }

        .section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .section-title i {
            margin-right: 10px;
            color: #667eea;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #666;
            font-size: 14px;
            border-bottom: 2px solid #e0e0e0;
        }

        .table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }

        .table tr:hover {
            background: #f9f9f9;
        }

        .amount {
            font-weight: 700;
            color: #4caf50;
            font-size: 16px;
        }

        .countdown {
            text-align: center;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .countdown-value {
            font-size: 72px;
            font-weight: 700;
            margin: 20px 0;
            text-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .countdown-label {
            font-size: 24px;
            opacity: 0.9;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        @media print {
            .btn-back, .header {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">🏋️ SilverGym</div>
            <form action="{{ route('portal.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-back" style="background: rgba(255,255,255,0.2); border: 2px solid white; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Bienvenida -->
        <div class="welcome">
            @if($miembro->foto)
                <img src="{{ asset('storage/' . $miembro->foto) }}" alt="Foto" class="welcome-photo">
            @else
                <div class="welcome-photo-placeholder">
                    {{ strtoupper(substr($miembro->nombre, 0, 1)) }}{{ strtoupper(substr($miembro->apellidos, 0, 1)) }}
                </div>
            @endif
            <div class="welcome-info">
                <h1>¡Hola, {{ $miembro->nombre }}!</h1>
                <p><i class="fas fa-id-card"></i> Matrícula: <strong>{{ $miembro->id }}</strong></p>
                <p><i class="fas fa-envelope"></i> {{ $miembro->email }}</p>
                <p><i class="fas fa-phone"></i> {{ $miembro->telefono }}</p>
            </div>
        </div>

        <!-- Estado de Membresía -->
        @if($ultimoPago)
            @if($membresiaActiva)
                @if($diasRestantes <= 7)
                    <div class="countdown" style="background: linear-gradient(135deg, #ff9800, #f57c00);">
                        <div class="countdown-label">⚠️ Tu membresía vence en</div>
                        <div class="countdown-value">{{ $diasRestantes }}</div>
                        <div class="countdown-label">{{ $diasRestantes == 1 ? 'día' : 'días' }}</div>
                        <p style="margin-top: 20px; font-size: 16px;">¡Renueva pronto para seguir disfrutando de todos los beneficios!</p>
                    </div>
                @else
                    <div class="countdown">
                        <div class="countdown-label">✓ Tu membresía está activa por</div>
                        <div class="countdown-value">{{ $diasRestantes }}</div>
                        <div class="countdown-label">{{ $diasRestantes == 1 ? 'día' : 'días' }} más</div>
                    </div>
                @endif
            @else
                <div class="countdown" style="background: linear-gradient(135deg, #f44336, #d32f2f);">
                    <div class="countdown-label">❌ Membresía Vencida</div>
                    <div class="countdown-value">{{ abs($diasRestantes) }}</div>
                    <div class="countdown-label">{{ abs($diasRestantes) == 1 ? 'día' : 'días' }} de retraso</div>
                    <p style="margin-top: 20px; font-size: 16px;">Por favor, renueva tu membresía para continuar accediendo al gimnasio.</p>
                </div>
            @endif
        @endif

        <!-- Tarjetas de Estado -->
        <div class="status-grid">
            <div class="status-card {{ $membresiaActiva ? 'active' : 'expired' }}">
                <div class="status-icon">
                    <i class="fas {{ $membresiaActiva ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                </div>
                <div class="status-label">Estado de Membresía</div>
                <div class="status-value">{{ $membresiaActiva ? 'ACTIVA' : 'VENCIDA' }}</div>
                @if($ultimoPago)
                    <span class="badge {{ $membresiaActiva ? 'badge-active' : 'badge-expired' }}">
                        {{ $ultimoPago->membresia->nombre }}
                    </span>
                @endif
            </div>

            @if($ultimoPago)
                <div class="status-card {{ $diasRestantes <= 7 && $membresiaActiva ? 'warning' : 'info' }}">
                    <div class="status-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="status-label">Fecha de Vencimiento</div>
                    <div class="status-value" style="font-size: 20px;">
                        {{ \Carbon\Carbon::parse($ultimoPago->fecha_vencimiento)->format('d/m/Y') }}
                    </div>
                    <div class="status-subtitle">
                        {{ \Carbon\Carbon::parse($ultimoPago->fecha_vencimiento)->diffForHumans() }}
                    </div>
                </div>

                <div class="status-card info">
                    <div class="status-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="status-label">Último Pago</div>
                    <div class="status-value" style="font-size: 24px;">
                        ${{ number_format($ultimoPago->monto, 2) }}
                    </div>
                    <div class="status-subtitle">
                        {{ \Carbon\Carbon::parse($ultimoPago->fecha_pago)->format('d/m/Y') }}
                    </div>
                </div>
            @endif

            <div class="status-card info">
                <div class="status-icon">
                    <i class="fas fa-walking"></i>
                </div>
                <div class="status-label">Visitas Este Mes</div>
                <div class="status-value">{{ $visitasEsteMes }}</div>
                <div class="status-subtitle">{{ now()->format('F Y') }}</div>
            </div>
        </div>

        <!-- Historial de Pagos -->
        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-receipt"></i> Historial de Pagos
            </h2>
            @if($pagos->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha de Pago</th>
                            <th>Membresía</th>
                            <th>Monto</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Vencimiento</th>
                            <th>Método</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagos as $pago)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td><strong>{{ $pago->membresia->nombre }}</strong></td>
                            <td class="amount">${{ number_format($pago->monto, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($pago->metodo_pago) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No hay pagos registrados</p>
                </div>
            @endif
        </div>

        <!-- Historial de Visitas (Últimos 30 días) -->
        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-history"></i> Últimas Visitas (30 días)
            </h2>
            @if($visitas->count() > 0)
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
                        @foreach($visitas as $visita)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($visita->fecha_hora_entrada)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($visita->fecha_hora_entrada)->format('H:i') }}</td>
                            <td>
                                @if($visita->fecha_hora_salida)
                                    {{ \Carbon\Carbon::parse($visita->fecha_hora_salida)->format('H:i') }}
                                @else
                                    <span class="badge badge-warning">En gimnasio</span>
                                @endif
                            </td>
                            <td>
                                @if($visita->fecha_hora_salida)
                                    {{ \Carbon\Carbon::parse($visita->fecha_hora_entrada)->diffInMinutes(\Carbon\Carbon::parse($visita->fecha_hora_salida)) }} min
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No hay visitas registradas en los últimos 30 días</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
