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
        // Solo miembros activos con membresía vigente
        $miembros = Miembro::where('activo', true)
            ->whereHas('ultimoPago', function($query) {
                $query->where('fecha_vencimiento', '>=', now());
            })
            ->orderBy('nombre')
            ->get();
            
        return view('visitas.create', compact('miembros'));
    }

    public function store(Request $request)
    {
        // Validación según el tipo de visita
        $rules = [
            'tipo' => 'required|in:miembro,regular',
        ];

        if ($request->tipo === 'miembro') {
            $rules['miembro_id'] = 'required|exists:miembros,id';
        } else {
            $rules['nombre_visitante'] = 'required|string|max:255';
            $rules['monto'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        // Para visitas de miembro, verificar membresía activa
        if ($request->tipo === 'miembro') {
            $miembro = Miembro::findOrFail($request->miembro_id);

            if (!$miembro->tieneMembresiaActiva()) {
                return back()->with('error', 'El miembro no tiene una membresía activa. Por favor, registre un pago primero.');
            }

            // Verificar si ya tiene una visita en curso
            $visitaAbierta = Visita::where('miembro_id', $miembro->id)
                ->whereNull('fecha_hora_salida')
                ->first();

            if ($visitaAbierta) {
                return back()->with('error', 'El miembro ya tiene una visita en curso.');
            }

            Visita::create([
                'tipo' => 'miembro',
                'miembro_id' => $miembro->id,
                'fecha_hora_entrada' => now(),
            ]);

            $mensaje = 'Entrada de miembro registrada exitosamente.';
        } else {
            // Visita regular (sin membresía)
            Visita::create([
                'tipo' => 'regular',
                'nombre_visitante' => $request->nombre_visitante,
                'monto' => $request->monto,
                'fecha_hora_entrada' => now(),
            ]);

            $mensaje = 'Visita regular registrada exitosamente. Monto: $' . number_format($request->monto, 2);
        }

        return redirect()->route('visitas.index')->with('success', $mensaje);
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
