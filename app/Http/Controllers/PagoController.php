<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Miembro;
use App\Models\Membresia;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de fecha
        $fechaInicio = $request->input('fecha_inicio', now()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        // Query principal
        $query = Pago::with(['miembro', 'membresia', 'usuario'])
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);

        if ($request->filled('miembro_id')) {
            $query->where('miembro_id', $request->miembro_id);
        }

        if ($request->filled('membresia_id')) {
            $query->where('membresia_id', $request->membresia_id);
        }

        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        $pagos = $query->orderBy('fecha_pago', 'desc')->paginate(15);

        // Estadísticas del período
        $totalIngresos = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->sum('monto');
        $totalPagos = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])->count();

        // Pagos por membresía (incluye VISITA REGULAR cuando membresia_id es NULL)
        $pagosPorMembresia = Pago::with('membresia')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->selectRaw('membresia_id, COUNT(*) as total_pagos, SUM(monto) as total_monto')
            ->groupBy('membresia_id')
            ->orderByDesc('total_monto')
            ->get();

        // Pagos por usuario (quien registró)
        $pagosPorUsuario = Pago::with('usuario')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->selectRaw('usuario_id, COUNT(*) as total_pagos, SUM(monto) as total_monto')
            ->groupBy('usuario_id')
            ->orderByDesc('total_monto')
            ->get();

        // Miembros con mayores pagos
        $miembrosTopPagos = Pago::with('miembro')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->selectRaw('miembro_id, COUNT(*) as total_pagos, SUM(monto) as total_monto')
            ->groupBy('miembro_id')
            ->orderByDesc('total_monto')
            ->limit(10)
            ->get();

        // Lista de membresías para el filtro
        $membresias = Membresia::all();

        return view('pagos.index', compact(
            'pagos',
            'fechaInicio',
            'fechaFin',
            'totalIngresos',
            'totalPagos',
            'pagosPorMembresia',
            'pagosPorUsuario',
            'miembrosTopPagos',
            'membresias'
        ));
    }

    public function create(Request $request)
    {
        $miembros = Miembro::where('activo', true)->orderBy('nombre')->get();
        $membresias = Membresia::where('activo', true)->orderBy('nombre')->get();
        $miembroSeleccionado = $request->miembro_id;
        
        return view('pagos.create', compact('miembros', 'membresias', 'miembroSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'miembro_id' => 'required|exists:miembros,id',
            'membresia_id' => 'required|exists:membresias,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'observaciones' => 'nullable|string',
        ]);

        $membresia = Membresia::findOrFail($request->membresia_id);
        
        $fechaInicio = $request->fecha_pago;
        $fechaVencimiento = date('Y-m-d', strtotime($fechaInicio . ' + ' . $membresia->duracion_dias . ' days'));

        Pago::create([
            'miembro_id' => $request->miembro_id,
            'membresia_id' => $request->membresia_id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'fecha_inicio' => $fechaInicio,
            'fecha_vencimiento' => $fechaVencimiento,
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones,
            'usuario_id' => auth()->id(),
        ]);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load(['miembro', 'membresia', 'usuario']);
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $miembros = Miembro::where('activo', true)->orderBy('nombre')->get();
        $membresias = Membresia::where('activo', true)->orderBy('nombre')->get();
        
        return view('pagos.edit', compact('pago', 'miembros', 'membresias'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'observaciones' => 'nullable|string',
        ]);

        $pago->update($request->only(['monto', 'metodo_pago', 'observaciones']));

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado exitosamente.');
    }
}
