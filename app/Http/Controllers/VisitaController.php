<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Miembro;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Visita::with('miembro');

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_hora_entrada', $request->fecha);
        } else {
            $query->whereDate('fecha_hora_entrada', now()->toDateString());
        }

        $visitas = $query->orderBy('fecha_hora_entrada', 'desc')->paginate(20);

        return view('visitas.index', compact('visitas'));
    }

    public function create()
    {
        $miembros = Miembro::where('activo', true)->orderBy('nombre')->get();
        return view('visitas.create', compact('miembros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'miembro_id' => 'required|exists:miembros,id',
        ]);

        $miembro = Miembro::findOrFail($request->miembro_id);

        if (!$miembro->tieneMembresiaActiva()) {
            return back()->with('error', 'El miembro no tiene una membresía activa.');
        }

        $visitaAbierta = Visita::where('miembro_id', $miembro->id)
            ->whereNull('fecha_hora_salida')
            ->first();

        if ($visitaAbierta) {
            return back()->with('error', 'El miembro ya tiene una visita en curso.');
        }

        Visita::create([
            'miembro_id' => $miembro->id,
            'fecha_hora_entrada' => now(),
        ]);

        return redirect()->route('visitas.index')->with('success', 'Entrada registrada exitosamente.');
    }

    public function registrarEntrada(Request $request)
    {
        return $this->store($request);
    }

    public function registrarSalida(Visita $visita)
    {
        if ($visita->fecha_hora_salida) {
            return back()->with('error', 'Esta visita ya tiene registrada la salida.');
        }

        $visita->update([
            'fecha_hora_salida' => now(),
        ]);

        return back()->with('success', 'Salida registrada exitosamente.');
    }

    public function show(Visita $visita)
    {
        $visita->load('miembro');
        return view('visitas.show', compact('visita'));
    }
}
