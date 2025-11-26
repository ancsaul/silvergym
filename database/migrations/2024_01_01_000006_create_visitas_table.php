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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->nullable()->constrained('miembros')->onDelete('cascade');
            $table->enum('tipo', ['miembro', 'regular'])->default('miembro');
            $table->string('nombre_visitante')->nullable(); // Para visitas regulares
            $table->decimal('monto', 10, 2)->nullable(); // Costo de visita regular
            $table->dateTime('fecha_hora_entrada');
            $table->dateTime('fecha_hora_salida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
