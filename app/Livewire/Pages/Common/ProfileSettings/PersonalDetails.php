<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use App\Models\Country;
use App\Models\Language;
use App\Models\UserLanguage;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


/**
 * Componente Livewire para la gestión de detalles personales
 * Maneja la carga y actualización de información del perfil de usuario
 */
class PersonalDetails extends Component
{
    use WithFileUploads;

    private ?ProfileService $profileService = null;

    // Propiedades del formulario
    public $state;
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone_number = '';
    public $gender = 'No especificado'; // Cambiado a string para evitar problemas de validación
    public $slug = '';
    public $description = '';
    public $native_language = '';
    public $user_languages = [];
    public $selected_languages = [];
    // lema tag_line
    public $personalStatements = [
        'Enseñar es transformar vidas',
        'Enseñar es transformar vidas con conocimiento y empatía.',
        'Mi pasión es compartir el poder del aprendizaje constante.',
        'Innovar, enseñar y crecer: mi fórmula para el éxito.',
        'La educación es mi motor, el futuro mi inspiración.',
        'Aprender nunca fue tan emocionante como enseñarlo.',
        'Transformo ideas en conocimiento útil para los demás.',
        'Creando caminos de aprendizaje con pasión y propósito.',
        'Inspirar, motivar y guiar: mi misión como educador.',
        'La enseñanza es el arte de encender mentes brillantes.',
        'La programación me enseña a pensar y resolver mejor.',
        'En cada clase siembro curiosidad, no solo respuestas.',
        'Mi meta: hacer del conocimiento una aventura diaria.',
        'Programar es mi forma de crear soluciones con lógica.',
        'Formando mentes creativas para un mundo tecnológico.',
        'La tecnología cambia, pero el conocimiento permanece.',
        'Enseñar con pasión, aprender con humildad siempre.',
        'Aprendo enseñando, enseño aprendiendo cada día.',
        'Mi pasión es enseñar lo que me apasiona aprender.',
        'Crear, enseñar y mejorar: mi lema profesional.',
        'Transformo el aprendizaje en experiencias inspiradoras.',
        'Hacer fácil lo complejo: el arte de enseñar con amor.',
        'La innovación comienza con una mente curiosa.',
        'Enseñar tecnología es abrir puertas al futuro.',
        'Conocimiento, pasión y constancia son mis pilares.',
        'Mi meta es inspirar mentes que cambien el mundo.',
        'Enseñar con empatía, aprender con gratitud profunda.',
        'Formando líderes a través del conocimiento compartido.',
        'Cada error es una lección para mejorar y avanzar.',
        'La lógica es mi herramienta, la programación mi arte.',
        'Donde otros ven problemas, yo veo oportunidades.',
        'El futuro pertenece a quienes nunca dejan de aprender.',
        'Aprender es crecer, enseñar es multiplicar el saber.',
        'Compartir conocimiento es una forma de inmortalidad.',
        'La educación cambia el mundo, una mente a la vez.',
        'La programación me enseña paciencia y creatividad.',
        'La innovación nace de la curiosidad y el aprendizaje.',
        'Conocimiento aplicado, resultados extraordinarios.',
        'Enseñar es guiar a otros hacia su mejor versión.',
        'Programar ideas, construir sueños y resolver retos.',
        'Aprendo, enseño y evoluciono en cada proyecto nuevo.',
        'Mi pasión por aprender impulsa todo lo que enseño.',
        'Inspirar mentes curiosas es mi mayor recompensa.',
        'La enseñanza es el puente hacia un futuro brillante.',
        'Cada clase es una oportunidad de crear impacto real.',
        'En cada lección, dejo huellas de conocimiento vivo.',
        'Mi objetivo es inspirar y despertar la curiosidad.',
        'Enseñar con amor es sembrar esperanza en el alma.',
        'El aprendizaje nunca termina, solo evoluciona siempre.',
        'Con cada código, creo soluciones que transforman.',
        'Mi vocación: enseñar, motivar y transformar vidas.',
        'El saber compartido multiplica su valor sin límite.',
        'Aprender y enseñar son dos caras del mismo sueño.',
        'El futuro digital se construye con conocimiento hoy.',
        'Cada clase es una semilla de cambio positivo.',
        'Enseñar es encender la chispa del pensamiento libre.',
        'Aprender a aprender es la clave del éxito duradero.',
        'Programar es convertir la lógica en arte funcional.',
        'La pasión por enseñar impulsa mi crecimiento diario.',
        'Enseñar valores a través del conocimiento aplicado.',
        'Crear soluciones reales con pensamiento lógico claro.',
        'Cada día enseño, cada día también aprendo algo.',
        'Formando mentes críticas, libres y creativas siempre.',
        'Programar es mi idioma, la lógica mi mejor aliada.',
        'Educar con propósito, innovar con cada experiencia.',
        'Enseñar con propósito es cambiar vidas con amor.',
        'Mi código más importante: pasión por enseñar bien.',
        'Convertir ideas en aprendizaje es mi mayor logro.',
        'Educar es sembrar conocimiento para un mañana mejor.',
        'Cada alumno es una oportunidad de transformar futuro.',
        'La tecnología al servicio del aprendizaje humano.',
        'Aprender para enseñar, enseñar para transformar.',
        'Inspirar el cambio a través del conocimiento digital.',
        'La educación es la base del progreso sostenible.',
        'Mi pasión: formar mentes curiosas y creativas hoy.',
        'Programar es crear lógica con imaginación constante.',
        'Enseñar con empatía genera aprendizajes duraderos.',
        'Educar es el arte de encender luces en la oscuridad.',
        'Aprender de los demás me hace un mejor profesor.',
        'Enseñar a pensar es más valioso que enseñar a hacer.',
        'La curiosidad es el motor de todo aprendizaje real.',
        'Conocimiento, pasión y acción: mi lema profesional.',
        'La educación es mi herramienta para cambiar el mundo.',
        'La programación me enseña a ver el mundo distinto.',
        'Enseñar ciencia con pasión y creatividad auténtica.',
        'Aprender del error es la clave del éxito constante.',
        'El aprendizaje es infinito, igual que mi curiosidad.',
        'Programar soluciones que impacten vidas positivamente.',
        'Enseñar tecnología es preparar líderes del mañana.',
        'La lógica y la pasión construyen mi camino docente.',
        'Formando mentes que piensan, crean y transforman.',
        'Aprender es descubrir, enseñar es multiplicar.',
        'Educar con pasión es cambiar destinos para siempre.',
        'La enseñanza es mi vocación y mi propósito vital.',
        'Aprender juntos es crecer más allá del conocimiento.',
        'Cada código que escribo enseña algo nuevo al mundo.',
        'La tecnología es el lenguaje del futuro que enseño.',
        'Enseñar con alegría es sembrar conocimiento eterno.',
        'El aprendizaje es mi viaje favorito sin destino final.',
        'Programar para crear, enseñar para inspirar siempre.',
        'Mi misión: guiar mentes brillantes hacia el futuro.',
    ];
    public $selected_lema=null;
    // Archivos
    public $image;
    public $intro_video;
    public $isUploadingImage = false;
    public $isUploadingVideo = false;
    public $imageName = '';
    public $videoName = '';
    // Estados
    public $isLoading = true;
    public $hasStates = false;
    public $activeRoute = false;
    public $allowImgFileExt = ['jpg', 'png'];
    public $allowVideoFileExt = ['mp4', 'mov', 'avi', 'wmv', 'm4v'];
    public $maxImageSize = 3; // MB
    public $maxVideoSize = 50; // MB
    public $enableGooglePlaces = false;
    public $select_lema;
    /**
     * Inicializa el componente
     */
    public function mount(): void
    {
        try {
            $this->isLoading = true;
            $this->profileService = new ProfileService(Auth::id());
            $this->loadConfiguration();
            $this->loadUserData();
            $this->activeRoute = Route::currentRouteName();
        } catch (\Exception $e) {
            Log::error('Error al cargar datos del perfil: ' . $e->getMessage());
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.error_loading_profile'));
        } finally {
            $this->isLoading = false;
        }
    }

    /**
     * Verifica si el servicio está inicializado
     */
    private function ensureProfileService(): void
    {
        if ($this->profileService === null) {
            $this->profileService = new ProfileService(Auth::id());
        }
    }

    /**
     * Carga la configuración del sistema
     */
    private function loadConfiguration(): void
    {
        $this->enableGooglePlaces = setting('_api.enable_google_places') == '1';
        $this->allowImgFileExt = explode(',', setting('_general.allowed_image_extensions') ?? 'jpg,png');
        $this->allowVideoFileExt = explode(',', setting('_general.allowed_video_extensions') ?? 'mp4');
    }

    /**
     * Carga los datos del usuario
     */
    private function loadUserData(): void
    {
        $profile = $this->profileService->getUserProfile();

        // Consulta directa a user_languages para el usuario actual
        $userLanguages = UserLanguage::where('user_id', Auth::id())
            ->pluck('language_id')
            ->toArray();
        $this->user_languages = $userLanguages;
        $this->first_name = $profile?->first_name ?? '';
        $this->last_name = $profile?->last_name ?? '';
        $this->email = Auth::user()?->email;
        $this->phone_number = $profile?->phone_number ?? '';
        $this->gender = $this->normalizeGender($profile?->gender ?? 3);
        $this->description = $profile?->description ?? '';
        $this->image = $profile?->image ?? '';
        $this->intro_video = $profile?->intro_video ?? '';
        $this->native_language = $profile?->native_language ?? '';
        $this->selected_lema = $profile?->tagline ?? null;

    }

    /**
     * Normaliza el valor de género a int (1,2,3)
     */
    private function normalizeGender($value)
    {
        $valid = [1, 2, 3];
        if (in_array($value, $valid, true))
            return $value;
        // Si viene como string, mapea
        $map = [
            'male' => 1,
            'female' => 2,
            'not_specified' => 3,
            'masculino' => 1,
            'femenino' => 2,
            'no_especificado' => 3,
        ];
        return $map[$value] ?? 3;
    }

    /**
     * Renderiza la vista
     */
    #[Layout('layouts.app')]
    public function render(Request $request)
    {
        try {
            $states = null;
            $countries = Country::orderBy('name')->get();
            $languages = Language::get(['id', 'name'])->pluck('name', 'id');
            if (!empty($this->country)) {
                $states = $this->profileService->countryStates($this->country);
                $this->hasStates = $states->isNotEmpty();
            }
            return view('livewire.pages.common.profile-settings.personal-details', [
                'countries' => $countries,
                'states' => $states,
                'languages' => $languages
            ]);
        } catch (\Exception $e) {
            Log::error('Error al renderizar vista de perfil: ' . $e->getMessage());
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.error_loading_view'));
            return view('livewire.pages.common.profile-settings.personal-details', [
                'countries' => collect(),
                'states' => collect(),
                'languages' => collect()
            ]);
        }
    }




    /**
     * Actualiza la información del perfil
     */
    public function updateInfo()
    {
        try {
            $this->ensureProfileService();
            $this->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'phone_number' => 'required|string|max:20',
                'description' => 'string|max:500',
            ], [
                // Mensajes personalizados (opcional)
            ], [
                'first_name' => __('profile.first_name'),
                'last_name' => __('profile.last_name'),
                'phone_number' => __('profile.phone_number'),
                'description' => __('profile.description'),
            ]);

            // El valor de género ya es int desde el front
            $profileData = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone_number' => $this->phone_number,
                'gender' => $this->gender,
                'slug' => $this->slug,
                'description' => $this->description,
                'native_language' => $this->native_language,
                'tagline' => $this->selected_lema,
            ];

            if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Guardar temporalmente en storage
                $filename = time() . '_' . $this->image->getClientOriginalName();
                $tempPath = $this->image->storeAs('temp', $filename);
                // Mover a public/profile_images
                $destinationPath = public_path('storage/profile_images');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filename);
                $profileData['image'] = 'profile_images/' . $filename;
                // Generar miniatura de la imagen
                if (!empty($profileData['image'])) {
                    $this->dispatch('update_image', image: resizedImage($profileData['image'], 36, 36));
                }
            }
            if ($this->intro_video instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Guardar temporalmente en storage
                $filename = time() . '_' . $this->intro_video->getClientOriginalName();
                $tempPath = $this->intro_video->storeAs('temp', $filename);
                // Mover a public/storage/profile_videos
                $destinationPath = public_path('storage/profile_videos');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filename);
                $profileData['intro_video'] = 'profile_videos/' . $filename;
            }

            $this->profileService->setUserProfile($profileData); // Guarda los datos
            $this->profileService->storeUserLanguages($this->user_languages); // Guardar los IDs de idiomas directamente
            // Enviar correo notificando el cambio de perfil
            try {
                $user = Auth::user();
                $fechaHora = now()->format('d/m/Y H:i');
                $contenido = "El usuario {$user->name} ({$user->email}) ha actualizado su perfil el {$fechaHora}.\n\nDatos actualizados:\n";
                foreach ($profileData as $key => $value) {
                    $contenido .= ucfirst(str_replace('_', ' ', $key)) . ': ' . $value . "\n";
                }
                Mail::raw($contenido, function ($message) use ($user) {
                    $message->to(config('mail.from.address'))
                        ->subject('Notificación de actualización de perfil');
                });
            } catch (\Exception $e) {
                Log::error('Error al enviar correo de actualización de perfil: ' . $e->getMessage());
            }

            $this->dispatch('showAlertMessage', type: 'success', message: __('general.success_message'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.error_message'));
        }
    }

    /**
     * Convierte el string de género a integer según GenderCast
     */
    private function genderStringToInt($value)
    {
        $map = [
            'male' => 1,
            'female' => 2,
            'not_specified' => 3,
            // Por compatibilidad con español
            'Masculino' => 1,
            'Femenino' => 2,
            'no_especificado' => 3,
        ];
        return $map[$value] ?? 3;
    }
    public function updatedIntroVideo($value)
    {

        $this->isUploadingVideo = true;
        try {
            $this->validate([
                'intro_video' => 'file|max:' . ($this->maxVideoSize * 1024) . '|mimes:' . implode(',', $this->allowVideoFileExt)
            ], [
                'intro_video.file' => 'El archivo debe ser un video válido.',
                'intro_video.mimes' => 'El video debe ser de tipo: ' . implode(', ', $this->allowVideoFileExt)
            ]);
            $this->videoName = $value->getClientOriginalName();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->videoName = '';
            $this->intro_video = null;
            $this->addError('intro_video', $e->validator->errors()->first('intro_video'));
        } finally {
            $this->isUploadingVideo = false;
        }
    }

    public function updatedImage($value)
    {
        $this->isUploadingImage = true;
        try {
            $this->validate([
                'image' => 'image|max:' . ($this->maxImageSize * 1024) . '|mimes:' . implode(',', $this->allowImgFileExt)
            ], [
                'image.image' => 'El archivo debe ser una imagen válida.',
                'image.max' => 'La imagen no debe superar ' . $this->maxImageSize . 'MB.',
                'image.mimes' => 'La imagen debe ser de tipo: ' . implode(', ', $this->allowImgFileExt)
            ]);
            $this->imageName = $value->getClientOriginalName();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->imageName = '';
            $this->image = null;
            $this->addError('image', $e->validator->errors()->first('image'));
        } finally {
            $this->isUploadingImage = false;
        }
    }



    /**
     * Elimina archivos multimedia
     */
    public function removeMedia($type)
    {
        try {
            if ($type === 'image') {
                if ($this->image && !$this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    Storage::disk('public')->delete($this->image);
                }
                $this->image = null;
                $this->imageName = '';
            } else if ($type === 'video') {
                if ($this->intro_video && !$this->intro_video instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    Storage::disk('public')->delete($this->intro_video);
                }
                $this->intro_video = null;
                $this->videoName = '';
            }
        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo: ' . $e->getMessage());
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.error_removing_file'));
        }
    }

    /**
     * Elimina un idioma de la lista de idiomas seleccionados
     */
    public function removeLanguage($languageId)
    {
        try {
            if (($key = array_search($languageId, $this->user_languages)) !== false) {
                unset($this->user_languages[$key]);
                $this->user_languages = array_values($this->user_languages); // Reindexar el array
                Log::info('Idioma eliminado:', ['language_id' => $languageId, 'remaining_languages' => $this->user_languages]);
            }
        } catch (\Exception $e) {
            Log::error('Error al eliminar idioma: ' . $e->getMessage());
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.error_removing_language'));
        }
    }

    /**
     * Maneja la actualización del país
     */
    public function updatedCountry($value)
    {
        $this->state = null;
        $this->hasStates = false;
    }

    /**
     * Busca países por término
     */
    public function searchCountries($term = '')
    {
        return Country::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name as text')
            ->take(20)
            ->get()
            ->toArray();
    }

    public function updatedSelectedLanguages($value)
    {
        if (is_array($value)) {
            foreach ($value as $langId) {
                if (!in_array($langId, $this->user_languages) && $langId != $this->native_language) {
                    $this->user_languages[] = $langId;
                }
            }
        } else {
            if (!in_array($value, $this->user_languages) && $value != $this->native_language) {
                $this->user_languages[] = $value;
            }
        }
        $this->selected_languages = [];
    }
    public function selectLema($index)
    {
        $this->selected_lema = $this->personalStatements[$index];
        // dd($this->selected_lema);
    }
    public function removeLema()
{
    $this->selected_lema = null;
    // dd($this->selected_lema);
}
}
