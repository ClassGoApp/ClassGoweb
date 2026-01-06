<?php

namespace App\Livewire\Pages\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

// IMPORTACIONES NUEVAS PARA EXCEL Y PDF
use App\Livewire\Pages\Admin\Exports\UsersReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersReports extends Component
{
    use WithPagination;

    public $search = '';
    public $reportType = 'verified_complete';
    public $per_page = 10;
    
    // Contadores
    public $countVerifiedComplete = 0;
    public $countIncomplete = 0;
    public $countVerifiedByArea = 0;
    public $countUnverifiedEmpty = 0;

    #[Layout('layouts.admin-app')]
    public function mount()
    {
        $this->calculateCounts();
    }

   // Función auxiliar para obtener el nombre bonito del archivo
    private function getFilename($extension)
    {
        $names = [
            'verified_complete' => 'Tutores_Verificados',
            'incomplete'        => 'Falta_Informacion',
            'verified_by_area'  => 'Tutores_Por_Area',
            'unverified_empty'  => 'Usuarios_Sin_Datos',
        ];

        $name = $names[$this->reportType] ?? 'Reporte_General';
        
        return 'Reporte-' . $name . '.' . $extension;
    }

    public function exportExcel()
    {
        $filename = $this->getFilename('xlsx');
        return Excel::download(new UsersReportExport($this->getFilteredQuery(), $this->reportType), $filename);
    }

    public function exportPDF()
    {
        $query = $this->getFilteredQuery();
        $users = $query->get();
        $filename = $this->getFilename('pdf');

        $data = [
            'users' => $users,
            'count' => $users->count(),
            'reportType' => $this->reportType,
        ];

        $pdf = Pdf::loadView('livewire.pages.admin.exports.users-report-export', $data);

        if($this->reportType == 'incomplete') {
            $pdf->setPaper('a4', 'landscape'); 
        }

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function render()
    {
        $data = $this->getFilteredQuery()
                     ->orderBy('created_at', 'desc')
                     ->paginate($this->per_page);

        return view('livewire.pages.admin.users.users-reports', [
            'users' => $data
        ]);
    }

    /**
     * Lógica de filtros centralizada
     */
    private function getFilteredQuery(): Builder
    {
        // 1. CONSULTA BASE
        $usersQuery = User::query()
            ->with(['profile', 'roles'])
            ->whereHas('roles', function ($q) {
                $q->where('name', '!=', 'admin');
            });

        // 2. LÓGICA ESPECÍFICA POR REPORTE
        switch ($this->reportType) {
            case 'verified_complete':
                $usersQuery->whereHas('roles', fn($q) => $q->where('name', 'tutor'))
                           ->whereHas('profile', function (Builder $q) {
                               $q->whereNotNull('verified_at')
                                 ->whereNotNull('phone_number')
                                 ->whereNotNull('image')
                                 ->whereNotNull('description');
                           })->has('userSubjects');
                break;

            case 'incomplete':
                $usersQuery->where(function($query) {
                    $query->whereHas('profile', function (Builder $q) {
                        $q->whereNull('phone_number')
                          ->orWhereNull('image')
                          ->orWhereNull('description');
                    });
                    $query->orWhere(function($subQ) {
                        $subQ->whereHas('roles', fn($r) => $r->where('name', 'tutor'))
                             ->doesntHave('userSubjects');
                    });
                });
                break;

            case 'verified_by_area':
                // CORRECCIÓN: DEBE CUMPLIR AMBAS CONDICIONES
                $usersQuery->whereHas('roles', fn($q) => $q->where('name', 'tutor'))
                           ->whereHas('profile', function (Builder $q) {
                               $q->whereNotNull('verified_at'); // 1. Que esté ACTIVO
                           })
                           ->has('userSubjects') // 2. Y que tenga AREAS
                           ->with('userSubjects.subject');
                break;

            case 'unverified_empty':
                $usersQuery->whereHas('profile', function (Builder $q) {
                    $q->whereNull('verified_at')
                      ->whereNull('phone_number')
                      ->whereNull('image');
                });
                break;
        }

        // 3. Filtro de Búsqueda
        if (!empty($this->search)) {
            $usersQuery->where(function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                  ->orWhereHas('profile', function ($subQ) {
                      $subQ->where('first_name', 'like', '%' . $this->search . '%')
                           ->orWhere('last_name', 'like', '%' . $this->search . '%')
                           ->orWhere('phone_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return $usersQuery;
    }

    public function setReport($type)
    {
        $this->reportType = $type;
        $this->resetPage();
    }

    private function calculateCounts()
    {
        $allUsers = User::whereHas('roles', fn($q) => $q->where('name', '!=', 'admin'));
        $tutorsOnly = (clone $allUsers)->whereHas('roles', fn($q) => $q->where('name', 'tutor'));

        $this->countVerifiedComplete = (clone $tutorsOnly)->whereHas('profile', function (Builder $q) {
            $q->whereNotNull('verified_at')->whereNotNull('phone_number')->whereNotNull('image')->whereNotNull('description');
        })->has('userSubjects')->count();

        $this->countIncomplete = (clone $allUsers)->where(function($query) {
            $query->whereHas('profile', fn($q) => $q->whereNull('phone_number')->orWhereNull('image'))
            ->orWhere(function($sub) {
                $sub->whereHas('roles', fn($r) => $r->where('name', 'tutor'))->doesntHave('userSubjects');
            });
        })->count();

        // CORRECCIÓN EN EL CONTADOR TAMBIÉN
        $this->countVerifiedByArea = (clone $tutorsOnly)
            ->whereHas('profile', fn($q) => $q->whereNotNull('verified_at')) // Activo
            ->has('userSubjects') // Con materias
            ->count();

        $this->countUnverifiedEmpty = (clone $allUsers)->whereHas('profile', function (Builder $q) {
            $q->whereNull('verified_at')->whereNull('phone_number')->whereNull('image');
        })->count();
    }
}