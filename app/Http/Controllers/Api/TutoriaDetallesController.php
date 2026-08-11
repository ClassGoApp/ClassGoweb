<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SlotBookingService;
use Illuminate\Http\Request;

class TutoriaDetallesController extends Controller
{
    private $slotBookingService;
    public function __construct(SlotBookingService $slotBookingService_) {
        $this->slotBookingService = $slotBookingService_;
    }


    public function getMyTutorias(Request $request){
        return response()->json($request->user());
    } 
}
