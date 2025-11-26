@extends('layouts.app')

@section('title', 'Nuevo Miembro - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('miembros.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 800px;">
    <h2 class="card-title">Registrar Nuevo Miembro</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('miembros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
            </div>

            <div class="form-group">
                <label for="documento">Documento *</label>
                <input type="text" class="form-control" id="documento" name="documento" value="{{ old('documento') }}" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <select class="form-control" id="genero" name="genero">
                    <option value="">Seleccionar...</option>
                    <option value="masculino" {{ old('genero') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('genero') === 'femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="otro" {{ old('genero') === 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea class="form-control" id="direccion" name="direccion" rows="2">{{ old('direccion') }}</textarea>
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
                    <input type="text" class="form-control" id="contacto_emergencia_nombre" name="contacto_emergencia_nombre" value="{{ old('contacto_emergencia_nombre') }}" placeholder="Ej: María García">
                </div>

                <div class="form-group">
                    <label for="contacto_emergencia_telefono">Teléfono</label>
                    <input type="text" class="form-control" id="contacto_emergencia_telefono" name="contacto_emergencia_telefono" value="{{ old('contacto_emergencia_telefono') }}" placeholder="Ej: 555-1234">
                </div>

                <div class="form-group">
                    <label for="contacto_emergencia_relacion">Relación</label>
                    <input type="text" class="form-control" id="contacto_emergencia_relacion" name="contacto_emergencia_relacion" value="{{ old('contacto_emergencia_relacion') }}" placeholder="Ej: Madre, Esposo">
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Registrar Miembro</button>
            <a href="{{ route('miembros.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
