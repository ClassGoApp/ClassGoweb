<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use App\Livewire\Forms\Common\ProfileSettings\PersonalDetailsForm;
use App\Models\Country;
use App\Models\Language;
use App\Models\Subject;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PersonalDetails extends Component
{
    use WithFileUploads;

    public PersonalDetailsForm $form;
    public $search = '';

    public $allowImgFileExt = [];
    public $allowVideoFileExt = [];
    public $allowImageSize  = '';
    public $allowVideoSize = '';
    public $googleApiKey = '';
    public $fileExt = '';
    public $isLoading = true;
    public $imageFileSize = '';
    public $videoFileSize = '';
    public $vedioExt = '';
    public $languages = [];
    public $tutorSubjects = [];
    public $countries = null;
    public $hasStates = false;
    public $introVideo;
    public $isProfilePhoneMendatory = true;
    public $isProfileVideoMendatory = true;
    public $isProfileKeywordsMendatory = true;
    private ?ProfileService $profileService = null;
    public $MAX_PROFILE_CHAR = 500;
    public $activeRoute = false;

    #[Layout('layouts.app')]
    public function render(Request $request)
    {
        $enableGooglePlaces = setting('_api.enable_google_places') ?? '0';
        $states = null;

        // Si es una solicitud AJAX de Select2, devolver los resultados filtrados
        if ($request->ajax() && $request->has('search')) {
            $countries = Country::where('name', 'like', '%' . $request->search . '%')
                ->get()
                ->map(function($country) {
                    return [
                        'id' => $country->id,
                        'text' => $country->name
                    ];
                });
            return response()->json($countries);
        }

        if (!empty($this->form->country)) {
            $states = $this->profileService->countryStates($this->form->country);
            if ($states->isNotEmpty()) {
                $this->hasStates = true;
                $this->dispatch('initSelect2', target: '#country_state', timeOut: 0);
            } else {
                $this->hasStates = false;
            }
        }

        // Cargar países iniciales si no es una búsqueda
        if (!$this->countries) {
            $this->countries = Country::orderBy('name')->get();
        }

        return view('livewire.pages.common.profile-settings.personal-details', compact('enableGooglePlaces', 'states'));
    }

    public function searchCountries($term = '')
    {
        
        $countries = Country::where('name', 'like', '%' . $term . '%')
            ->select('id', 'name as text') // Seleccionar y renombrar para Select2
            ->take(20) // Limitar resultados para eficiencia
            ->get()
            ->toArray();
        
        return $countries;
    }

    public function boot()
    {
        $this->profileService = new ProfileService(Auth::user()->id);
    }

    public function loadData()
    {
        $this->isLoading            = false;
        \Log::info('Dispatching loadPageJs event from loadData()');
        $this->dispatch('loadPageJs');
    }

    public function mount(): void
    {
        $this->isProfilePhoneMendatory = setting('_lernen.profile_phone_number') == 'yes' ? true : false;
        $this->isProfileVideoMendatory = setting('_lernen.profile_video') == 'yes' ? true : false;
        $this->isProfileKeywordsMendatory = setting('_lernen.profile_keywords') == 'yes' ? true : false;
        $this->languages = Language::get(['id', 'name'])?->pluck('name', 'id')?->toArray();
        $this->tutorSubjects = Subject::get(['id', 'name'])?->pluck('name', 'id')?->toArray();
        $this->countries = Country::get(['id', 'name']);
        $profile = $this->profileService->getUserProfile();
        $address = $this->profileService->getUserAddress();
        $socialProfiles = $this->profileService->getSocialProfiles();
        $languages = $this->profileService->getUserLanguages();
        $this->activeRoute = Route::currentRouteName();
        $this->form->getInfo($profile);
        $this->form->setUserAddress($address);
        $socialProfiles = $this->profileService->getSocialProfiles();
        $this->form->setSocialProfiles($socialProfiles);
        $this->form->setUserLanguages($languages);
        $image_file_ext          = setting('_general.allowed_image_extensions');
        $image_file_size         = setting('_general.max_image_size');
        $video_file_size         = setting('_general.max_video_size');
        $video_file_ext          = setting('_general.allowed_video_extensions');
        $this->fileExt           =  $image_file_ext;
        $this->vedioExt          =  $video_file_ext;
        $this->imageFileSize     =  $image_file_size;
        $this->videoFileSize     =  $video_file_size;
        $this->googleApiKey      = setting('_api.google_places_api_key');
        $this->allowImageSize    = (int) (!empty($image_file_size) ? $image_file_size : '3');
        $this->allowImgFileExt   = !empty($image_file_ext) ?  explode(',', $image_file_ext) : ['jpg', 'png'];
        $this->allowVideoSize    = (int) (!empty($video_file_size) ? $video_file_size : '20');
        $this->allowVideoFileExt = !empty($video_file_ext) ?  explode(',', $video_file_ext) : [];
        
        if (Session::get('error')) {
            $this->dispatch('showAlertMessage', type: 'error', message: Session::get('error'));
        }
    }

       public function updateInfo()
    {
       
      
    
        $form = $this->form;
    
        if (!empty($this->introVideo)) {
            $this->form->setVideo($this->introVideo);
        }
    
        \Log::info('/log: Este es un mensaje de prueba en el log.');
        $form->validateForm($this->hasStates);
                \Log::info('/log: Datos del perfil', json_decode(json_encode($form), true));
          \Log::info('/entro al validateform.');
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        
       
    
        $this->introVideo = null;
        $data = $form->updateProfileInfo();
        $address = $form->userAddress();
          
        $this->profileService->setUserProfile($data);
        $this->profileService->storeUserLanguages($form->user_languages);
        $this->profileService->setUserAddress($address);
        $socialsProfiles = $form->socialProfiles();
    
        if (!empty($socialsProfiles)) {
            $this->profileService->setSocialProfiles($socialsProfiles);
        }
    
       
        $this->dispatch('profile-img-updated', image: resizedImage($form->image, 36, 36));
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('general.success_message'));
    }

    public function updatingForm($value, $key)
    {
        if ($key == 'country') {
            $this->form->state = null;
        }
    }

    public function updatedIntroVideo()
    {
        // dd($this->allowVideoFileExt, $this->allowVideoSize);
        $this->validate(['introVideo' => 'required|mimes:' . (!empty($this->allowVideoFileExt) ? implode(',', $this->allowVideoFileExt) : 'mp4')  . '|max:' . (!empty($this->allowVideoSize) ? $this->allowVideoSize : 20) * 1024]);
    }

    public function removeMedia($type)
    {
        if ($type == 'video') {
            $this->introVideo = null;
            $this->form->removeVideo();
        } else {
            $this->form->removePhoto();
        }
    }

    public function updatedFormCountry($value)
    {
        $this->form->state = null; // Resetear el estado seleccionado
        // La propiedad $hasStates se recalculará automáticamente en el siguiente render
        // que Livewire dispara después de esta actualización.
        Log::info('Country changed, state reset. Country ID: ' . $value);
    }
}
