<?php

namespace App\Livewire\Admin\Tutors;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Tutors extends Component
{
    use WithPagination;

    // Propiedades del formulario
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $confirm_password = '';

    // Filtros
    public $search = '';
    public $sortby = 'desc';
    public $per_page = 10;
    public $filterUser = '';
    public $verification = '';

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $tutors = User::whereHas('roles', function ($query) {
                $query->where('name', 'tutor');
            })
            ->with([
                'profile' => function ($q) {
                    $q->select('id', 'user_id', 'first_name', 'last_name', 'slug', 'image');
                }
            ]);

        if (!empty($this->search)) {
            $search = trim($this->search);
            $tutors = $tutors->where(function ($query) use ($search) {
                if (is_numeric($search)) {
                    $query->orWhere('id', (int) $search);
                }
                $query->orWhere('email', 'like', $search . '%')
                    ->orWhereHas('profile', function ($sub_query) use ($search) {
                        $terms = array_filter(explode(' ', $search));
                        $sub_query->where(function ($subQ) use ($terms) {
                            foreach ($terms as $term) {
                                $subQ->where(function ($wordQ) use ($term) {
                                    $wordQ->where('first_name', 'like', $term . '%')
                                          ->orWhere('last_name', 'like', $term . '%');
                                });
                            }
                        });
                    });
            });
        }

        if (!empty($this->filterUser)) {
            $tutors = $this->filterUser === 'active' ? $tutors->active() : $tutors->inactive();
        }

        if (!empty($this->verification)) {
            if ($this->verification === 'verified') {
                $tutors = $tutors->whereNotNull('email_verified_at');
            } elseif ($this->verification === 'unverified') {
                $tutors = $tutors->whereNull('email_verified_at');
            }
        }

        $tutors = $tutors->orderBy('id', $this->sortby)->paginate($this->per_page);

        return view('livewire.admin.tutors.tutors', compact('tutors'));
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterUser', 'verification', 'sortby'])) {
            $this->resetPage();
        }
    }

    public function addTutor()
    {
        // Validar los datos
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Asignar rol de tutor
            $tutorRole = Role::where('name', 'tutor')->first();
            if ($tutorRole) {
                $user->roles()->attach($tutorRole->id);
            }

            // Crear perfil con slug único
            $slug = Str::slug($this->first_name . ' ' . $this->last_name);
            $originalSlug = $slug;
            $counter = 1;

            while (Profile::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Profile::create([
                'user_id' => $user->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'slug' => $slug,
            ]);

            DB::commit();

            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('general.tutor_added_successfully'));
            $this->dispatch('toggleModel', id: 'tb-add-tutor', action: 'hide');
            $this->resetInputFields();
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: $e->getMessage());
        }
    }

    private function resetInputFields()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->confirm_password = '';
        $this->form->password = '';
        $this->form->confirm_password = '';
    }
   
}
