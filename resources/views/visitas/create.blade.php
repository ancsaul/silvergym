@extends('layouts.app')

@section('title', 'Registrar Entrada - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('visitas.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Registrar Entrada de Miembro</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('visitas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="miembro_id">Seleccionar Miembro *</label>
            <select class="form-control" id="miembro_id" name="miembro_id" required>
                <option value="">Buscar miembro...</option>
                @foreach($miembros as $miembro)
                    <option value="{{ $miembro->id }}" {{ old('miembro_id') == $miembro->id ? 'selected' : '' }}>
                        {{ $miembro->nombre_completo }} - {{ $miembro->documento }}
                        @if($miembro->tieneMembresiaActiva())
                            ✓
                        @else
                            ⚠️ (Sin membresía activa)
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div style="background: #e3f2fd; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <p style="margin: 0; color: #1565c0; font-size: 14px;">
                ℹ️ La entrada se registrará con la hora actual. Solo los miembros con membresía activa pueden ingresar.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Registrar Entrada</button>
            <a href="{{ route('visitas.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection
