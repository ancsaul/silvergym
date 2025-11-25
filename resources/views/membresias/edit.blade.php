@extends('layouts.app')

@section('title', 'Editar Membresía - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('membresias.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Editar Membresía</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('membresias.update', $membresia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre de la Membresía *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $membresia->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $membresia->descripcion) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="precio">Precio *</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $membresia->precio) }}" required>
            </div>

            <div class="form-group">
                <label for="duracion_dias">Duración (días) *</label>
                <input type="number" class="form-control" id="duracion_dias" name="duracion_dias" value="{{ old('duracion_dias', $membresia->duracion_dias) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="activo">Estado *</label>
            <select class="form-control" id="activo" name="activo" required>
                <option value="1" {{ old('activo', $membresia->activo) == 1 ? 'selected' : '' }}>Activa</option>
                <option value="0" {{ old('activo', $membresia->activo) == 0 ? 'selected' : '' }}>Inactiva</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Actualizar Membresía</button>
            <a href="{{ route('membresias.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
