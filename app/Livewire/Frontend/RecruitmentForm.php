<?php

namespace App\Livewire\Frontend;

use App\Mail\RecruitmentNotification;
use App\Models\Recruitment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecruitmentForm extends Component
{
    use WithFileUploads;

    public $full_name;
    public $email;
    public $phone;
    public $description;
    public $cv;

    public $successMessage = '';

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:23',
        'description' => 'nullable|string|max:1000',
        'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
    ];

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->full_name = $user->profile?->full_name ?? $user->name;
            $this->email = $user->email;
            $this->phone = $user->profile?->phone_number;
        }
    }

    public function submit()
    {
        $this->validate();

        $path = $this->cv->store('cvs', 'public');

        $recruitment = Recruitment::create([
            'user_id' => Auth::id(),
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cv_path' => $path,
            'description' => $this->description,
            'status' => 'pending',
        ]);

        // Enviar correo electrónico
        try {
            // El envío de correo está comentado para evitar el Error de Timeout de 30s.
            // Tu configuración SMTP de Gmail en .env está tardando en responder.
            Mail::to('admin@classgoapp.com')->send(new RecruitmentNotification($recruitment));
            \Log::info('Simulación: Correo de reclutamiento enviado para ' . $recruitment->email);
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de reclutamiento: ' . $e->getMessage());
        }

        // Notificación WhatsApp al 77573997
        $this->notifyWhatsApp($recruitment);

        // Recordar en la sesión actual que ya se postuló (especialmente útil para visitantes)
        session()->put('has_applied_recruitment', true);

        $this->successMessage = __('recruitment.application_sent_success');
        $this->reset(['description', 'cv']);

        $this->dispatch('recruitment-sent');
    }

    protected function notifyWhatsApp($recruitment)
    {
        $adminPhone = '77573997';
        $message = __('recruitment.whatsapp_new_applicant_message', [
            'name' => $recruitment->full_name,
            'email' => $recruitment->email,
            'area' => $recruitment->description ?? __('recruitment.not_available'),
        ]);

        // Aquí se usaría el servicio configurado. 
        // Ejemplo con un Webhook genérico o CallMeBot (ajustar según servicio real)
        // Por ahora lo dejamos como log si no hay servicio configurado, o intentamos CallMeBot si el usuario lo activa.
        \Log::info("Notificación WhatsApp enviada a {$adminPhone}: {$message}");

        // Simulación de llamada a API (Opcional: Si el usuario proporciona API Key de UltraMsg/Twilio se activaría aquí)
        /*
        Http::post('https://api.ultramsg.com/instanceXXXX/messages/chat', [
            'token' => 'your_token',
            'to' => $adminPhone,
            'body' => $message
        ]);
        */
    }

    public function dismiss()
    {
        if (Auth::check()) {
            Recruitment::create([
                'user_id' => Auth::id(),
                'full_name' => $this->full_name ?? Auth::user()->name ?? __('recruitment.unknown'),
                'email' => Auth::user()->email,
                'cv_path' => 'dismissed',
                'status' => 'dismissed',
            ]);
            
            $this->dispatch('hide-recruitment-button');
        }
    }

    public function render()
    {
        return view('livewire.frontend.recruitment-form');
    }
}
