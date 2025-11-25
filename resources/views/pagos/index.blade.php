@extends('layouts.app')

@section('title', 'Pagos - SilverGym')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="color: #333;">Gestión de Pagos</h1>
    <a href="{{ route('pagos.create') }}" class="btn btn-primary">+ Registrar Pago</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Miembro</th>
                <th>Membresía</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
            <tr>
                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                <td>{{ $pago->miembro->nombre_completo }}</td>
                <td>{{ $pago->membresia->nombre }}</td>
                <td>${{ number_format($pago->monto, 2) }}</td>
                <td>
                    <span class="badge badge-success">{{ ucfirst($pago->metodo_pago) }}</span>
                </td>
                <td>{{ $pago->fecha_vencimiento->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('pagos.show', $pago) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Ver</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #999; padding: 40px;">No hay pagos registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $pagos->links() }}
    </div>
</div>
@endsection
