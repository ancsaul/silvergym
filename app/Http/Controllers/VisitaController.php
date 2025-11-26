<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Miembro;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de fecha
        $fechaInicio = $request->input('fecha_inicio', now()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        // Query principal
        $query = Visita::with('miembro')
            ->whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $visitas = $query->orderBy('fecha_hora_entrada', 'desc')->paginate(20);

        // Estadísticas del período
        $totalVisitas = Visita::whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])->count();
        $visitasMiembros = Visita::where('tipo', 'miembro')
            ->whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->count();
        $visitasRegulares = Visita::where('tipo', 'regular')
            ->whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->count();
        $ingresoRegulares = Visita::where('tipo', 'regular')
            ->whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->sum('monto');

        // Miembros con más visitas
        $miembrosTopVisitas = Visita::where('tipo', 'miembro')
            ->with('miembro')
            ->whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->selectRaw('miembro_id, COUNT(*) as total_visitas')
            ->groupBy('miembro_id')
            ->orderByDesc('total_visitas')
            ->limit(10)
            ->get();

        // Visitas por día de la semana
        $visitasPorDia = Visita::whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->selectRaw('DAYOFWEEK(fecha_hora_entrada) as dia, COUNT(*) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total', 'dia')
            ->toArray();

        // Visitas por hora del día
        $visitasPorHora = Visita::whereBetween('fecha_hora_entrada', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->selectRaw('HOUR(fecha_hora_entrada) as hora, COUNT(*) as total')
            ->groupBy('hora')
            ->orderBy('hora')
            ->pluck('total', 'hora')
            ->toArray();

        return view('visitas.index', compact(
            'visitas',
            'fechaInicio',
            'fechaFin',
            'totalVisitas',
            'visitasMiembros',
            'visitasRegulares',
            'ingresoRegulares',
            'miembrosTopVisitas',
            'visitasPorDia',
            'visitasPorHora'
        ));
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
