<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;

class PortalMiembroController extends Controller
{
    public function index()
    {
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $miembro = Miembro::where('username', $request->username)->first();

        if (!$miembro || !\Hash::check($request->password, $miembro->password)) {
            return back()->with('error', 'Usuario o contraseña incorrectos.');
        }

        if (!$miembro->activo) {
            return back()->with('error', 'Tu cuenta está inactiva. Contacta al gimnasio.');
        }

        // Verificar si debe cambiar contraseña
        if ($miembro->must_change_password) {
            session(['miembro_temp_id' => $miembro->id]);
            return redirect()->route('portal.change-password');
        }

        // Guardar sesión del miembro
        session(['miembro_id' => $miembro->id]);

        return redirect()->route('portal.show', $miembro->id);
    }

    public function showChangePassword()
    {
        if (!session('miembro_temp_id')) {
            return redirect()->route('portal.index');
        }

        return view('portal.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $miembroId = session('miembro_temp_id');
        if (!$miembroId) {
            return redirect()->route('portal.index');
        }

        $miembro = Miembro::findOrFail($miembroId);
        $miembro->password = $request->new_password;
        $miembro->must_change_password = false;
        $miembro->save();

        session()->forget('miembro_temp_id');
        session(['miembro_id' => $miembro->id]);

        return redirect()->route('portal.show', $miembro->id)->with('success', '¡Contraseña actualizada exitosamente!');
    }

    public function logout()
    {
        session()->forget('miembro_id');
        return redirect()->route('portal.index')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function show($id)
    {
        // Verificar que el miembro tenga sesión activa
        if (session('miembro_id') != $id) {
            return redirect()->route('portal.index')->with('error', 'Debes iniciar sesión para ver esta información.');
        }

        $miembro = Miembro::with(['pagos.membresia', 'visitas'])->findOrFail($id);
        
        // Obtener el último pago (membresía activa)
        $ultimoPago = $miembro->ultimoPago;
        
        // Calcular días restantes
        $diasRestantes = null;
        $membresiaActiva = false;
        
        if ($ultimoPago && $ultimoPago->fecha_vencimiento) {
            $fechaVencimiento = \Carbon\Carbon::parse($ultimoPago->fecha_vencimiento);
            $hoy = \Carbon\Carbon::now();
            
            if ($fechaVencimiento->gte($hoy)) {
                $diasRestantes = $hoy->diffInDays($fechaVencimiento, false);
                $membresiaActiva = true;
            } else {
                $diasRestantes = $hoy->diffInDays($fechaVencimiento, false); // Será negativo
            }
        }
        
        // Historial de pagos
        $pagos = $miembro->pagos()->orderBy('fecha_pago', 'desc')->get();
        
        // Historial de visitas (últimos 30 días)
        $visitas = $miembro->visitas()
            ->where('fecha_hora_entrada', '>=', now()->subDays(30))
            ->orderBy('fecha_hora_entrada', 'desc')
            ->get();
        
        // Total de visitas este mes
        $visitasEsteMes = $miembro->visitas()
            ->whereYear('fecha_hora_entrada', now()->year)
            ->whereMonth('fecha_hora_entrada', now()->month)
            ->count();
        
        return view('portal.miembro', compact(
            'miembro',
            'ultimoPago',
            'diasRestantes',
            'membresiaActiva',
            'pagos',
            'visitas',
            'visitasEsteMes'
        ));
    }
}
