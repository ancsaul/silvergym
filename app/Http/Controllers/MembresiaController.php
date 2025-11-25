<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{
    public function index()
    {
        $membresias = Membresia::orderBy('created_at', 'desc')->get();
        return view('membresias.index', compact('membresias'));
    }

    public function create()
    {
        return view('membresias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_dias' => 'required|integer|min:1',
        ]);

        Membresia::create($request->all());

        return redirect()->route('membresias.index')->with('success', 'Membresía creada exitosamente.');
    }

    public function show(Membresia $membresia)
    {
        $membresia->load('pagos.miembro');
        return view('membresias.show', compact('membresia'));
    }

    public function edit(Membresia $membresia)
    {
        return view('membresias.edit', compact('membresia'));
    }

    public function update(Request $request, Membresia $membresia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_dias' => 'required|integer|min:1',
            'activo' => 'required|boolean',
        ]);

        $membresia->update($request->all());

        return redirect()->route('membresias.index')->with('success', 'Membresía actualizada exitosamente.');
    }

    public function destroy(Membresia $membresia)
    {
        if ($membresia->pagos()->count() > 0) {
            return redirect()->route('membresias.index')->with('error', 'No se puede eliminar una membresía con pagos asociados.');
        }

        $membresia->delete();

        return redirect()->route('membresias.index')->with('success', 'Membresía eliminada exitosamente.');
    }
}
