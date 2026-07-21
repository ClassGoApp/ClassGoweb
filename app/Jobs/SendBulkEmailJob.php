<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BulkEmailNotification;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emails;
    public $subject;
    public $body;
    public $attachmentFiles;
    public $imageFiles;

    /**
     * Create a new job instance.
     */
    public function __construct($emails, $subject, $body, $attachmentFiles = [], $imageFiles = [])
    {
        $this->emails = $emails;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachmentFiles = $attachmentFiles;
        $this->imageFiles = $imageFiles;
    }

    /**
     * Execute the job.
     */
    public function handle(): array
    {
        $successCount = 0;
        $failureCount = 0;
        $failedEmails = [];

        Log::info('SendBulkEmailJob iniciado', [
            'total_emails' => count($this->emails),
            'subject' => $this->subject,
            'has_attachments' => count($this->attachmentFiles) > 0,
            'has_images' => count($this->imageFiles) > 0,
        ]);

        foreach ($this->emails as $email) {
            try {
                $mailable = new BulkEmailNotification(
                    $this->subject,
                    $this->body,
                    is_array($this->attachmentFiles) ? $this->attachmentFiles : [],
                    is_array($this->imageFiles) ? $this->imageFiles : []
                );

                Mail::to($email)->send($mailable);
                $successCount++;

                Log::debug('Email enviado exitosamente', [
                    'email' => $email,
                    'subject' => $this->subject,
                ]);

            } catch (\Exception $e) {
                $failureCount++;
                $failedEmails[] = $email;

                Log::error('Error al enviar email', [
                    'email' => $email,
                    'subject' => $this->subject,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        Log::info('SendBulkEmailJob completado', [
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'failed_emails' => $failedEmails,
        ]);

        return [
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'total_count' => count($this->emails),
            'failed_emails' => $failedEmails,
        ];
    }
}
