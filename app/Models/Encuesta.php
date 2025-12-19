<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    // 1. Avisamos a Laravel que la tabla se llama 'encuesta' (en singular)
    protected $table = 'encuesta';

    // 2. "Mass Assignment": Lista blanca de campos que permitimos guardar
    protected $fillable = [
        'Question_1',
        'Question_2',
        'Question_3',
        'Contact',
        'IdUser',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'IdUser', 'id');
    }
}