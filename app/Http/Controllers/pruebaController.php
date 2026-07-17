<?php

namespace App\Http\Controllers;

use App\Models\SlotBooking;
use App\Models\User;
use App\Services\GoogleMeetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class pruebaController extends Controller
{
    public function debugMeetLink($id)
    {
        $tutoria = SlotBooking::findOrFail($id);

        $link = $this->generarlink($tutoria);

        return response()->json([
            'ok' => (bool) $link,
            'tutoria_id' => $tutoria->id,
            'start_time' => $tutoria->start_time,
            'link' => $link,
        ]);
    }

    public function generarlink($tutoria)
    {
        $googlemeetservice = new GoogleMeetService();

        $startTimeCarbon = Carbon::parse($tutoria->start_time, 'America/La_Paz');
        $durationInMinutes = 20;

        $meetingData = [
            'topic' => 'Tutoría',
            'agenda' => 'Sesión de tutoría',
            'start_time' => $startTimeCarbon->toIso8601String(),
            'end_time' => $startTimeCarbon->copy()->addMinutes($durationInMinutes)->toIso8601String(),
            'timezone' => 'America/La_Paz',
            'duration' => 20,
        ];

        $user = User::find($tutoria->tutor_id);

        if (!$user) {
            Log::error("No existe tutor para tutor_id={$tutoria->tutor_id}");
            return null;
        }

        try {
            return $googlemeetservice->createMeetingPorTutord($meetingData, $user);
        } catch (\Throwable $e) {
            Log::error('Error al crear Google Meet: ' . $e->getMessage());
            return null;
        }
    }
}
