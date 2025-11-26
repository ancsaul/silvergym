@extends('layouts.app')

@section('title', 'Crear Usuario - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('usuarios.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Crear Nuevo Usuario</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre Completo *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="username">Usuario *</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña *</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <small style="color: #666;">Mínimo 8 caracteres. El usuario deberá cambiarla en el primer inicio de sesión.</small>
        </div>

        <div class="form-group">
            <label for="role">Rol *</label>
            <select class="form-control" id="role" name="role" required>
                <option value="">Seleccionar...</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="miembro" {{ old('role') === 'miembro' ? 'selected' : '' }}>Miembro</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
