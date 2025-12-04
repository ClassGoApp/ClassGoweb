<?php

namespace App\Livewire;

use App\Models\FavouriteUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SaveButton extends Component
{
    public $tutorId;
    public $isFavorite = false;

    public function mount($tutorId)
    {
        $this->tutorId = $tutorId;
        $this->checkIfFavorite();
    }

    public function checkIfFavorite()
    {
        if (Auth::check()) {
            $this->isFavorite = FavouriteUser::where('user_id', Auth::id())
                ->where('favourite_user_id', $this->tutorId)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            // Redireccionar al login si el usuario no está autenticado
            return redirect()->route('login');
        }

        if ($this->isFavorite) {
            // Eliminar de favoritos
            FavouriteUser::where('user_id', Auth::id())
                ->where('favourite_user_id', $this->tutorId)
                ->delete();
        } else {
            // Agregar a favoritos
            FavouriteUser::create([
                'user_id' => Auth::id(),
                'favourite_user_id' => $this->tutorId
            ]);
        }

        $this->isFavorite = !$this->isFavorite;
    }

    public function render()
    {
        return view('livewire.save-button');
    }
}
