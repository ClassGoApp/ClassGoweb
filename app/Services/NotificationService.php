<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class NotificationService
{

    public function getEmailTemplate($type = '', $role = ''): array | NULL
    {
        return EmailTemplate::where(function ($query) use ($type, $role) {
            $query->whereType($type);
            if ($role)
                $query->whereRole($role);
            $query->whereStatus('active');
        })->first()?->toArray();
    }


    public function parseEmailTemplate($type, $role, $data)
    {
        Log::info("📩 Buscando template", ['type' => $type, 'role' => $role]);
    
        // Si es template de registro para admin, usar template manual
        if ($type === 'registration' && $role === 'admin') {
            Log::info("🎯 Usando template manual para admin");
            return $this->getRegistrationEmail(null, $data);
        }
    
        $emailTemplate = array();
        $template = $this->getEmailTemplate($type, $role);
    
        if (!$template) {
            Log::error("❌ No se encontró el template '{$type}' para el rol '{$role}'");
            return null; // Devuelve null para evitar errores más adelante
        }
    
        Log::info("✅ Template encontrado", ['template' => $template]);
    
        $content = $template['content'] ?? null;
    
        if (empty($content)) {
            Log::error("❌ El contenido del template '{$type}' está vacío o no definido.");
            return null;
        }
    
        // Generar el nombre del método dinámicamente
        $parseFunction = "get" . Str::ucfirst(Str::camel($type)) . "Email";
        
        Log::info("🔎 Buscando el método de parseo", ['method' => $parseFunction]);
    
        if (!method_exists($this, $parseFunction)) {
            Log::error("❌ Método '{$parseFunction}' no existe en la clase " . get_class($this));
            return null;
        }
    
        // Ejecutar la función de parseo del email
        $emailTemplate = $this->$parseFunction($content, $data);
    
        Log::info("✅ Template procesado correctamente");
    
        return $emailTemplate;
    }
    

    public function getRegistrationEmail($content, $data)
    {
        // Si no hay content, es para admin (template manual)
        if ($content === null) {
            Log::info("🎯 Generando template manual para admin");
            return [
                'subject' => 'Notificación de registro de nuevo usuario',
                'greeting' => 'Estimado administrador,',
                'content' => $this->generateAdminRegistrationContent($data),
                'show_button' => false
            ];
        }
        
        // Template normal para el usuario con verificación
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
            $content[$key] = Str::replace('{userRole}', $data['userRole'] ?? 'unknown', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{verificationLink}')) {
            // Enlace web universal para verificación (sirve para web y app)
            $verifyUrl = 'https://classgoapp.com/verify?id=' . $data['key'] . '&hash=' . sha1($data['userEmail']);
            $btnHtml = view('components.email.button', ['btnText' => 'Verificar cuenta', 'btnUrl' => $verifyUrl])->render();
            $emailTemplate['content'] = Str::replace('{verificationLink}', $btnHtml, $emailTemplate['content']);
        }
        
        return $emailTemplate;
    }

    /**
     * Genera el contenido del email para admin con información detallada
     */
    private function generateAdminRegistrationContent($data)
    {
        $userName = $data['userName'] ?? 'Usuario';
        $userEmail = $data['userEmail'] ?? 'No especificado';
        $userRole = $data['userRole'] ?? 'unknown';
        
        Log::info("🎯 Generando contenido manual para admin", [
            'userName' => $userName,
            'userEmail' => $userEmail,
            'userRole' => $userRole
        ]);
        
        // Traducir el rol a español
        $roleText = match($userRole) {
            'student' => 'Estudiante',
            'tutor' => 'Tutor',
            'admin' => 'Administrador',
            default => ucfirst($userRole)
        };
        
        return "
        <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                <h3 style='color: #495057; margin: 0 0 15px 0;'>👤 Información del Nuevo Usuario:</h3>
                <ul style='color: #495057; font-size: 14px; line-height: 1.6; list-style-type: none; padding: 0;'>
                    <li style='margin-bottom: 8px;'><strong>Nombre:</strong> {$userName}</li>
                    <li style='margin-bottom: 8px;'><strong>Email:</strong> {$userEmail}</li>
                    <li style='margin-bottom: 8px;'><strong>Rol:</strong> <span style='background-color: #007bff; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;'>{$roleText}</span></li>
                    <li style='margin-bottom: 8px;'><strong>Fecha de Registro:</strong> " . now()->format('d/m/Y H:i:s') . "</li>
                </ul>
            </div>
            
            <div style='background-color: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                <h4 style='color: #0056b3; margin: 0 0 10px 0;'>📋 Acciones Recomendadas:</h4>
                <ul style='color: #0056b3; font-size: 14px; line-height: 1.6;'>
                    <li>Verificar los datos del usuario en el panel de administración</li>
                    <li>Revisar si requiere verificación de identidad</li>
                    <li>Confirmar que tenga una excelente experiencia en la plataforma</li>
                </ul>
            </div>
            
            <div style='background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                <p style='color: #6c757d; font-size: 12px; margin: 0; text-align: center;'>
                    <strong>ClassGo</strong> - Sistema de Notificaciones Automáticas
                </p>
            </div>
        </div>";
    }

    public function getWelcomeEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
        }
        $emailTemplate = $content;
        
        return $emailTemplate;
    }

    public function getEmailVerificationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{verificationLink}')) {
            // Enlace web universal para verificación (sirve para web y app)
            $verifyUrl = 'https://classgoapp.com/verify?id=' . $data['key'] . '&hash=' . sha1($data['userEmail']);
            $btnHtml = view('components.email.button', ['btnText' => 'Verificar cuenta', 'btnUrl' => $verifyUrl])->render();
            $emailTemplate['content'] = Str::replace('{verificationLink}', $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getPasswordResetRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{resetLink}')) {
            $btnUrl = url(route('password.reset', [
                'token' => $data['token'],
                'email' => $data['userEmail'],
            ], false));
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.reset_password_txt'), 'btnUrl' => $btnUrl]);
            $emailTemplate['content']    = Str::replace("{resetLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getIdentityVerificationRequestEmail($content, $data)
    {
        $date = now()->format('F j, Y');
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['identityInfo']['name'], $value);
            $content[$key] = Str::replace('{userRole}', $data['identityInfo']['role'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['identityInfo']['email'], $value);
            $content[$key] = Str::replace('{requestDate}', $date, $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }
    public function getIdentityVerificationApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getidentityVerificationRejectedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getWithdrawWalletAmountRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
            $content[$key] = Str::replace('{withdrawAmount}', '$' . $data['amount'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }


    public function getBookingRescheduledEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{reason}', $data['reason'], $value);
            $content[$key] = Str::replace('{newSessionDate}', $data['newSessionDate'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{viewLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('View Details'), 'btnUrl' => $data['viewDetailLink']]);
            $emailTemplate['content']    = Str::replace("{viewLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getBookingLinkGeneratedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDate}', $data['sessionDate'] ?? '', $value);
            $content[$key] = Str::replace('{sessionSubject}', $data['sessionSubject'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{meetingLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('calendar.join_session'), 'btnUrl' => $data['meetingLink']]);
            $emailTemplate['content']    = Str::replace("{meetingLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getBookingCompletionRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDateTime}', $data['sessionDateTime'] ?? '', $value);
            $content[$key] = Str::replace('{days}', $data['days'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{completeBookingLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('calendar.btn_confirm_complete'), 'btnUrl' => $data['completeBookingLink']]);
            $emailTemplate['content']    = Str::replace("{completeBookingLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getSessionBookingEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
        }

        $emailTemplate = $content;

        if (Str::contains($emailTemplate['content'], '{bookingDetails}')) {
            $bookings = view('components.email.bookings', $data);
            $emailTemplate['content']    = Str::replace("{bookingDetails}", $bookings, $emailTemplate['content']);   
        }
        
        return $emailTemplate;
    }

    /**
     * Genera email de notificación intensa para cambios de estado de tutoría
     */
    public function getIntensiveBookingStatusEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDate}', $data['sessionDate'] ?? '', $value);
            $content[$key] = Str::replace('{sessionTime}', $data['sessionTime'] ?? '', $value);
            $content[$key] = Str::replace('{subject}', $data['subject'] ?? '', $value);
            $content[$key] = Str::replace('{status}', $data['status'] ?? '', $value);
            $content[$key] = Str::replace('{meetingLink}', $data['meetingLink'] ?? '', $value);
            $content[$key] = Str::replace('{urgency}', $data['urgency'] ?? 'normal', $value);
        }

        $emailTemplate = $content;

        // Agregar botón de acción urgente si es necesario
        if (Str::contains($emailTemplate['content'], '{actionButton}')) {
            $btnHtml = view('components.email.urgent-button', [
                'btnText' => 'Ver Detalles de la Tutoría',
                'btnUrl' => route('tutor.bookings.show', $data['bookingId'] ?? '#'),
                'urgency' => $data['urgency'] ?? 'normal'
            ]);
            $emailTemplate['content'] = Str::replace("{actionButton}", $btnHtml, $emailTemplate['content']);
        }
        
        return $emailTemplate;
    }

    public function getSessionRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
            $content[$key] = Str::replace('{studentEmail}', $data['studentEmail'] ?? '', $value);
            $content[$key] = Str::replace('{sessionType}', $data['sessionType'] ?? '', $value);
            $content[$key] = Str::replace('{message}', $data['message'] ?? '', $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getRenewSubscriptionEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionName}', $data['subscriptionName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionExpiry}', $data['subscriptionExpiry'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{renewalLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('subscriptions::subscription.renew_subscription_btn'), 'btnUrl' => $data['renewalLink']]);
            $emailTemplate['content']    = Str::replace("{renewalLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getParentIdentityVerificationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{parent_name}}', $data['identityInfo']['parent_name'], $value);
            $content[$key] = Str::replace('{{user_details}}', $this->printUserIdentityDetails($data), $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        if (Str::contains($emailTemplate['content'], '{{approve_identity_link}}')) {
            $emailTemplate['content']    = Str::replace("{{approve_identity_link}}", '', $emailTemplate['content']);
            $emailTemplate['show_button'] = true;
            $emailTemplate['button_url'] = route('confirm-identity', $data['identityInfo']['user_id']);
            $emailTemplate['button_text'] = trans('identity.confirm_btn');
        }
        return $emailTemplate;
    }

    public function getParentIdentityConfirmationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        if (Str::contains($emailTemplate['content'], '{{approve_profile_link}}')) {
            $emailTemplate['content']    = Str::replace("{{approve_profile_link}}", '', $emailTemplate['content']);
            $emailTemplate['show_button'] = true;
            $emailTemplate['button_url'] = route('admin.approve-user-identity', $data['user_id']);
            $emailTemplate['button_text'] = trans('identity.confirm_btn');
        }
        return $emailTemplate;
    }

    public function getAccountIdentityApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getNewMessageEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{messageSender}', $data['messageSender'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAcceptedWithdrawRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
            $content[$key] = Str::replace('{withdrawAmount}', $data['amount'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAccountIdentityRejectionEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
            $content[$key] = Str::replace('{{admin_message}}', $data['message'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getUserCreatedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
            $content[$key] = Str::replace('{{user_email}}', $data['user_email'], $value);
            $content[$key] = Str::replace('{{password}}', $data['user_password'], $value);
            $content[$key] = Str::replace('{{admin_name}}', $data['admin_name'], $value);
            $content[$key] = Str::replace('{{site_name}}', setting('site.name') ?? env('APP_NAME'), $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAccountApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getInviteUserEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{forumTopicTitle}', $data['forumTopicTitle'], $value);
            $content[$key] = Str::replace('{message}', $data['message'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{inviteLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.btn_invite'), 'btnUrl' => $data['inviteLink']]);
            $emailTemplate['content']  = Str::replace("{inviteLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }
    public function getDisputeReasonEmail($content, $data) {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{sessionDateTime}', \Carbon\Carbon::parse($data['sessionDateTime'])->format('F j, Y, g:i A'), $value);
            $content[$key] = Str::replace('{disputeReason}', $data['disputeReason'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;  
    }
    public function getDisputeResolutionEmail($content, $data) {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{sessionDateTime}', \Carbon\Carbon::parse($data['sessionDateTime'])->format('F j, Y, g:i A'), $value);
            $content[$key] = Str::replace('{paymentAmount}', $data['paymentAmount'], $value);
            $content[$key] = Str::replace('{disputeReason}', $data['disputeReason'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }
    public function printUserIdentityDetails($identityInfo) {
        $info = '<br />';
        $info .= '<b>' . trans('identity.name') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['name']) . "<br>";
        // $info .= '<b>' . trans('identity.phone') . '</b> :' . $identityInfo['phone'] . "<br>";
        if (!empty($identityInfo['identityInfo']['email']))
            $info .= '<b>' . trans('identity.email') . '</b> :' . $identityInfo['identityInfo']['email'] . "<br>";
        if (!empty($identityInfo['identityInfo']['gender']))
            $info .= '<b>' . trans('identity.gender') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['gender']) . "<br>";
        if (!empty($identityInfo['identityInfo']['school_name']))
            $info .= '<b>' . trans('identity.school') . '</b> :' . $identityInfo['identityInfo']['school_name'] . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_name']))
            $info .= '<b>' . trans('identity.parent_name') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['parent_name']) . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_email']))
            $info .= '<b>' . trans('identity.parent_email') . '</b> :' . $identityInfo['identityInfo']['parent_email'] . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_phone']))
            $info .= '<b>' . trans('identity.parent_phone') . '</b> :' . $identityInfo['identityInfo']['parent_phone'] . "<br>";
        if ($identityInfo['identityInfo']['personal_photo'])
            $info .= '<b>' . trans('identity.other_info') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['personal_photo'])) . '"/> <br>';
        if ($identityInfo['identityInfo']['attachments'])
            $info .= '<b>' . trans('identity.other_attachment') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['attachments'])) . '"/> <br>';
        if ($identityInfo['identityInfo']['transcript'])
            $info .= '<b>' . trans('identity.transcript') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['transcript'])) . '"/> <br>';
        return $info;
    }

    public function getcourseApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{courseTitle}', $data['courseTitle'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;

        return $emailTemplate;
    }
    public function getcourseRejectedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{courseTitle}', $data['courseTitle'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }
}
