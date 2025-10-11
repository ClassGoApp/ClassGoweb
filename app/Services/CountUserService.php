<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountSetting;

class CountUserService {
    public function __construct() {

    }

    public function getUserCounts() {
        
        $studentCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->count();
        $tutorCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'tutor');
        })->count();

        $totalUsers = $studentCount + $tutorCount;
        return compact('totalUsers', 'studentCount', 'tutorCount');
    }
}