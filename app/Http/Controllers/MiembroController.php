<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MiembroController extends Controller
{
    public function index(Request $request)
    {
        $query = Miembro::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%");
            });
        }

        $miembros = $query->with('ultimoPago.membresia')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('miembros.index', compact('miembros'));
    }

    public function create()
    {
        return view('miembros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|unique:miembros',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'username' => 'required|string|unique:miembros,username|min:4|max:255',
            'password' => 'required|string|min:6',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'foto' => 'nullable|image|max:2048',
            'contacto_emergencia_nombre' => 'nullable|string|max:255',
            'contacto_emergencia_telefono' => 'nullable|string|max:255',
            'contacto_emergencia_relacion' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['fecha_inscripcion'] = now()->toDateString();
        $data['must_change_password'] = true; // Obligar a cambiar contraseña en primer acceso

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('miembros', 'public');
        }

        $miembro = Miembro::create($data);

        // Redirigir a página de opciones después de crear el miembro
        return redirect()->route('miembros.opciones', $miembro)->with('success', 'Miembro registrado exitosamente. Usuario: ' . $miembro->username);
    }

    public function show(Miembro $miembro)
    {
        $miembro->load(['pagos.membresia', 'visitas']);
        return view('miembros.show', compact('miembro'));
    }

    public function edit(Miembro $miembro)
    {
        return view('miembros.edit', compact('miembro'));
    }

    public function update(Request $request, Miembro $miembro)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|unique:miembros,documento,' . $miembro->id,
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'activo' => 'required|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($miembro->foto) {
                Storage::disk('public')->delete($miembro->foto);
            }
            $data['foto'] = $request->file('foto')->store('miembros', 'public');
        }

        $miembro->update($data);

        return redirect()->route('miembros.index')->with('success', 'Miembro actualizado exitosamente.');
    }

    public function destroy(Miembro $miembro)
    {
        if ($miembro->foto) {
            Storage::disk('public')->delete($miembro->foto);
        }

        $miembro->delete();

        return redirect()->route('miembros.index')->with('success', 'Miembro eliminado exitosamente.');
    }

    public function generarCredencial(Miembro $miembro)
    {
        return view('miembros.credencial', compact('miembro'));
    }

    public function opciones(Miembro $miembro)
    {
        return view('miembros.opciones', compact('miembro'));
    }
}
