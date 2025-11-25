<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@silvergym.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'must_change_password' => true,
            'is_active' => true,
        ]);

        // Crear usuario staff por defecto
        User::create([
            'name' => 'Personal',
            'username' => 'staff',
            'email' => 'staff@silvergym.com',
            'password' => bcrypt('staff123'),
            'role' => 'staff',
            'must_change_password' => true,
            'is_active' => true,
        ]);

        // Crear membresías por defecto
        \App\Models\Membresia::create([
            'nombre' => 'Mensual',
            'descripcion' => 'Membresía válida por 30 días',
            'precio' => 50.00,
            'duracion_dias' => 30,
            'activo' => true,
        ]);

        \App\Models\Membresia::create([
            'nombre' => 'Trimestral',
            'descripcion' => 'Membresía válida por 90 días con descuento',
            'precio' => 135.00,
            'duracion_dias' => 90,
            'activo' => true,
        ]);

        \App\Models\Membresia::create([
            'nombre' => 'Anual',
            'descripcion' => 'Membresía válida por 365 días - Mejor precio',
            'precio' => 480.00,
            'duracion_dias' => 365,
            'activo' => true,
        ]);
    }
}
