@extends('layouts.app')

@section('title', 'Usuarios - SilverGym')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #333;">Gestión de Usuarios</h1>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->username }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <span class="badge {{ $usuario->role === 'admin' ? 'badge-success' : 'badge-warning' }}">
                        {{ $usuario->role === 'admin' ? 'Administrador' : 'Staff' }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $usuario->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $usuario->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Editar</a>
                    @if($usuario->id !== auth()->id())
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999; padding: 40px;">No hay usuarios registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
