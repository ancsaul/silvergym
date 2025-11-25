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
        
        $ingresosHoy = Pago::whereDate('fecha_pago', now()->toDateString())->sum('monto');

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
            'ingresosHoy',
            'ultimosMiembros',
            'proximosVencimientos'
        ));
    }
}
