@extends('layouts.app')

@section('title', 'Crear Membresía - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('membresias.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Crear Nueva Membresía</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('membresias.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre de la Membresía *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Mensual, Trimestral, Anual">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Describe los beneficios de esta membresía...">{{ old('descripcion') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="precio">Precio *</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="duracion_dias">Duración (días) *</label>
                <input type="number" class="form-control" id="duracion_dias" name="duracion_dias" value="{{ old('duracion_dias') }}" required placeholder="30">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Crear Membresía</button>
            <a href="{{ route('membresias.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
