@extends('layouts.app')

@section('title', 'Membresías - SilverGym')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #333;">Gestión de Membresías</h1>
    <a href="{{ route('membresias.create') }}" class="btn btn-primary">+ Nueva Membresía</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Duración</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($membresias as $membresia)
            <tr>
                <td>{{ $membresia->nombre }}</td>
                <td>${{ number_format($membresia->precio, 2) }}</td>
                <td>{{ $membresia->duracion_dias }} días</td>
                <td>
                    <span class="badge {{ $membresia->activo ? 'badge-success' : 'badge-danger' }}">
                        {{ $membresia->activo ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('membresias.edit', $membresia) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Editar</a>
                    <form action="{{ route('membresias.destroy', $membresia) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('¿Estás seguro de eliminar esta membresía?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">No hay membresías registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
