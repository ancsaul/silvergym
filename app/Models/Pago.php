<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'miembro_id',
        'membresia_id',
        'monto',
        'fecha_pago',
        'fecha_inicio',
        'fecha_vencimiento',
        'metodo_pago',
        'observaciones',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_pago' => 'date',
            'fecha_inicio' => 'date',
            'fecha_vencimiento' => 'date',
        ];
    }

    /**
     * Get the miembro that owns the pago.
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }

    /**
     * Get the membresia that owns the pago.
     */
    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'membresia_id');
    }

    /**
     * Get the usuario that owns the pago.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
