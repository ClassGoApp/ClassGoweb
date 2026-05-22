<?php

namespace App\Mail;

use App\Models\Recruitment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class RecruitmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $recruitment;

    /**
     * Create a new message instance.
     */
    public function __construct(Recruitment $recruitment)
    {
        $this->recruitment = $recruitment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Nuevo Postulante de Talento - ClassGo!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.recruitment-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->recruitment->cv_path && file_exists(storage_path('app/public/' . $this->recruitment->cv_path))) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/' . $this->recruitment->cv_path))
                ->as('Curriculum_Vitae.pdf');
        }

        return $attachments;
    }
}
