<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TutoriaInstanteNotificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $tutorName,
        public string $subjectName,
        public int $subjectId,
        public string $gifUrl,
        public string $description,
        public ?string $buttonUrl = null,
        public ?string $buttonText = null,
    ) {}

    public function build()
    {
        return $this->subject("ClassGo | Tutoría instantánea (Materia {$this->subjectId})")
            ->view('emails.tutoria-instante-notificacion')
            ->with([
                'tutorName'   => $this->tutorName,
                'subjectName' => $this->subjectName,
                'subjectId'   => $this->subjectId,
                'gifUrl'      => $this->gifUrl,
                'description' => $this->description,
                'buttonUrl'   => $this->buttonUrl,
                'buttonText'  => $this->buttonText,
            ]);
    }
}
