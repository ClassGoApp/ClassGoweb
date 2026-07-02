<?php

namespace App\Livewire\Pages\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

// IMPORTACIONES PARA EXCEL Y PDF
use App\Livewire\Pages\Admin\Exports\UsersReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersReports extends Component
{
    use WithPagination;

    // Propiedades de búsqueda y estado
    public $search = '';
    public $reportType = 'verified_complete';
    public $per_page = 10;

    // Propiedades de Filtros
    public $verification = ''; 
    public $roles = '';        
    public $sortby = 'newest'; 
    
    // Contadores
    public $countVerifiedComplete = 0;
    public $countIncomplete = 0;
    public $countVerifiedByArea = 0; // Se mantiene el nombre, pero ahora cuenta "Verificados General"
    public $countUnverifiedEmpty = 0;

    #[Layout('layouts.admin-app')]
    public function mount()
    {
        $this->calculateCounts();
    }

    // Hooks de actualización para resetear paginación
    public function updatedSearch() { $this->resetPage(); }
    public function updatedVerification() { $this->resetPage(); }
    public function updatedRoles() { $this->resetPage(); }
    public function updatedSortby() { $this->resetPage(); }

    private function getFilename($extension)
    {
        $names = [
            'verified_complete' => 'Usuarios_Completos',
            'incomplete'        => 'Falta_Informacion',
            'verified_general'  => 'Todos_Verificados', // Nombre actualizado
            'unverified_empty'  => 'Sin_Verificar',
        ];

        $name = $names[$this->reportType] ?? 'Reporte';
        return 'Reporte-' . $name . '-' . now()->format('Y-m-d') . '.' . $extension;
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
        // Recalcular contadores para que reflejen cambios si es necesario
        $this->calculateCounts();

        $users = $this->getFilteredQuery()
                      ->paginate($this->per_page);

        return view('livewire.pages.admin.users.users-reports', [
            'users' => $users
        ]);
    }

    /**
     * Lógica de filtros OPTIMIZADA
     */
    private function getFilteredQuery(): Builder
    {
        // 1. CONSULTA BASE
        $usersQuery = User::query()
            ->with(['profile', 'roles', 'userSubjects.subject']);

        // Excluir siempre a los administradores de estos reportes
        $usersQuery->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'));

        // 2. FILTROS DE INTERFAZ (Roles, Verificación, Búsqueda)
        
        // Filtro Rol
        if (!empty($this->roles)) {
            $usersQuery->whereHas('roles', fn($q) => $q->where('name', $this->roles));
        }

        // Filtro Verificación
        // Ocultamos este filtro en 'unverified_empty' (todos son no verificados)
        // Y en 'verified_general' (todos son verificados), para no ser redundantes
        if (!in_array($this->reportType, ['unverified_empty', 'verified_general'])) {
            if ($this->verification === 'verified') {
                $usersQuery->whereHas('profile', fn($q) => $q->whereNotNull('verified_at'));
            } elseif ($this->verification === 'unverified') {
                $usersQuery->whereHas('profile', fn($q) => $q->whereNull('verified_at'));
            }
        }

        // 3. LÓGICA DE TARJETAS (Métricas)
        switch ($this->reportType) {
            case 'verified_complete':
                // A) Debe tener perfil completo
                $usersQuery->whereHas('profile', function ($q) {
                    $q->whereNotNull('verified_at')
                      ->whereNotNull('phone_number')
                      ->whereNotNull('image')
                      ->whereNotNull('description');
                });
                
                // B) Condición de Materias: SOLO SI ES TUTOR
                $usersQuery->where(function($q) {
                    // Si es estudiante, pasa.
                    $q->whereHas('roles', fn($r) => $r->where('name', 'student'))
                    // Si es tutor, debe tener materias.
                      ->orWhere(function($sub) {
                          $sub->whereHas('roles', fn($r) => $r->where('name', 'tutor'))
                              ->has('userSubjects');
                      });
                });
                break;

            case 'incomplete':
                // Buscamos usuarios a los que les falte algo
                $usersQuery->where(function($query) {
                    
                    // 1. Falta Perfil (Aplica a todos: tutor o estudiante)
                    $query->whereDoesntHave('profile')
                          ->orWhereHas('profile', function ($q) {
                              $q->whereNull('phone_number')
                                ->orWhereNull('image')
                                ->orWhereNull('description');
                          });

                    // 2. Falta Materias (SOLO aplica a Tutores)
                    $query->orWhere(function($subQ) {
                        $subQ->whereHas('roles', fn($r) => $r->where('name', 'tutor'))
                             ->doesntHave('userSubjects');
                    });
                });
                break;

            case 'verified_general': 
                // NUEVA LÓGICA: Todos los usuarios con fecha de verificación (Activos)
                $usersQuery->whereHas('profile', fn($q) => $q->whereNotNull('verified_at'));
                break;

            case 'unverified_empty':
                // Todos los NO verificados (Sin fecha o sin perfil)
                $usersQuery->where(function($q) {
                    $q->whereDoesntHave('profile') // No tiene perfil creado
                      ->orWhereHas('profile', fn($p) => $p->whereNull('verified_at')); // O perfil no verificado
                });
                break;
        }

        // 4. BÚSQUEDA
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

        // 5. ORDENAMIENTO
        $direction = ($this->sortby === 'oldest') ? 'asc' : 'desc';
        $usersQuery->orderBy('created_at', $direction);

        return $usersQuery;
    }

    public function setReport($type)
    {
        $this->reportType = $type;
        
        // Limpiamos el filtro de estado en estas tarjetas porque es redundante
        if (in_array($type, ['unverified_empty', 'verified_general'])) {
            $this->verification = ''; 
        }

        $this->resetPage();
    }

    /**
     * Cálculo de contadores optimizado
     */
    private function calculateCounts()
    {
        // Consulta base limpia (solo excluyendo admins)
        $baseQuery = User::whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'));

        // 1. COMPLETOS
        $this->countVerifiedComplete = (clone $baseQuery)
            ->whereHas('profile', function ($q) {
                $q->whereNotNull('verified_at')
                  ->whereNotNull('phone_number')
                  ->whereNotNull('image')
                  ->whereNotNull('description');
            })
            ->where(function($q) {
                // Estudiantes completos O Tutores completos (con materias)
                $q->whereHas('roles', fn($r) => $r->where('name', 'student'))
                  ->orWhere(function($sub) {
                      $sub->whereHas('roles', fn($r) => $r->where('name', 'tutor'))
                          ->has('userSubjects');
                  });
            })->count();

        // 2. INCOMPLETOS
        $this->countIncomplete = (clone $baseQuery)
            ->where(function($q) {
                // Falta perfil básico
                $q->whereDoesntHave('profile')
                  ->orWhereHas('profile', function ($p) {
                      $p->whereNull('phone_number')
                        ->orWhereNull('image')
                        ->orWhereNull('description');
                  })
                  // O es tutor sin materias
                  ->orWhere(function($sub) { 
                      $sub->whereHas('roles', fn($r) => $r->where('name', 'tutor'))
                          ->doesntHave('userSubjects');
                  });
            })->count();

        // 3. VERIFICADOS GENERAL (Antes Por Área)
        // Cuenta a TODOS los que tienen verified_at
        $this->countVerifiedByArea = (clone $baseQuery)
            ->whereHas('profile', fn($q) => $q->whereNotNull('verified_at'))
            ->count();

        // 4. SIN VERIFICAR
        $this->countUnverifiedEmpty = (clone $baseQuery)
            ->where(function($q) {
                $q->whereDoesntHave('profile')
                  ->orWhereHas('profile', fn($p) => $p->whereNull('verified_at'));
            })->count();
    }
}