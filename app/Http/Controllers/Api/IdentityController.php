<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Identity\IdentityStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\IdentityService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\IdentityResource;
use Illuminate\Support\Str;

class IdentityController extends Controller
{
    use ApiResponser;

    public function show($id)
    {
        if($id != Auth::user()->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_UNAUTHORIZED);
        }

        $userIdentity   = new IdentityService(Auth::user());
        $identity       = $userIdentity->getUserIdentityVerification();
        if(!$identity){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $userVerification = $userIdentity->getUserIdentityVerification()->load('address');
        return $this->success(data: new IdentityResource($userVerification),message: __('api.identity_verification_data_retrieved_successfully'));
    }

    public function store(IdentityStoreRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $userIdentity          = new IdentityService(Auth::user());
        $identity              = $userIdentity->getUserIdentityVerification();

        if(Auth::user()->profile?->created_at == Auth::user()->profile?->updated_at){

            return $this->error(data: null,message: __('api.please_complete_and_submit_your_profile_first'),code: Response::HTTP_BAD_REQUEST);
        }

        if($identity){
            $userVerification = $userIdentity->getUserIdentityVerification()->load('address');
            return $this->success(data: new IdentityResource($userVerification),message: __('api.identity_verification_data_submitted_successfully'));
        }


        $verificationData = [
            'user_id'            => Auth::user()->id,
            'name'               => $request->name,
            'dob'                => $request->dateOfBirth,
            'status'             => $request->status,
        ];

        if(Auth::user()->hasRole('student')){
            $verificationData['school_id'] = $request->schoolId;
            $verificationData['school_name'] = $request->schoolName;
            $verificationData['parent_name'] = $request->parentName;
            $verificationData['parent_phone'] = $request->parentPhone;
            $verificationData['parent_email'] = $request->parentEmail;
        }

        if ($request->hasFile('image')) {
            $fileName    = uniqueFileName('public/identity', $request->image->getClientOriginalName());
            $request->image->move(public_path('storage/identity_photo'), $fileName);
            $verificationData['personal_photo'] = 'identity_photo/' . $fileName;
        }

        if(Auth::user()->hasRole('student')){

            if ($request->hasFile('transcript')) {
                $fileName    = uniqueFileName('public/identity', $request->transcript->getClientOriginalName());
                $request->transcript->move(public_path('storage/identity_photo'), $fileName);
                $verificationData['transcript'] = 'identity_photo/' . $fileName;
            }
        } 
        else{
            // Para tutores: procesar ambas caras del carnet y guardar como JSON (igual que Livewire)
            $attachmentsArray = [];
            
            // Generar nombre base limpio a partir del nombre real del usuario
            $cleanName = Str::slug(trim($request->name));
            
            // Procesar foto FRONTAL del carnet
            if ($request->hasFile('identificationCardFront')) {
                $extension = $request->identificationCardFront->getClientOriginalExtension();
                $filenameFront = $cleanName . '-id-front-' . time() . '.' . $extension;
                
                $destinationPath = public_path('storage/identity_photo');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
                
                $request->identificationCardFront->move($destinationPath, $filenameFront);
                $attachmentsArray['front'] = 'identity_photo/' . $filenameFront;
            }
            
            // Procesar foto TRASERA del carnet
            if ($request->hasFile('identificationCardBack')) {
                $extension = $request->identificationCardBack->getClientOriginalExtension();
                $filenameBack = $cleanName . '-id-back-' . time() . '.' . $extension;
                
                $destinationPath = public_path('storage/identity_photo');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
                
                $request->identificationCardBack->move($destinationPath, $filenameBack);
                $attachmentsArray['back'] = 'identity_photo/' . $filenameBack;
            }
            
            // Guardar como JSON (igual que Livewire línea 150)
            if (!empty($attachmentsArray)) {
                $verificationData['attachments'] = json_encode($attachmentsArray);
            }
        }

        

        $addressData = [
            'country_id'        => $request->country,
            'state_id'          => $request->state,
            'city'              => $request->city,
            'address'           => $request->address,
            'zipcode'           => $request->zipcode,
            'lat'               => $request->lat ?? 0,
            'long'              => $request->long ?? 0 ,
        ];


        $user = $userIdentity->setUserIdentityVerification($verificationData);
        $userIdentity->setUserAddress($user?->id,$addressData);
        $userVerification = $userIdentity->getUserIdentityVerification()->load('address');
      
        return $this->success(data: new IdentityResource($userVerification),message: __('api.identity_verification_data_submitted_successfully'));
    }

    public function destroy($id)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $userIdentity     = new IdentityService(Auth::user());
        $identity         = $userIdentity->getUserIdentityVerification();
        if(!$identity){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }
        $userIdentity->deleteUserAddress($identity->id);
        $userIdentity->deleteUserIdentityVerification();
        return $this->success(data: null,message: __('api.delete_successfully'));
    }
}


