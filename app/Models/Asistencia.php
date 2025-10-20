<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'personal_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime:H:i',
        'hora_salida' => 'datetime:H:i',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
