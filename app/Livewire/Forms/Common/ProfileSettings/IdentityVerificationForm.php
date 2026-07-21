<?php

namespace App\Livewire\Forms\Common\ProfileSettings;

use App\Traits\PrepareForValidation;
use App\Http\Requests\Common\Identity\IdentityStoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // 1️⃣ Importamos Str para limpiar nombres
use Livewire\Form;

class IdentityVerificationForm extends Form
{
    use PrepareForValidation;

    public $lng;
    public $lat;
    public $user;
    public $image;
    public $identity;
    public $transcript;
    public string $city = '';
    public string $state = '';
    public $dateOfBirth;
    public string $country = '';
    public string $zipcode = '';
    public $identificationCard;
    public string $address = '';
    public $enableGooglePlaces;
    public $countryName = '';

    public $identificationCardFront;
public $identificationCardBack;

    private ?IdentityStoreRequest $instructorRequest = null;

    public function boot()
    {
        $this->user = Auth::user();
        $this->instructorRequest = new IdentityStoreRequest();
        $this->enableGooglePlaces = setting('_api.enable_google_places') ?? '0';
    }

    public function rules(): array
    {
        return $this->instructorRequest->rules();
    }

    public function messages(): array
    {
        return $this->instructorRequest->messages();
    }


    public function updateInfo($hasState)
{
    $rules = $this->rules();
    if ($hasState) {
        $rules['state'] = 'required|string';
    }

    // 1️⃣ Adaptamos dinámicamente las reglas del Request para soportar las dos caras del carnet
    if (isset($rules['identificationCard'])) {
        $idRules = $rules['identificationCard'];
        $rules['identificationCardFront'] = $idRules;
        $rules['identificationCardBack'] = $idRules;
        unset($rules['identificationCard']); // Eliminamos la regla vieja para evitar que explote
    }

    $this->beforeValidation(['image', 'transcript', 'identificationCardFront', 'identificationCardBack']);
    $this->validate($rules);

    // Generamos un nombre base limpio a partir del nombre real del usuario en el perfil
    $profileName = ($this->user->profile->first_name ?? 'perfil') . ' ' . ($this->user->profile->last_name ?? '');
    $cleanName = Str::slug(trim($profileName));

    // Inicializamos las variables defensivamente para evitar errores de "variable indefinida"
    $personalPhoto = null;
    $transcript = null;
    $attachmentsArray = [];

    // 2️⃣ Procesar Foto Personal con nombre estructurado
    if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $extension = $this->image->getClientOriginalExtension();
        $filename = $cleanName . '-' . time() . '.' . $extension; // Ej: juan-perez-1718824351.jpg
        
        $tempPath = $this->image->storeAs('temp', $filename);

        $destinationPath = public_path('storage/identity_photo');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filename);

        $personalPhoto = 'identity_photo/' . $filename;
    }

    // 3️⃣ Procesar Cédula - CARA FRONTAL con nombre estructurado
    if ($this->identificationCardFront instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $extension = $this->identificationCardFront->getClientOriginalExtension();
        $filenameFront = $cleanName . '-id-front-' . time() . '.' . $extension; // Ej: juan-perez-id-front-1718824351.jpg
        
        $tempPath = $this->identificationCardFront->storeAs('temp', $filenameFront);

        $destinationPath = public_path('storage/identity_photo');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filenameFront);

        $attachmentsArray['front'] = 'identity_photo/' . $filenameFront;
    }

    // 4️⃣ Procesar Cédula - CARA REVERSO con nombre estructurado
    if ($this->identificationCardBack instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $extension = $this->identificationCardBack->getClientOriginalExtension();
        $filenameBack = $cleanName . '-id-back-' . time() . '.' . $extension; // Ej: juan-perez-id-back-1718824351.jpg
        
        $tempPath = $this->identificationCardBack->storeAs('temp', $filenameBack);

        $destinationPath = public_path('storage/identity_photo');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filenameBack);

        $attachmentsArray['back'] = 'identity_photo/' . $filenameBack;
    }

    // 5️⃣ Procesar Récord Académico con nombre estructurado
    if ($this->transcript instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $extension = $this->transcript->getClientOriginalExtension();
        $filename = $cleanName . '-transcript-' . time() . '.' . $extension; // Ej: juan-perez-transcript-1718824351.jpg
        
        $tempPath = $this->transcript->storeAs('temp', $filename);

        $destinationPath = public_path('storage/identity_photo');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }
        rename(storage_path('app/' . $tempPath), $destinationPath . '/' . $filename);

        $transcript = 'identity_photo/' . $filename;
    }

    // 6️⃣ Soporte inteligente y seguro para el nuevo formato de Fecha de Nacimiento
    try {
        // Intenta leer el nuevo formato DD/MM/AAAA proveniente de tu máscara
        $dob = \Carbon\Carbon::createFromFormat('d/m/Y', $this->dateOfBirth)->format('Y-m-d');
    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
        try {
            // Respaldo por si viniera en el formato antiguo (F-d-Y)
            $dob = \Carbon\Carbon::createFromFormat('F-d-Y', $this->dateOfBirth)->format('Y-m-d');
        } catch (\Exception $ex) {
            $dob = null;
        }
    }

    $identityInfo = [
        'personal_photo' => !empty($this->image) ? $personalPhoto : null,
        'user_id' => Auth::user()->id,
        'dob' => $dob,
        // 7️⃣ Guardamos la estructura Front/Back codificada en JSON para tu columna JSON nativa
        'attachments' => $this->user->hasRole('tutor') && !empty($attachmentsArray) ? json_encode($attachmentsArray) : null,
        'transcript' => $this->user->hasRole('student') && !empty($this->transcript) ? $transcript : null,
    ];

    $address = [
        'country_id' => $this->country,
        'state_id' => !empty($this->state) ? $this->state : null,
        'city' => $this->city ?? null,
        'address' => $this->address,
        'zipcode' => $this->enableGooglePlaces != '1' ? $this->zipcode : null,
        'lat' => $this->enableGooglePlaces == '1' ? $this->lat : 0,
        'long' => $this->enableGooglePlaces == '1' ? $this->lng : 0,
    ];

    return [
        'identityInfo' => $identityInfo,
        'address' => $address,
    ];
}

    public function removePhoto()
    {
        $this->image = null;
    }

    public function removeIdentificationCard()
    {
        $this->identificationCard = null;
    }

    public function removeTranscript()
    {
        $this->transcript = null;
    }
}