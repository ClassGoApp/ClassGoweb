<?php

namespace App\Mail;

use COM;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;

class TutoriaInstanteAceptada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public int $bookingId,
        public string $subjectName,
        public string $tutorName,
        public string $studentName,
        public string $startTime,
        public string $endTime,
        public string $meetingLink,
    ) {}

    public function build()
    {
        return $this->subject("Tutoría aceptada #{$this->bookingId}")
                    ->view('emails.confirmationTutorInstant')
                    ->with([
                        'sessionId'    => $this->bookingId,
                        'subjectName'  => $this->subjectName,
                        'tutorName'    => $this->tutorName,
                        'studentName'  => $this->studentName,
                        'startTime'    => Carbon::parse($this->startTime)->format('H:i'),
                        'endTime'      => Carbon::parse($this->endTime)->format('H:i'),
                        'meetLink'     => $this->meetingLink,
                        'durationLabel'=> $this->calculateDuration($this->startTime, $this->endTime),
                    ]);
    }

    private function calculateDuration(string $start, string $end): string
    {
        $startTime = \Carbon\Carbon::parse($start);
        $endTime = \Carbon\Carbon::parse($end);
        $minutes = $startTime->diffInMinutes($endTime);
        return "{$minutes} minutos";
    }
}
