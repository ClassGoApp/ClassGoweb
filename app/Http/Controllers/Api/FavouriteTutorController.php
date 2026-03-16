<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavouriteTutorController extends Controller
{
    use ApiResponser;

    public function index()
    {

        if (Auth::user()->role  !== 'student') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $userService  = new UserService(Auth::user());
        $favourites   = $userService->getFavouriteUsers()
        ->with(['profile:id,user_id,slug,first_name,last_name,image,native_language,verified_at',
                'address:id,addressable_id,addressable_type,country_id','languages:id,name'])
        ->with(['subjects' => function ($query) {
            $query->withCount('slotBookings as sessions')->take(1);
        }])
        ->withMin('userSubjects as min_price', 'price')
        ->withAvg('reviews', 'rating')
        ->withCount(['bookingSlots as active_students' => function($query){
            $query->whereStatus('active');
        }])
        ->get();
        return $this->success(data: UserResource::collection($favourites));
    }

    public function update($userId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $userService = new UserService(Auth::user());

        $user = User::find($userId)?->load('profile');

        if(empty($user)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if ($user->role  !== 'tutor') {
            return $this->error(data: null,message: __('api.only_tutors_can_be_added_to_favorites'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()->role  !== 'student') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $isFavourite = $userService->isFavouriteUser($userId);

        if ($isFavourite) {
            $userService->removeFromFavourite($userId);
            $message = $user->profile->full_name . ' ' . __('api.has_been_removed_from_favorites');
        } else {
            $userService->addToFavourite($userId);
            $message = $user->profile->full_name . ' ' . __('api.has_been_added_to_favorites');
        }

        return $this->success(null, $message);

    }
    public function getFavouriteUsers($userId) {
        $user = User::find($userId)?->load('profile');

        if (empty($user)) {
            return $this->error(data: null, message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $userService  = new UserService($user);

        $favourites = $userService->getFavouriteUsers()
            ->with(['profile:id,user_id,slug,first_name,last_name,image,native_language,verified_at'])
            ->get();

        return $this->success(data: UserResource::collection($favourites));
    }

    public function addToFavourite($studentId, $tutorId)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        $student = User::find($studentId)?->load('profile');
        if (empty($student)) {
            return $this->error(data: null, message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($student->role !== 'student') {
            return $this->error(data: null, message: __('api.only_students_can_add_favorites'), code: Response::HTTP_FORBIDDEN);
        }

        $tutor = User::find($tutorId)?->load('profile');
        if (empty($tutor)) {
            return $this->error(data: null, message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($tutor->role !== 'tutor') {
            return $this->error(data: null, message: __('api.only_tutors_can_be_added_to_favorites'), code: Response::HTTP_FORBIDDEN);
        }

        $userService = new UserService($student);

        if ($userService->isFavouriteUser($tutorId)) {
            $message = $tutor->profile->full_name . ' ' . __('api.has_been_added_to_favorites');
            return $this->success(null, $message);
        }

        $userService->addToFavourite($tutorId);

        $message = $tutor->profile->full_name . ' ' . __('api.has_been_added_to_favorites');
        return $this->success(null, $message);
    }
    public function removeFromFavourite($studentId, $tutorId)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        $student = User::find($studentId)?->load('profile');
        if (empty($student)) {
            return $this->error(data: null, message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($student->role !== 'student') {
            return $this->error(data: null, message: __('api.only_students_can_remove_favorites'), code: Response::HTTP_FORBIDDEN);
        }

        $tutor = User::find($tutorId)?->load('profile');
        if (empty($tutor)) {
            return $this->error(data: null, message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($tutor->role !== 'tutor') {
            return $this->error(data: null, message: __('api.only_tutors_can_be_removed_from_favorites'), code: Response::HTTP_FORBIDDEN);
        }

        $userService = new UserService($student);

        if (!$userService->isFavouriteUser($tutorId)) {
            $message = $tutor->profile->full_name . ' ' . __('api.is_not_in_favorites');
            return $this->success(null, $message);
        }

        $userService->removeFromFavourite($tutorId);

        $message = $tutor->profile->full_name . ' ' . __('api.has_been_removed_from_favorites');
        return $this->success(null, $message);
    }
}
