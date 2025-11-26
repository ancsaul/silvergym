@extends('layouts.app')

@section('title', 'Registrar Pago - SilverGym')

@section('content')
<div style="margin-bottom: 30px;">
    <a href="{{ route('pagos.index') }}" class="btn" style="background: #6c757d; color: white;">← Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <h2 class="card-title">Registrar Nuevo Pago</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pagos.store') }}" method="POST" id="pagoForm">
        @csrf

        <div class="form-group">
            <label for="miembro_id">Miembro *</label>
            <select class="form-control" id="miembro_id" name="miembro_id" required>
                <option value="">Seleccionar miembro...</option>
                @foreach($miembros as $miembro)
                    <option value="{{ $miembro->id }}" {{ (old('miembro_id', $miembroSeleccionado ?? null) == $miembro->id) ? 'selected' : '' }}>
                        {{ $miembro->nombre_completo }} - {{ $miembro->documento }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="membresia_id">Membresía *</label>
            <select class="form-control" id="membresia_id" name="membresia_id" required>
                <option value="">Seleccionar membresía...</option>
                @foreach($membresias as $membresia)
                    <option 
                        value="{{ $membresia->id }}" 
                        data-precio="{{ $membresia->precio }}"
                        data-duracion="{{ $membresia->duracion_dias }}"
                        {{ old('membresia_id') == $membresia->id ? 'selected' : '' }}
                    >
                        {{ $membresia->nombre }} - ${{ number_format($membresia->precio, 2) }} ({{ $membresia->duracion_dias }} días)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="monto">Monto *</label>
            <input type="number" step="0.01" class="form-control" id="monto" name="monto" value="{{ old('monto') }}" required>
        </div>

        <div class="form-group">
            <label for="fecha_pago">Fecha de Pago *</label>
            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="metodo_pago">Método de Pago *</label>
            <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                <option value="">Seleccionar...</option>
                <option value="efectivo" {{ old('metodo_pago') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="tarjeta" {{ old('metodo_pago') === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                <option value="transferencia" {{ old('metodo_pago') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
            </select>
        </div>

        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
            <a href="{{ route('pagos.index') }}" class="btn" style="background: #6c757d; color: white;">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('membresia_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const precio = option.getAttribute('data-precio');
        if (precio) {
            document.getElementById('monto').value = precio;
        }
    });
</script>
@endsection
