@extends('layouts.app')

@section('title', 'Visitas - SilverGym')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #333;">Registro de Visitas</h1>
    <a href="{{ route('visitas.create') }}" class="btn btn-primary">+ Registrar Entrada</a>
</div>

<div class="card" style="margin-bottom: 20px;">
    <form method="GET" style="display: flex; gap: 10px; align-items: end;">
        <div class="form-group" style="margin: 0; flex: 1; max-width: 300px;">
            <label for="fecha">Filtrar por fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha', date('Y-m-d')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('visitas.index') }}" class="btn" style="background: #6c757d; color: white;">Hoy</a>
    </form>
</div>

<div class="card">
    <h3 style="margin-bottom: 20px;">Visitas del {{ request('fecha') ? \Carbon\Carbon::parse(request('fecha'))->format('d/m/Y') : 'día de hoy' }}</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Miembro</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Duración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitas as $visita)
            <tr>
                <td>{{ $visita->miembro->nombre_completo }}</td>
                <td>{{ $visita->fecha_hora_entrada->format('H:i') }}</td>
                <td>
                    @if($visita->fecha_hora_salida)
                        {{ $visita->fecha_hora_salida->format('H:i') }}
                    @else
                        <span class="badge badge-warning">En gimnasio</span>
                    @endif
                </td>
                <td>
                    @if($visita->fecha_hora_salida)
                        {{ $visita->fecha_hora_entrada->diffInMinutes($visita->fecha_hora_salida) }} min
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if(!$visita->fecha_hora_salida)
                        <form action="{{ route('visitas.salida', $visita) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Registrar Salida</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 40px;">No hay visitas registradas para esta fecha</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $visitas->links() }}
    </div>
</div>
@endsection
