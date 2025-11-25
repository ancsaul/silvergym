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
        'fecha_hora_entrada',
        'fecha_hora_salida',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora_entrada' => 'datetime',
            'fecha_hora_salida' => 'datetime',
        ];
    }

    /**
     * Get the miembro that owns the visita.
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }
}
