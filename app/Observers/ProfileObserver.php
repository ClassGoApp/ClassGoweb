<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Str;

class ProfileObserver {
    /**
     * Handle the Profile "creating" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function saving(Profile $profile) {
        // Regeneramos el slug a partir del nombre, igual que siempre.
        $base = Str::slug(trim(($profile->first_name ?? '') . ' ' . ($profile->last_name ?? '')));

        // Caso crítico: si el nombre no translitera a ASCII (chino, emoji,
        // símbolos) Str::slug devuelve '' y el slug quedaba vacío. Con
        // slug vacío, route('tutor', ['slug' => '']) lanza
        // UrlGenerationException ("Missing required parameter ... slug") y
        // tumba toda la página (ej. /buscar). Usamos un respaldo estable.
        if ($base === '') {
            $base = 'tutor-' . ($profile->user_id ?: ($profile->id ?? '') ?: 'perfil');
        }

        $profile->slug = $this->uniqueSlug($base, $profile->id);
    }

    /**
     * Devuelve $base, o $base-1, $base-2, ... si ya está tomado por otro perfil.
     *
     * Nota: el contador anterior usaba rtrim('-' . $i) que con $i = 0 recortaba
     * también los '0' finales del slug (p. ej. "tutor-10" -> "tutor-1-1").
     */
    protected function uniqueSlug($slug, $profileId = null) {
        $base   = $slug;
        $suffix = 1;

        while (Profile::whereSlug($slug)->where('id', '!=', $profileId)->exists()) {
            $slug   = $base . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
