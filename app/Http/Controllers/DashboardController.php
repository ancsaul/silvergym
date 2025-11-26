<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembro;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Visita;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Verificar si debe cambiar contraseña
        if (auth()->user()->must_change_password) {
            return redirect()->route('password.change');
        }

        // Estadísticas generales
        $totalMiembros = Miembro::where('activo', true)->count();
        $miembrosActivos = Miembro::whereHas('ultimoPago', function($query) {
            $query->where('fecha_vencimiento', '>=', now()->toDateString());
        })->where('activo', true)->count();

        $visitasHoy = Visita::whereDate('fecha_hora_entrada', now()->toDateString())->count();
        $visitasSemana = Visita::whereBetween('fecha_hora_entrada', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $visitasMes = Visita::whereMonth('fecha_hora_entrada', now()->month)
            ->whereYear('fecha_hora_entrada', now()->year)
            ->count();
        
        $ingresosHoy = Pago::whereDate('fecha_pago', now()->toDateString())->sum('monto');
        $ingresosSemana = Pago::whereBetween('fecha_pago', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->sum('monto');
        $ingresosMes = Pago::whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->sum('monto');

        // Visitas por hora del día
        $visitasPorHora = Visita::whereDate('fecha_hora_entrada', now()->toDateString())
            ->selectRaw('HOUR(fecha_hora_entrada) as hora, COUNT(*) as total')
            ->groupBy('hora')
            ->orderBy('hora')
            ->get()
            ->pluck('total', 'hora')
            ->toArray();

        // Visitas por día de la semana
        $visitasPorDiaSemana = Visita::whereBetween('fecha_hora_entrada', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])
        ->selectRaw('DAYOFWEEK(fecha_hora_entrada) as dia, COUNT(*) as total')
        ->groupBy('dia')
        ->orderBy('dia')
        ->get()
        ->pluck('total', 'dia')
        ->toArray();

        // Pagos por día del mes
        $pagosPorDia = Pago::whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->selectRaw('DAY(fecha_pago) as dia, SUM(monto) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->pluck('total', 'dia')
            ->toArray();

        // Últimos miembros registrados
        $ultimosMiembros = Miembro::with('ultimoPago.membresia')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Próximos vencimientos (7 días)
        $proximosVencimientos = Pago::with(['miembro', 'membresia'])
            ->whereBetween('fecha_vencimiento', [
                now()->toDateString(),
                now()->addDays(7)->toDateString()
            ])
            ->whereHas('miembro', function($query) {
                $query->where('activo', true);
            })
            ->orderBy('fecha_vencimiento', 'asc')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalMiembros',
            'miembrosActivos',
            'visitasHoy',
            'visitasSemana',
            'visitasMes',
            'ingresosHoy',
            'ingresosSemana',
            'ingresosMes',
            'visitasPorHora',
            'visitasPorDiaSemana',
            'pagosPorDia',
            'ultimosMiembros',
            'proximosVencimientos'
        ));
    }
}
