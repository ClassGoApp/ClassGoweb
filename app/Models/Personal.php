<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personal extends Model
{
    protected $fillable = [
            'nombre',
            'apellido',
            'direccion',
            'fecha_nacimiento',
            'genero',
            'foto_perfil',
            'puesto',
            'salario',
            'estado',
            'departamento',
            'fecha_contratacion',
            'user_id',
    ];
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_contratacion' => 'date',
    ];
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

     public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
