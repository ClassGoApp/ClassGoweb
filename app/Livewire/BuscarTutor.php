<?php

namespace App\Livewire;

use App\Repositories\TutorRepository;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Subject;
use App\Services\SiteService;


class BuscarTutor extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
     public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $paginationTheme = 'tailwind'; // O 'bootstrap' si usas Bootstrap

    public function updatingSearch()
    {
        $this->resetPage();
    }

   // class BuscarTutor extends Component

    public function getFilteredProfiles(SiteService $siteService, TutorRepository $tutorRepository)
    {
        // Si la búsqueda está vacía, devuelve un paginador vacío para ahorrar recursos
        if (empty($this->search)) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage, 1);
        }
        $paginatedResult = $siteService->getTutorDato($this->perPage, $this->search);
        $items = collect($paginatedResult->items());

        // Modificar cada elemento
        $modifiedItems = $items->map(function ($profile) use ($tutorRepository) {
            $userId = $profile['user_id'];
            $reviewData = $tutorRepository->getTutorReviewsWithStats($userId);
            $profile['avg_rating'] = $reviewData['stats']['avgRating'] ?? 0;
            $profile['total_reviews'] = $reviewData['stats']['totalReviews'] ?? 0;
            $profile['native_language'] = $reviewData['stats']['native_language'] ?? 'Español';
            return $profile;
        });
        
        // Crear un nuevo paginador con los elementos modificados
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $modifiedItems,
            $paginatedResult->total(),
            $paginatedResult->perPage(),
            $paginatedResult->currentPage(),
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }

    public function render(SiteService $siteService, TutorRepository $tutorRepository)
    {
        $profiles = $this->getFilteredProfiles($siteService, $tutorRepository);

        return view('livewire.buscar-tutor', compact('profiles'))
            ->layout('vistas.view.layouts.app');
    }
} 