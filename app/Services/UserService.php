<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountSetting;
use App\Models\Rating;

class UserService {

    public $user;

    public function __construct($user = null) {
        $this->user = $user;
    }

    public function addToFavourite($favouriteUserId) {
        $this->user?->favouriteUsers()->attach($favouriteUserId);
    }

    public function removeFromFavourite($favouriteUserId) {
        $this->user?->favouriteUsers()->detach($favouriteUserId);
    }

    public function removeFavouriteUser($favouriteUserId) {
        if ($this->user) {
            $this->user->favouriteUsers()->detach($favouriteUserId);
        }
    }

    public function getFavouriteUsers() {
        if (!$this->user) {
            return collect(); // Devolver una colección vacía si no hay usuario
        }
        return $this->user->favouriteUsers();
    }

    public function isFavouriteUser($userId) {
        return $this->user?->favouriteUsers()?->whereFavouriteUserId($userId)?->exists() ?? false;
    }

    public function setUserPassword(string $password): void {
        if ($this->user) {
            $hashedPassword = Hash::make($password);
            $this->user->update(['password' => $hashedPassword]);
        }
    }

    public function getAccountSetting($key = null)
    {

     $this->user = Auth::user();   
    return $this->user->accountSetting()
        ->when($key, function($query, $key) {
            return $query->where('meta_key', $key)->pluck('meta_value', 'meta_key');
        }, function($query) {
            return $query->pluck('meta_value', 'meta_key');
        });
    }


    public function setAccountSetting($key, $value)
    {
        // Usar el usuario del constructor o Auth::user() como fallback
        $user = $this->user ?: Auth::user();
        
        if (!$user) {
            throw new \Exception('No hay usuario disponible para guardar la configuración');
        }
        
        // Buscamos un registro existente que pertenezca a este usuario con esa meta_key
        $setting = $user->accountSetting()->where('meta_key', $key)->first();

        if ($setting) {
            // Si existe, simplemente actualizamos el valor
            $setting->meta_value = $value;
            $setting->save();
        } else {
            // Si no existe, usamos el método create() en la relación.
            // Esto asignará automáticamente el user_id correcto.
            $user->accountSetting()->create([
                'meta_key' => $key,
                'meta_value' => $value
            ]);
        }
    }

    public function getTutorRatings($userId, $rating = null)
    {
        $query = Rating::with([
            'profile.user.address.country:id,name,short_code'
        ])->where('tutor_id', $userId);

        if ($rating !== null) {
            $query->where('rating', $rating);
        }
        return $query->paginate(10);
    }

    public function getUserCounts()
    {
        // Usa el modelo User directamente en el método para las consultas.
        $totalUsers = User::count();
        $studentCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'estudiante');
        })->count();
        $tutorCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'tutor');
        })->count();

        return [
            'total_users' => $totalUsers,
            'student_count' => $studentCount,
            'tutor_count' => $tutorCount,
        ];
    }




}
