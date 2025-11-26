<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;

    protected $table = 'miembros';

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'telefono',
        'email',
        'fecha_nacimiento',
        'direccion',
        'foto',
        'genero',
        'fecha_inscripcion',
        'activo',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'contacto_emergencia_relacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'fecha_inscripcion' => 'date',
            'activo' => 'boolean',
        ];
    }

    /**
     * Get the pagos for the miembro.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'miembro_id');
    }

    /**
     * Get the visitas for the miembro.
     */
    public function visitas()
    {
        return $this->hasMany(Visita::class, 'miembro_id');
    }

    /**
     * Get the ultimo pago for the miembro.
     */
    public function ultimoPago()
    {
        return $this->hasOne(Pago::class, 'miembro_id')->latestOfMany('fecha_pago');
    }

    /**
     * Get the nombre completo.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Check if the miembro has an active membership.
     */
    public function tieneMembresiaActiva()
    {
        $ultimoPago = $this->ultimoPago;
        
        if (!$ultimoPago) {
            return false;
        }

        return $ultimoPago->fecha_vencimiento >= now()->toDateString();
    }
}
