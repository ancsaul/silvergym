<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Estadísticas del usuario
        $totalPagosRegistrados = Pago::where('usuario_id', $user->id)->count();
        $totalIngresosGestionados = Pago::where('usuario_id', $user->id)->sum('monto');
        
        // Actividad reciente - últimos pagos registrados
        $pagosRecientes = Pago::where('usuario_id', $user->id)
            ->with(['miembro', 'membresia'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('perfil.index', compact('user', 'totalPagosRegistrados', 'totalIngresosGestionados', 'pagosRecientes'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        // Actualizar nombre y email
        $user->name = $request->name;
        $user->email = $request->email;

        // Cambiar contraseña si se proporciona
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'La contraseña actual es incorrecta.');
            }
            
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado exitosamente.');
    }
}
