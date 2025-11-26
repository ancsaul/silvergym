@extends('layouts.app')

@section('title', 'Mi Perfil - SilverGym')

@section('content')
<div style="padding: 30px;">
    <div style="margin-bottom: 25px;">
        <h1 style="font-size: 32px; font-weight: bold; color: #1e88e5;">
            <i class="fas fa-user-circle"></i> Mi Perfil
        </h1>
        <p style="color: #666; margin-top: 10px;">Administra tu información personal y estadísticas de actividad.</p>
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

    <!-- Estadísticas del Usuario -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: linear-gradient(135deg, #4caf50, #45a049); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Pagos Registrados</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">{{ $totalPagosRegistrados }}</h2>
                </div>
                <i class="fas fa-receipt" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #2196f3, #1976d2); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Ingresos Gestionados</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold;">${{ number_format($totalIngresosGestionados, 2) }}</h2>
                </div>
                <i class="fas fa-dollar-sign" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #ff9800, #f57c00); padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">Rol</p>
                    <h2 style="margin: 10px 0 0 0; font-size: 32px; font-weight: bold; text-transform: uppercase;">{{ $user->role }}</h2>
                </div>
                <i class="fas fa-user-tag" style="font-size: 48px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
        <!-- Información del Perfil -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #1e88e5; padding-bottom: 10px;">
                <i class="fas fa-id-card"></i> Información Personal
            </h3>

            <div style="text-align: center; margin-bottom: 25px;">
                <div style="width: 120px; height: 120px; margin: 0 auto; background: linear-gradient(135deg, #1e88e5, #1565c0); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->username, 0, 1)) }}
                </div>
            </div>

            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <label style="display: block; color: #666; font-size: 12px; margin-bottom: 5px; font-weight: 600;">NOMBRE COMPLETO</label>
                <p style="margin: 0; color: #333; font-size: 18px; font-weight: 600;">{{ $user->name }}</p>
            </div>

            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <label style="display: block; color: #666; font-size: 12px; margin-bottom: 5px; font-weight: 600;">NOMBRE DE USUARIO</label>
                <p style="margin: 0; color: #333; font-size: 18px; font-weight: 600;">{{ $user->username }}</p>
            </div>

            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <label style="display: block; color: #666; font-size: 12px; margin-bottom: 5px; font-weight: 600;">CORREO ELECTRÓNICO</label>
                <p style="margin: 0; color: #333; font-size: 18px; font-weight: 600;">{{ $user->email }}</p>
            </div>

            <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <label style="display: block; color: #666; font-size: 12px; margin-bottom: 5px; font-weight: 600;">ROL</label>
                <p style="margin: 0; color: #333; font-size: 18px; font-weight: 600; text-transform: uppercase;">
                    @if($user->role == 'admin')
                        <i class="fas fa-user-shield" style="color: #f44336;"></i> Administrador
                    @else
                        <i class="fas fa-user" style="color: #2196f3;"></i> Staff
                    @endif
                </p>
            </div>

            <div style="padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <label style="display: block; color: #666; font-size: 12px; margin-bottom: 5px; font-weight: 600;">ESTADO</label>
                <p style="margin: 0; font-size: 18px; font-weight: 600;">
                    @if($user->is_active)
                        <span style="color: #4caf50;"><i class="fas fa-check-circle"></i> Activo</span>
                    @else
                        <span style="color: #f44336;"><i class="fas fa-times-circle"></i> Inactivo</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Editar Perfil -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #4caf50; padding-bottom: 10px;">
                <i class="fas fa-edit"></i> Editar Información
            </h3>

            <form method="POST" action="{{ route('perfil.update') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-user"></i> Nombre Completo
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('name')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('email')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <hr style="border: none; border-top: 2px solid #e0e0e0; margin: 25px 0;">

                <h4 style="color: #333; margin-bottom: 15px; font-size: 16px;">
                    <i class="fas fa-lock"></i> Cambiar Contraseña (Opcional)
                </h4>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        Contraseña Actual
                    </label>
                    <input type="password" name="current_password" 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('current_password')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        Nueva Contraseña
                    </label>
                    <input type="password" name="new_password" 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('new_password')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        Confirmar Nueva Contraseña
                    </label>
                    <input type="password" name="new_password_confirmation" 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                </div>

                <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #4caf50, #45a049); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-save"></i> Actualizar Perfil
                </button>
            </form>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 25px;">
        <h3 style="color: #333; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #ff9800; padding-bottom: 10px;">
            <i class="fas fa-history"></i> Actividad Reciente - Últimos Pagos Registrados
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Fecha</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Miembro</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #666;">Membresía</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: #666;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pagosRecientes as $pago)
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 12px;">{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding: 12px;">
                            <a href="{{ route('miembros.show', $pago->miembro) }}" style="color: #1e88e5; text-decoration: none; font-weight: 600;">
                                {{ $pago->miembro->nombre }} {{ $pago->miembro->apellidos }}
                            </a>
                        </td>
                        <td style="padding: 12px;">{{ $pago->membresia ? $pago->membresia->nombre : 'VISITA REGULAR' }}</td>
                        <td style="padding: 12px; text-align: right; font-weight: 600; color: #4caf50;">
                            ${{ number_format($pago->monto, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; text-align: center; color: #999;">
                            No hay actividad reciente
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
