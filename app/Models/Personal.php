<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = [
            'nombre',
            'apellido',
            'correo',
            'password',
            'celular',
            'direccion',
            'fecha_nacimiento',
            'genero',
            'foto_perfil',
            'puesto',
            'salario',
            'estado',
            'departamento',
            'fecha_contratacion',
    ];
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_contratacion' => 'date',
    ];
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
