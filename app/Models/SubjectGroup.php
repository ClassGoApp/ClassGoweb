<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectGroup extends Model {
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public $fillable  = [
        'id', 
        'name', 
        'description', 
        'status',
        'id_padre', // nuevo atributo agregado 
        'deleted_at',
    ];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_subject_groups');
    }

    public function subjects(): HasMany {
        return $this->hasMany(Subject::class);
    }
    /**
     * 🔹 Relación jerárquica: grupo padre
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo(SubjectGroup::class, 'id_padre');
    }

    /**
     * 🔹 Relación jerárquica: subgrupos hijos
     */
    public function hijos(): HasMany
    {
        return $this->hasMany(SubjectGroup::class, 'id_padre');
    }

}
