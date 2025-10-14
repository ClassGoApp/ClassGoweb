<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conferences extends Model
{
    protected $fillable = [
        'name',
        'description',
        'video_url',
        'start_datetime',
        'end_datetime',
        'ability',
        'enrolled_students',
        'user_id',
        'is_free'
    ];
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
    ];
    // Tutor propietario de la conferencia
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Estudiantes inscritos (filtramos por rol=student)
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conference_student', 'conference_id', 'student_id')
            ->where('users.role', 'student'); // funciona porque belongsToMany hace join con users
    }
}
