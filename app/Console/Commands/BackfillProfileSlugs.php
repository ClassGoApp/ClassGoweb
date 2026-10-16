<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;

class BackfillProfileSlugs extends Command
{
    protected $signature = 'profiles:backfill-slugs {--dry-run : Solo listar los perfiles con slug vacío, sin modificar nada}';

    protected $description = 'Regenera los slugs nulos o vacíos de los perfiles. Un slug vacío rompe la ruta /tutores/{slug} con UrlGenerationException (Missing required parameter: slug).';

    public function handle()
    {
        $query = Profile::query()->where(function ($q) {
            $q->whereNull('slug')->orWhere('slug', '');
        });

        $affected = (clone $query)->count();

        if ($affected === 0) {
            $this->info('Todos los perfiles tienen slug. Nada que corregir.');

            return 0;
        }

        if ($this->option('dry-run')) {
            $this->warn("Perfiles con slug vacío/nulo: {$affected}\n");

            foreach ((clone $query)->orderBy('id')->get(['id', 'user_id', 'first_name', 'last_name', 'slug']) as $profile) {
                $this->line(sprintf(
                    '  - #%d user=%s nombre="%s %s" slug=[%s]',
                    $profile->id,
                    $profile->user_id,
                    $profile->first_name,
                    $profile->last_name,
                    $profile->slug ?? 'NULL'
                ));
            }

            return 0;
        }

        $count = 0;

        // Al vaciar el slug y guardar con Eloquent disparamos el
        // ProfileObserver, que regenera el slug con la misma lógica
        // (Str::slug del nombre + respaldo "tutor-{user_id}" si quedara vacío).
        $query->orderBy('id')->chunkById(100, function ($profiles) use (&$count) {
            foreach ($profiles as $profile) {
                $profile->slug = null;
                $profile->save();
                $count++;
            }
        });

        $this->info("Perfiles corregidos: {$count}");

        $remaining = Profile::query()->where(function ($q) {
            $q->whereNull('slug')->orWhere('slug', '');
        })->count();
        if ($remaining > 0) {
            $this->warn("Quedan {$remaining} perfiles con slug vacío. Revisa los nombres.");
        }

        return 0;
    }
}
