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
        Schema::table('miembros', function (Blueprint $table) {
            $table->string('contacto_emergencia_nombre')->nullable()->after('direccion');
            $table->string('contacto_emergencia_telefono')->nullable()->after('contacto_emergencia_nombre');
            $table->string('contacto_emergencia_relacion')->nullable()->after('contacto_emergencia_telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->dropColumn(['contacto_emergencia_nombre', 'contacto_emergencia_telefono', 'contacto_emergencia_relacion']);
        });
    }
};
