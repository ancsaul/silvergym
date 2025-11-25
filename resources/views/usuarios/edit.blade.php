@extends('layouts.app')

@section('title', 'Editar Usuario - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('usuarios.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Editar Usuario</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre Completo *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Usuario *</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $usuario->username) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" class="form-control" id="password" name="password">
            <small style="color: #666;">Si cambias la contraseña, el usuario deberá cambiarla en el próximo inicio de sesión.</small>
        </div>

        <div class="form-group">
            <label for="role">Rol *</label>
            <select class="form-control" id="role" name="role" required>
                <option value="admin" {{ old('role', $usuario->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="staff" {{ old('role', $usuario->role) === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Estado *</label>
            <select class="form-control" id="is_active" name="is_active" required>
                <option value="1" {{ old('is_active', $usuario->is_active) == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('is_active', $usuario->is_active) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
