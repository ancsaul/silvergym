<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $table = 'visitas';

    protected $fillable = [
        'miembro_id',
        'tipo',
        'nombre_visitante',
        'monto',
        'fecha_hora_entrada',
        'fecha_hora_salida',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora_entrada' => 'datetime',
            'fecha_hora_salida' => 'datetime',
            'monto' => 'decimal:2',
        ];
    }

    /**
     * Get the miembro that owns the visita.
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }

    /**
     * Check if this is a regular visit (without membership).
     */
    public function esVisitaRegular()
    {
        return $this->tipo === 'regular';
    }

    /**
     * Get the display name for the visit.
     */
    public function getNombreDisplayAttribute()
    {
        if ($this->esVisitaRegular()) {
            return $this->nombre_visitante;
        }
        
        return $this->miembro ? $this->miembro->nombre_completo : 'N/A';
    }
}
