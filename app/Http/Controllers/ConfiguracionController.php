<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Cargar configuración desde archivo o base de datos
        $config = $this->getConfig();
        
        return view('configuracion.index', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre_gimnasio' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $config = [
            'nombre_gimnasio' => $request->nombre_gimnasio,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ];

        // Manejar el logo
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            $oldConfig = $this->getConfig();
            if (isset($oldConfig['logo']) && Storage::disk('public')->exists($oldConfig['logo'])) {
                Storage::disk('public')->delete($oldConfig['logo']);
            }

            // Guardar nuevo logo
            $logoPath = $request->file('logo')->store('configuracion', 'public');
            $config['logo'] = $logoPath;
        } else {
            // Mantener logo existente
            $oldConfig = $this->getConfig();
            if (isset($oldConfig['logo'])) {
                $config['logo'] = $oldConfig['logo'];
            }
        }

        // Guardar configuración en archivo JSON
        Storage::put('config/gimnasio.json', json_encode($config, JSON_PRETTY_PRINT));

        return redirect()->route('configuracion.index')->with('success', 'Configuración actualizada exitosamente.');
    }

    private function getConfig()
    {
        if (Storage::exists('config/gimnasio.json')) {
            return json_decode(Storage::get('config/gimnasio.json'), true);
        }

        // Configuración por defecto
        return [
            'nombre_gimnasio' => 'SilverGym',
            'telefono' => '(000) 000-0000',
            'direccion' => 'Calle Principal #123, Ciudad',
            'logo' => null,
        ];
    }
}
