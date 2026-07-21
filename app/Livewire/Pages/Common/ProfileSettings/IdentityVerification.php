<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use App\Jobs\SendNotificationJob;
use App\Livewire\Forms\Common\ProfileSettings\IdentityVerificationForm;
use App\Models\AccountSetting;
use App\Models\Country;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\UserSubject;
use App\Services\IdentityService;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;
use Illuminate\Support\Facades\Session;

use App\Models\Code;
use App\Models\Coupon;

use App\Models\UserPayoutMethod;
use Illuminate\Support\Str;

//use Google\Service\Analytics\Profiles;
use App\Models\profiles;



/**
 * Componente Livewire para la verificación de identidad del usuario con flujo diferido.
 */
class IdentityVerification extends Component
{
    use WithFileUploads;

    public IdentityVerificationForm $form;

    private $identityService;

    public $identityInfo;

    public $identity;

    public $isLoading = true;

    public $personalPhoto;

    public $docs;

    public $existingDocs = [];

    public $verified = false;

    public $user = '';

    public $countries = null;

    public $states;

    public $allowImgFileExt = [];

    public $fileExt = '';

    public $allowImageSize = '';

    public $data;

    public $profile;

    public $emailTemplate;

    public $hasStates = false;

    public $activeRoute;

    public $userSubjectsCount = 0;

    public $prerequisite_gender;

    public $prerequisite_price;

    public $prerequisite_phone_number;

    public bool $prerequisite_terms = false;

    public $prerequisite_errors = [];

    public $showPrerequisitesModal = false;

    // Selector de materias en el modal
    public string $subjectSearch = '';

    public array $subjectSearchResults = [];

    public array $selectedSubjects = [];

    private ?IdentityService $userIdentity = null;

    private ?ProfileService $profileService = null;

    public bool $prerequisites_validated = false;

    // Ganchos reactivos: Si el usuario cambia el género, precio, teléfono o términos tras verificar, el botón se bloquea de nuevo
    public function updatedPrerequisiteGender()
    {
        $this->prerequisites_validated = false;
    }

    public function updatedPrerequisitePrice()
    {
        $this->prerequisites_validated = false;
    }

    public function updatedPrerequisitePhoneNumber()
    {
        $this->prerequisites_validated = false;
    }

    public function updatedPrerequisiteTerms()
    {
        $this->prerequisites_validated = false;
    }

    public function boot()
    {
        $this->userIdentity = new IdentityService(Auth::user());
        $this->profileService = new ProfileService(Auth::user()->id);
        $this->user = Auth::user();
    }

    public function loadData()
    {
        $this->isLoading = false;
        $this->dispatch('loadPageJs');
    }

    public function mount()
    {
        $this->activeRoute = Route::currentRouteName();
        $this->profile = $this->profileService->getUserProfile();
        $this->countries = Country::get(['id', 'name']) ?? [];
        $this->emailTemplate = setting('_lernen.for_role') ?? (object) ['status' => 'both'];
        $image_file_ext = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $image_file_size = (int) (setting('_general.max_image_size') ?? '5');
        $this->allowImageSize = ! empty($image_file_size) ? $image_file_size : '5';
        $this->allowImgFileExt = ! empty($image_file_ext) ? explode(',', $image_file_ext) : [];
        $this->fileExt = fileValidationText($this->allowImgFileExt);

        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function updatedForm($value, $key)
    {
        if ($key == 'countryName') {
            $country = Country::where('short_code', $value)->select('id')->first();
            $this->form->country = $country?->id;
        } elseif (in_array($key, ['image', 'identificationCard', 'transcript'])) {
            $mimeType = $value->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] != 'image') {
                $this->dispatch('showAlertMessage', type: 'error', message: __('validation.invalid_file_type', ['file_types' => fileValidationText($this->allowImgFileExt)]));
                $this->form->{$key} = null;

                return;
            }
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->states = null;
        $this->hasStates = false; // 👈 1. Inicializamos la propiedad en false por defecto
        $this->identity = $this->userIdentity->getUserIdentityVerification();
        $this->userSubjectsCount = UserSubject::where('user_id', Auth::id())->count();

        if (! empty($this->form->country)) {
            $this->states = $this->userIdentity->countryStates($this->form->country);
            if ($this->states->isNotEmpty()) {
                $this->hasStates = true; // 👈 2. Corregido: Asignamos a la propiedad de la clase ($this->hasStates)
                $this->dispatch('initSelect2', target: '#country_state');
            }
        }

        $enableGooglePlaces = '0';
        $googleApiKey = setting('_api.google_places_api_key');

        return view('livewire.pages.common.profile-settings.identity-verification', compact('enableGooglePlaces', 'googleApiKey'));
    }

    public function removeMedia($type)
    {
        match ($type) {
            'personal_photo' => $this->form->removePhoto(),
            'identificationCard' => $this->form->removeIdentificationCard(),
            'transcript' => $this->form->removeTranscript()
        };
    }

    #[On('cancel-identity')]
    public function removeIdentity()
    {
        $this->userIdentity->deleteUserAddress($this->identity->id);
        $this->userIdentity->deleteUserIdentityVerification();
        $this->form->reset();
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function updateInfo()
    {
        try {
            // 1️⃣ Ejecuta la validación y mapeo de datos del Form Object
            $this->data = $this->form->updateInfo($this->hasStates);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 🚨 CAPTURA EL FALLO: Si falta la fecha o una foto, avisa inmediatamente a la vista para el parpadeo
            $this->dispatch('validation-failed');
            // Re-lanzamos la excepción para que Livewire pinte los mensajes de error tradicionales debajo de los inputs
            throw $e;
        }

        $perfil = Auth::user()->profile;
        $isTutor = Auth::user()->hasRole('tutor');
        $googlecalendar = AccountSetting::where('user_id', Auth::user()->id)->first();
        $userSubjects = UserSubject::where('user_id', Auth::user()->id)->count();

        $this->prerequisite_errors = [];

        if (empty($perfil->phone_number)) {
            $this->prerequisite_errors['phone_number'] = 'Debes ingresar tu número de teléfono.';
        }

        if ($perfil->gender == null) {
            $this->prerequisite_errors['gender'] = 'Debes configurar tu género.';
        }

        if ($isTutor) {
            if ($perfil->price == null || floatval($perfil->price) <= 0) {
                $this->prerequisite_errors['price'] = 'Debes definir cuánto deseas cobrar por tutoría.';
            }

            if ($userSubjects == 0) {
                $this->prerequisite_errors['subjects'] = 'Debes agregar al menos una materia a tu perfil.';
            }

            if (app()->environment('production') && $googlecalendar === null) {
                $this->prerequisite_errors['calendar'] = 'Debes conectar tu cuenta de Google Calendar.';
            }

            if (empty(Auth::user()->terms_accepted_at)) {
                $this->prerequisite_errors['terms'] = 'Debes aceptar los términos y condiciones de tutorías al instante.';
            }
        }

        if (! empty($this->prerequisite_errors)) {
            $genderMap = [
                1 => 'male', 2 => 'female', 3 => 'not_specified',
                'male' => 'male', 'female' => 'female', 'not_specified' => 'not_specified',
            ];
            $this->prerequisite_gender = $genderMap[$perfil->gender] ?? '';
            $this->prerequisite_price = $perfil->price;
            $this->prerequisite_phone_number = $perfil->phone_number;
            $this->prerequisite_terms = ! empty(Auth::user()->terms_accepted_at);
            $this->showPrerequisitesModal = true;
            $this->loadSelectedSubjects();
            $this->dispatch('openPrerequisitesModal');

            return;
        } else {
            try {
                $this->data['address']['lat'] = 0.0;
                $this->data['address']['long'] = 0.0;
                DB::beginTransaction();
                $this->data['identityInfo']['name'] = $this->user->profile->first_name.' '.$this->user->profile->last_name;

                $userIdentity = $this->userIdentity->setUserIdentityVerification($this->data['identityInfo']);
                $this->userIdentity->setUserAddress($userIdentity?->id, $this->data['address']);

                $perfil->verified_at = null;
                $perfil->save();
                $this->profile = $perfil;

                DB::commit();
                $this->Coupons();

                try {
                    $adminEmail = config('mail.from.address');
                    $user = Auth::user();
                    $contenido = "El usuario {$user->profile->first_name} - {$user->profile->last_name} ({$user->email}) ha hecho una solicitud de verificación de identidad.";
                    \Mail::raw($contenido, function ($message) use ($adminEmail) {
                        $message->to($adminEmail)->subject('Nueva solicitud de verificación de identidad');
                    });
                } catch (\Exception $e) {
                    \Log::error('Error al enviar correo: '.$e->getMessage());
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            $this->data['identityInfo']['gender'] = $this->profile?->gender;
            $this->data['identityInfo']['email'] = Auth::user()->email;
            $this->data['identityInfo']['role'] = Auth::user()->role;
            dispatch(new SendNotificationJob('identityVerificationRequest', User::admin(), $this->data));

            if (Auth::user()->hasRole('student') && $this->emailTemplate?->status !== 'both') {
                return;
            }
            dispatch(new SendNotificationJob('identityVerificationRequest', Auth::user(), $this->data));
        }
    }

    public function Coupons()
    {
        $user = Auth::user();
        $userCoupon = UserCoupon::where('user_id', $user->id)
            ->where('cantidad', 5)
            ->whereHas('coupon', function ($query) use ($user) {
                $query->whereDate('created_at', $user->created_at->toDateString());
            })
            ->first();

        if ($userCoupon && $userCoupon->coupon) {
            $userCoupon->coupon->update([
                'estado' => 'activo',
                'descuento' => 100,
                'fecha_caducidad' => now()->addDays(30),
            ]);
        }
    }

    /**
     * Guarda una sección específica del modal de prerrequisitos de forma independiente.
     */
    public function savePrerequisiteOption($type)
    {
        $perfil = Auth::user()->profile;
        $isTutor = Auth::user()->hasRole('tutor');

        // 1️⃣ Guardado de Género
        if ($type === 'gender') {
            $this->validate([
                'prerequisite_gender' => 'required|in:male,female,not_specified',
            ], [
                'prerequisite_gender.required' => 'Por favor, selecciona un género antes de aceptar.',
            ]);

            $genderIntMap = ['male' => 1, 'female' => 2, 'not_specified' => 3];
            $perfil->gender = $genderIntMap[$this->prerequisite_gender];
            $perfil->save();
        }

        // 2️⃣ Guardado de Precio
        if ($type === 'price') {
            $this->validate([
                'prerequisite_price' => 'required|numeric|min:0.01',
            ], [
                'prerequisite_price.required' => 'El precio por hora es requerido.',
                'prerequisite_price.min' => 'El precio debe ser mayor a 0 Bs.',
            ]);

            $perfil->price = $this->prerequisite_price;
            $perfil->save();
        }

        // 3️⃣ SOLUCIÓN: Guardado Diferido de Materias (Al presionar "Aceptar")
        if ($type === 'subjects') {
            if (count($this->selectedSubjects) === 0) {
                $this->prerequisite_errors['subjects'] = 'Debes agregar al menos una materia.';

                return;
            }

            $currentSubjectIds = collect($this->selectedSubjects)->pluck('subject_id')->toArray();

            DB::transaction(function () use ($currentSubjectIds) {
                // Eliminar de la base de datos las materias asociadas que ya no están en la lista provisional
                UserSubject::where('user_id', Auth::id())
                    ->whereNotIn('subject_id', $currentSubjectIds)
                    ->delete();

                // Registrar de forma masiva segura las nuevas asignaciones
                foreach ($currentSubjectIds as $subId) {
                    UserSubject::firstOrCreate([
                        'user_id' => Auth::id(),
                        'subject_id' => $subId,
                    ]);
                }
            });

            // Re-sincronizar de forma limpia desde la base de datos
            $this->loadSelectedSubjects();
        }

        // 4️⃣ Guardado de Términos y Condiciones
        if ($type === 'terms') {
            $this->validate([
                'prerequisite_terms' => 'accepted',
            ], [
                'prerequisite_terms.accepted' => 'Debes marcar la casilla para aceptar los términos y condiciones.',
            ]);

            $user = Auth::user();
            $user->terms_accepted_at = now();
            $user->save();
            $this->user = $user;
        }

        // 5️⃣ Guardado de Teléfono
        if ($type === 'phone_number') {
            $this->validate([
                'prerequisite_phone_number' => 'required|string|max:20',
            ], [
                'prerequisite_phone_number.required' => 'El número de teléfono es requerido.',
            ]);

            $perfil->phone_number = $this->prerequisite_phone_number;
            $perfil->save();
        }

        // Refrescar el estado de los componentes visuales del modal
        $this->manualCheckPrerequisites();
    }

    public function manualCheckPrerequisites()
    {
        $perfil = Auth::user()->profile;
        $isTutor = Auth::user()->hasRole('tutor');
        $googlecalendar = AccountSetting::where('user_id', Auth::user()->id)->first();

        $this->prerequisite_errors = [];

        if (empty($perfil->phone_number)) {
            $this->prerequisite_errors['phone_number'] = 'Requerido';
        }

        if ($perfil->gender == null) {
            $this->prerequisite_errors['gender'] = 'Requerido';
        }

        if ($isTutor) {
            if ($perfil->price == null || floatval($perfil->price) <= 0) {
                $this->prerequisite_errors['price'] = 'Requerido';
            }
            $userSubjects = UserSubject::where('user_id', Auth::id())->count();
            if ($userSubjects == 0) {
                $this->prerequisite_errors['subjects'] = 'Requerido';
            }
            if (app()->environment('production') && $googlecalendar === null) {
                $this->prerequisite_errors['calendar'] = 'Requerido';
            }
            if (empty(Auth::user()->terms_accepted_at)) {
                $this->prerequisite_errors['terms'] = 'Requerido';
            }
        }

        $this->prerequisite_phone_number = $perfil->phone_number;
        $this->prerequisite_terms = ! empty(Auth::user()->terms_accepted_at);
        $this->prerequisites_validated = empty($this->prerequisite_errors);
    }

    public function recheckPrerequisites()
    {
        $this->manualCheckPrerequisites();
    }

    public function savePrerequisites()
    {
        $this->manualCheckPrerequisites();
        if (! $this->prerequisites_validated) {
            return;
        }

        $this->showPrerequisitesModal = false;
        $this->dispatch('closePrerequisitesModal');
    }

    public function loadSelectedSubjects(): void
    {
        $this->selectedSubjects = UserSubject::where('user_id', Auth::id())
            ->with('subject:id,name')
            ->get()
            ->map(fn ($us) => ['user_subject_id' => $us->id, 'subject_id' => $us->subject_id, 'name' => $us->subject?->name ?? ''])
            ->toArray();

        $this->userSubjectsCount = count($this->selectedSubjects);
    }

    public function updatedSubjectSearch(): void
    {
        $term = trim($this->subjectSearch);
        if (strlen($term) < 1) {
            $this->subjectSearchResults = [];

            return;
        }

        $selectedIds = collect($this->selectedSubjects)->pluck('subject_id')->toArray();

        $this->subjectSearchResults = Subject::where('name', 'like', "%{$term}%")
            ->whereNull('deleted_at')
            ->whereNotIn('id', $selectedIds)
            ->select('id', 'name')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * AGREGA MATERIA EN MEMORIA VOLÁTIL (NO impacta la base de datos de forma inmediata)
     */
    public function addSubjectFromModal(int $subjectId): void
    {
        $subject = Subject::find($subjectId);
        if (! $subject) {
            return;
        }

        // Comprobación defensiva local
        $existsLocally = collect($this->selectedSubjects)->contains('subject_id', $subjectId);

        if (! $existsLocally) {
            $this->selectedSubjects[] = [
                'user_subject_id' => null, // Marcada temporalmente como nueva
                'subject_id' => $subjectId,
                'name' => $subject->name,
            ];
        }

        $this->subjectSearch = '';
        $this->subjectSearchResults = [];
        $this->userSubjectsCount = count($this->selectedSubjects);
        $this->prerequisites_validated = false; // Requiere confirmación explícita
    }

    /**
     * REMUENE MATERIA EN MEMORIA VOLÁTIL (Soporta búsquedas cruzadas por llaves)
     */
    public function removeSubjectFromModal(int $id): void
    {
        // Remueve la fila del array ya sea usando el ID intermedio de la tabla o el ID directo de la materia
        $this->selectedSubjects = collect($this->selectedSubjects)
            ->reject(fn ($item) => $item['user_subject_id'] == $id || $item['subject_id'] == $id)
            ->values()
            ->toArray();

        $this->userSubjectsCount = count($this->selectedSubjects);
        $this->prerequisites_validated = false; // Requiere confirmación explícita
    }
}
