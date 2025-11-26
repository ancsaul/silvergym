<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('documento')->unique();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->text('direccion')->nullable();
            $table->string('foto')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->date('fecha_inscripcion');
            $table->boolean('activo')->default(true);
            
            // Información de contacto de emergencia
            $table->string('contacto_emergencia_nombre')->nullable();
            $table->string('contacto_emergencia_telefono')->nullable();
            $table->string('contacto_emergencia_relacion')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
