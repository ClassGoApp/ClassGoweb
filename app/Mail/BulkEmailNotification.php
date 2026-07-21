<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class BulkEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $emailBody;
    public $attachmentFiles;
    public $imageFiles;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $emailBody, $attachmentFiles = [], $imageFiles = [])
    {
        $this->subject = $subject;
        $this->emailBody = $emailBody;
        $this->attachmentFiles = $attachmentFiles;
        $this->imageFiles = $imageFiles;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            from: setting('_email.sender_email') ?? env('MAIL_FROM_ADDRESS', 'noreply@classgo.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bulk-notification',
            with: [
                'body' => $this->emailBody,
                'signature' => setting('_email.sender_signature') ?? '',
                'copyright' => setting('_email.footer_text') ?? '',
            ]
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

        // Adjuntar archivos
        if (!empty($this->attachmentFiles)) {
            foreach ($this->attachmentFiles as $file) {
                if (isset($file['path']) && Storage::disk('local')->exists($file['path'])) {
                    $attachments[] = Attachment::fromPath(
                        Storage::disk('local')->path($file['path'])
                    )->as($file['name']);
                }
            }
        }

        // Adjuntar imágenes
        if (!empty($this->imageFiles)) {
            foreach ($this->imageFiles as $image) {
                if (isset($image['path']) && Storage::disk('local')->exists($image['path'])) {
                    $attachments[] = Attachment::fromPath(
                        Storage::disk('local')->path($image['path'])
                    )->as($image['name']);
                }
            }
        }

        return $attachments;
    }
}
