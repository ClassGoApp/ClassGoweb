<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\UserSubjectGroupSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model {
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public $fillable  = [
        'id', 'name', 'description', 'status', 'deleted_at', 'subject_group_id'
    ];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }

    public function subjectGroups()
    {
        return $this->hasMany(UserSubjectGroupSubject::class);
    }

    public function group()
    {
        return $this->belongsTo(SubjectGroup::class, 'subject_group_id');
    }

    public function userSubjects()
    {
        return $this->hasMany(UserSubject::class);
    }

}
