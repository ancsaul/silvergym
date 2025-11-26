@extends('layouts.app')

@section('title', 'Miembros - SilverGym')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #333;">Gestión de Miembros</h1>
    <a href="{{ route('miembros.create') }}" class="btn btn-primary">+ Nuevo Miembro</a>
</div>

<div class="card" style="margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, apellido o documento..." value="{{ request('search') }}" style="max-width: 400px;">
        <button type="submit" class="btn btn-primary">Buscar</button>
        @if(request('search'))
            <a href="{{ route('miembros.index') }}" class="btn" style="background: #6c757d; color: white;">Limpiar</a>
        @endif
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Estado Membresía</th>
                <th>Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($miembros as $miembro)
            <tr>
                <td>{{ $miembro->nombre_completo }}</td>
                <td>{{ $miembro->documento }}</td>
                <td>{{ $miembro->telefono ?? '-' }}</td>
                <td>
                    @if($miembro->tieneMembresiaActiva())
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                    @if($miembro->ultimoPago)
                        {{ $miembro->ultimoPago->fecha_vencimiento->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <a href="{{ route('miembros.show', $miembro) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;" title="Ver detalles">👁️ Ver</a>
                        <a href="{{ route('miembros.edit', $miembro) }}" class="btn" style="background: #fb8c00; color: white; padding: 6px 12px; font-size: 12px;" title="Editar">✏️ Editar</a>
                        <a href="{{ route('miembros.credencial', $miembro) }}" class="btn" style="background: #8e24aa; color: white; padding: 6px 12px; font-size: 12px;" title="Imprimir credencial">🎫</a>
                        <a href="{{ route('pagos.create') }}?miembro_id={{ $miembro->id }}" class="btn btn-success" style="padding: 6px 12px; font-size: 12px;" title="Registrar pago">💰</a>
                        <form action="{{ route('miembros.destroy', $miembro) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('¿Estás seguro de eliminar este miembro?')" title="Eliminar">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999; padding: 40px;">
                    @if(request('search'))
                        No se encontraron miembros con los criterios de búsqueda.
                    @else
                        No hay miembros registrados
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $miembros->links() }}
    </div>
</div>
@endsection
