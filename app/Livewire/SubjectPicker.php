<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SubjectPicker extends Component
{
    public array $subjects = [];
    public int $id_materia=null;
    public int $id_tutor=null;

    // key simple (no amarres a 838)
    private const CACHE_KEY = 'subjects.active.all';
    private const CACHE_TTL = 3600; // 1 hora

    public function mount(): void
    {
        $this->subjects = $this->getSubjects();
    }

    /**
     * Retorna TODAS las materias activas (cacheado).
     */
    public function getSubjects(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return DB::table('subjects')
                ->select('id', 'name')
                ->whereNull('deleted_at')
                ->where('status', 'active')
                ->orderBy('name')
                ->get()
                ->map(fn ($s) => [
                    'id'   => (int) $s->id,
                    'name' => (string) $s->name,
                ])
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.subject-picker');
    }
}
