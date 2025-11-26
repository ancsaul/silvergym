<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SilverGym')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            padding: 16px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0;
            flex: 1;
            justify-content: center;
            margin: 0;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .navbar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            border-bottom: 3px solid white;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            font-size: 13px;
            text-align: right;
        }

        .user-role {
            font-size: 11px;
            opacity: 0.85;
            margin-top: 2px;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 25px 30px;
            background: #f5f7fa;
            min-height: calc(100vh - 60px);
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #1e88e5;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stat-card.green {
            border-left-color: #43a047;
        }

        .stat-card.orange {
            border-left-color: #fb8c00;
        }

        .stat-card.purple {
            border-left-color: #8e24aa;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .stat-card .stat-icon {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
        }

        .stat-card.green .stat-icon {
            background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%);
        }

        .stat-card.orange .stat-icon {
            background: linear-gradient(135deg, #fb8c00 0%, #e65100 100%);
        }

        .stat-card.purple .stat-icon {
            background: linear-gradient(135deg, #8e24aa 0%, #6a1b9a 100%);
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #757575;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #212121;
            line-height: 1;
        }

        .chart-container {
            margin-top: 15px;
            height: 50px;
        }

        .sparkline {
            width: 100%;
            height: 100%;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0088ff 0%, #0066ff 100%);
            color: white;
        }

        .btn-success {
            background: #00c853;
            color: white;
        }

        .btn-danger {
            background: #ff3d00;
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .table tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #0088ff;
        }

        select.form-control {
            cursor: pointer;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <span style="font-size: 24px;">🏋️</span>
                <span>SilverGym</span>
            </div>
            <ul class="navbar-menu">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span>📊</span> Inicio
                </a></li>
                <li><a href="{{ route('miembros.index') }}" class="{{ request()->routeIs('miembros.*') ? 'active' : '' }}">
                    <span>👥</span> Miembros
                </a></li>
                <li><a href="{{ route('membresias.index') }}" class="{{ request()->routeIs('membresias.*') ? 'active' : '' }}">
                    <span>💳</span> Membresías
                </a></li>
                <li><a href="{{ route('pagos.index') }}" class="{{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                    <span>💰</span> Pagos
                </a></li>
                <li><a href="{{ route('visitas.index') }}" class="{{ request()->routeIs('visitas.*') ? 'active' : '' }}">
                    <span>📅</span> Visitas
                </a></li>
                @if(auth()->user()->role === 'admin')
                <li><a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                    <span>👤</span> Usuarios
                </a></li>
                <li><a href="{{ route('configuracion.index') }}" class="{{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
                    <span>⚙️</span> Configuración
                </a></li>
                @endif
                <li><a href="{{ route('perfil.index') }}" class="{{ request()->routeIs('perfil.*') ? 'active' : '' }}">
                    <span>👤</span> Perfil
                </a></li>
            </ul>
            <div class="navbar-user">
                <div class="user-info">
                    <div style="font-weight: 600;">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Staff' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
