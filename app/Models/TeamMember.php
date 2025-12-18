<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    // 1. Especificamos la tabla
    protected $table = 'team_members';

    // 2. Definimos los campos que se pueden llenar (Mass Assignment)
    protected $fillable = [
        'name',
        'last_name',
        'role',
        'order',
        'platform',
        'platform_link',
        'photo',
        'status',
    ];
}