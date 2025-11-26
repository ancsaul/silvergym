@extends('layouts.app')

@section('title', 'Editar Miembro - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('miembros.show', $miembro) }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 800px;">
    <h2 class="card-title">Editar Miembro</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('miembros.update', $miembro) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $miembro->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', $miembro->apellido) }}" required>
            </div>

            <div class="form-group">
                <label for="documento">Documento *</label>
                <input type="text" class="form-control" id="documento" name="documento" value="{{ old('documento', $miembro->documento) }}" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $miembro->telefono) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $miembro->email) }}">
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $miembro->fecha_nacimiento?->format('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" id="genero" name="genero">
                    <option value="">Seleccionar...</option>
                    <option value="masculino" {{ old('genero', $miembro->genero) === 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('genero', $miembro->genero) === 'femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="otro" {{ old('genero', $miembro->genero) === 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="activo">Estado *</label>
                <select class="form-control" id="activo" name="activo" required>
                    <option value="1" {{ old('activo', $miembro->activo) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('activo', $miembro->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                @if($miembro->foto)
                    <small style="color: #666; margin-top: 5px; display: block;">Foto actual: {{ basename($miembro->foto) }}</small>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea class="form-control" id="direccion" name="direccion" rows="2">{{ old('direccion', $miembro->direccion) }}</textarea>
        </div>

        <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e0e0e0;">
            <h3 style="font-size: 18px; font-weight: 700; color: #333; margin-bottom: 20px;">
                🚨 Contacto de Emergencia
            </h3>
            <p style="font-size: 14px; color: #757575; margin-bottom: 20px;">
                Información de contacto en caso de accidente o emergencia
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="contacto_emergencia_nombre">Nombre del Contacto</label>
                    <input type="text" class="form-control" id="contacto_emergencia_nombre" name="contacto_emergencia_nombre" value="{{ old('contacto_emergencia_nombre', $miembro->contacto_emergencia_nombre) }}">
                </div>

                <div class="form-group">
                    <label for="contacto_emergencia_telefono">Teléfono</label>
                    <input type="text" class="form-control" id="contacto_emergencia_telefono" name="contacto_emergencia_telefono" value="{{ old('contacto_emergencia_telefono', $miembro->contacto_emergencia_telefono) }}">
                </div>

                <div class="form-group">
                    <label for="contacto_emergencia_relacion">Relación</label>
                    <input type="text" class="form-control" id="contacto_emergencia_relacion" name="contacto_emergencia_relacion" value="{{ old('contacto_emergencia_relacion', $miembro->contacto_emergencia_relacion) }}">
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Actualizar Miembro</button>
            <a href="{{ route('miembros.show', $miembro) }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
            <form action="{{ route('miembros.destroy', $miembro) }}" method="POST" style="margin-left: auto;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este miembro? Esta acción no se puede deshacer.')">Eliminar Miembro</button>
            </form>
        </div>
    </form>
</div>
@endsection
