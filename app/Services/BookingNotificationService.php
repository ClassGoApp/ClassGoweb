<?php

namespace App\Services;

use App\Models\SlotBooking;
use App\Models\User;
use App\Jobs\SendNotificationJob;
use App\Events\SlotBookingStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingNotificationService
{
    /**
     * Maneja las notificaciones de cambio de estado de tutoría
     * Solo envía notificaciones en casos específicos
     *
     * @param SlotBooking $booking
     * @param string $oldStatus
     * @param string $newStatus
     * @return void
     */
    public function handleStatusChangeNotification(SlotBooking $booking, string $oldStatus, string $newStatus): void
    {
        Log::info('BookingNotificationService: Procesando cambio de estado', [
            'booking_id' => $booking->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'old_status_type' => gettype($oldStatus),
            'new_status_type' => gettype($newStatus)
        ]);

        // Cargar relaciones necesarias
        $booking->load(['tutor', 'booker', 'subject']);

        // Caso 1: Cambio a "Aceptado" - Notificar al tutor Y al estudiante
        if ($newStatus === 'Aceptado' || $newStatus === '1' || $newStatus === 1) {
            Log::info('BookingNotificationService: Enviando notificaciones de aceptación');
            $this->sendAcceptedNotificationToTutor($booking);
            $this->sendAcceptedNotificationToStudent($booking);
        }

        // Caso 2: Cambio a "Cursando" - Notificar solo al estudiante
        if ($newStatus === 'Cursando' || $newStatus === '6' || $newStatus === 6) {
            Log::info('BookingNotificationService: Enviando notificación de cursando');
            $this->sendCursandoNotificationToStudent($booking);
        }

        // // Siempre emitir evento de broadcasting para la app móvil
        // $this->emitBroadcastingEvent($booking, $newStatus);
    }

    /**
     * Envía notificación intensa al tutor cuando la tutoría es aceptada
     *
     * @param SlotBooking $booking
     * @return void
     */
    private function sendAcceptedNotificationToTutor(SlotBooking $booking): void
    {
        try {
            // Obtener el usuario tutor directamente
            $tutor = User::find($booking->tutor_id);
            if (!$tutor) {
                Log::warning('Usuario tutor no encontrado', [
                    'booking_id' => $booking->id,
                    'tutor_id' => $booking->tutor_id
                ]);
                return;
            }

            // Obtener el usuario estudiante directamente
            $student = User::find($booking->student_id);

            $notificationData = [
                'tutorName' => $tutor->profile->full_name ?? 'Tutor',
                'studentName' => $student ? ($student->profile->full_name ?? 'Estudiante') : 'Estudiante',
                'bookingDetails' => [
                    'id' => $booking->id,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'subject' => $booking->subject ? $booking->subject->name : 'Materia no definida',
                    'meeting_link' => $booking->meeting_link ?? 'Enlace no disponible',
                    'status' => 'Aceptado'
                ]
            ];

            // Enviar notificación por email usando template manual
            $this->sendManualEmailToTutor($tutor, $notificationData);

            // Enviar push notification si está configurado
            Log::info('Verificando FCM token del tutor', [
                'tutor_id' => $tutor->id,
                'has_fcm_token' => !empty($tutor->fcm_token),
                'fcm_token_length' => strlen($tutor->fcm_token ?? ''),
                'fcm_token_preview' => $tutor->fcm_token ? substr($tutor->fcm_token, 0, 20) . '...' : 'N/A'
            ]);
            
            if ($tutor->fcm_token) {
                $sessionDate = $booking->start_time ? date('d/m/Y', strtotime($booking->start_time)) : 'Fecha no definida';
                $this->sendPushNotification($tutor, [
                    'title' => '🎉 ¡Tutoría Aceptada!',
                    'body' => "Tu tutoría con {$notificationData['studentName']} ha sido aceptada para el {$sessionDate}",
                    'data' => [
                        'booking_id' => $booking->id,
                        'type' => 'booking_accepted',
                        'status' => 'Aceptado'
                    ]
                ]);
            }

            Log::info('Notificación de aceptación enviada al tutor', [
                'tutor_id' => $tutor->id,
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar notificación de aceptación al tutor', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía notificación al estudiante cuando la tutoría es aceptada
     *
     * @param SlotBooking $booking
     * @return void
     */
    private function sendAcceptedNotificationToStudent(SlotBooking $booking): void
    {
        try {
            // Obtener el usuario estudiante directamente
            $student = User::find($booking->student_id);
            if (!$student) {
                Log::warning('Usuario estudiante no encontrado', [
                    'booking_id' => $booking->id,
                    'student_id' => $booking->student_id
                ]);
                return;
            }

            // Obtener el usuario tutor directamente
            $tutor = User::find($booking->tutor_id);

            $notificationData = [
                'studentName' => $student->profile->full_name ?? 'Estudiante',
                'tutorName' => $tutor ? ($tutor->profile->full_name ?? 'Tutor') : 'Tutor',
                'bookingDetails' => [
                    'id' => $booking->id,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'subject' => $booking->subject ? $booking->subject->name : 'Materia no definida',
                    'meeting_link' => $booking->meeting_link ?? 'Enlace no disponible',
                    'status' => 'Aceptado'
                ]
            ];

            // Enviar notificación por email usando template manual
            $this->sendManualEmailToStudent($student, $notificationData);

            // Enviar push notification si está configurado
            Log::info('Verificando FCM token del estudiante (aceptado)', [
                'student_id' => $student->id,
                'has_fcm_token' => !empty($student->fcm_token),
                'fcm_token_length' => strlen($student->fcm_token ?? ''),
                'fcm_token_preview' => $student->fcm_token ? substr($student->fcm_token, 0, 20) . '...' : 'N/A'
            ]);
            
            if ($student->fcm_token) {
                $sessionDate = $booking->start_time ? date('d/m/Y', strtotime($booking->start_time)) : 'Fecha no definida';
                $this->sendPushNotification($student, [
                    'title' => '✅ Tutoría Aceptada',
                    'body' => "Tu tutoría con {$notificationData['tutorName']} ha sido aceptada para el {$sessionDate}",
                    'data' => [
                        'booking_id' => $booking->id,
                        'type' => 'booking_accepted',
                        'status' => 'Aceptado'
                    ]
                ]);
            }

            Log::info('Notificación de aceptación enviada al estudiante', [
                'student_id' => $student->id,
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar notificación de aceptación al estudiante', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía notificación al estudiante cuando la tutoría cambia a "Cursando"
     *
     * @param SlotBooking $booking
     * @return void
     */
    private function sendCursandoNotificationToStudent(SlotBooking $booking): void
    {
        try {
            // Obtener el usuario estudiante directamente
            $student = User::find($booking->student_id);
            if (!$student) {
                Log::warning('Usuario estudiante no encontrado', [
                    'booking_id' => $booking->id,
                    'student_id' => $booking->student_id
                ]);
                return;
            }

            // Obtener el usuario tutor directamente
            $tutor = User::find($booking->tutor_id);

            $notificationData = [
                'studentName' => $student->profile->full_name ?? 'Estudiante',
                'tutorName' => $tutor ? ($tutor->profile->full_name ?? 'Tutor') : 'Tutor',
                'bookingDetails' => [
                    'id' => $booking->id,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'subject' => $booking->subject ? $booking->subject->name : 'Materia no definida',
                    'meeting_link' => $booking->meeting_link ?? 'Enlace no disponible',
                    'status' => 'Cursando'
                ]
            ];

            // Enviar notificación por email usando template manual
            $this->sendManualEmailToStudent($student, $notificationData);

            // Enviar push notification si está configurado
            Log::info('Verificando FCM token del estudiante (cursando)', [
                'student_id' => $student->id,
                'has_fcm_token' => !empty($student->fcm_token),
                'fcm_token_length' => strlen($student->fcm_token ?? ''),
                'fcm_token_preview' => $student->fcm_token ? substr($student->fcm_token, 0, 20) . '...' : 'N/A'
            ]);
            
            if ($student->fcm_token) {
                $this->sendPushNotification($student, [
                    'title' => '🚀 ¡La tutoría está comenzando!',
                    'body' => "Tu sesión con {$notificationData['tutorName']} está por comenzar. ¡Únete ahora!",
                    'data' => [
                        'booking_id' => $booking->id,
                        'type' => 'booking_cursando',
                        'status' => 'Cursando'
                    ]
                ]);
            }

            Log::info('Notificación de cursando enviada al estudiante', [
                'student_id' => $student->id,
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar notificación de cursando al estudiante', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Emite evento de broadcasting para la app móvil
     *
     * @param SlotBooking $booking
     * @param string $newStatus
     * @return void
     */
    private function emitBroadcastingEvent(SlotBooking $booking, string $newStatus): void
    {
        try {
            event(new SlotBookingStatusChanged($booking->id, $newStatus));
            
            Log::info('Evento de broadcasting emitido', [
                'booking_id' => $booking->id,
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            Log::error('Error al emitir evento de broadcasting', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía notificación push (método placeholder)
     *
     * @param $user
     * @param array $data
     * @return void
     */
    private function sendPushNotification($user, array $data): void
    {
        try {
            // Verificar si el usuario tiene FCM token
            if (!$user->fcm_token) {
                Log::warning('Usuario no tiene FCM token configurado', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                return;
            }

            Log::info('Iniciando envío de push notification', [
                'user_id' => $user->id,
                'fcm_token_exists' => !empty($user->fcm_token),
                'fcm_token_length' => strlen($user->fcm_token),
                'title' => $data['title'] ?? 'Sin título',
                'body' => $data['body'] ?? 'Sin contenido'
            ]);

            // Usar el servicio de Firebase para enviar la notificación
            $fcmService = new \App\Services\FcmService();
            
            $title = $data['title'] ?? 'Notificación';
            $body = $data['body'] ?? 'Tienes una nueva notificación';
            $notificationData = $data['data'] ?? [];

            Log::info('Enviando notificación a Firebase', [
                'user_id' => $user->id,
                'fcm_token' => substr($user->fcm_token, 0, 20) . '...',
                'title' => $title,
                'body' => $body,
                'data' => $notificationData
            ]);

            $result = $fcmService->sendNotification(
                $user->fcm_token,
                $title,
                $body,
                $notificationData
            );

            Log::info('✅ Push notification enviada exitosamente', [
                'user_id' => $user->id,
                'result' => $result,
                'title' => $title,
                'body' => $body
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error al enviar push notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Envía email manual al tutor usando template personalizado
     *
     * @param User $tutor
     * @param array $data
     * @return void
     */
    private function sendManualEmailToTutor(User $tutor, array $data): void
    {
        try {
            $subject = '🎉 ¡Tutoría Aceptada! - ' . ($data['studentName'] ?? 'Estudiante');
            
            Log::info('Iniciando generación de contenido de email para tutor', [
                'tutor_id' => $tutor->id,
                'subject' => $subject
            ]);
            
            $emailContent = $this->generateTutorEmailContent($data);
            
            Log::info('Contenido de email generado, enviando email', [
                'tutor_id' => $tutor->id,
                'content_length' => strlen($emailContent)
            ]);
            
            // Enviar email usando Mail facade
            Mail::send([], [], function ($message) use ($tutor, $subject, $emailContent) {
                $message->to($tutor->email)
                        ->subject($subject)
                        ->html($emailContent);
            });

            Log::info('✅ Email manual enviado exitosamente al tutor', [
                'tutor_id' => $tutor->id,
                'email' => $tutor->email,
                'subject' => $subject
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error al enviar email manual al tutor', [
                'tutor_id' => $tutor->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Envía email manual al estudiante usando template personalizado
     *
     * @param User $student
     * @param array $data
     * @return void
     */
    private function sendManualEmailToStudent(User $student, array $data): void
    {
        try {
            $subject = '✅ Tu tutoría ha sido aceptada - ' . ($data['tutorName'] ?? 'Tutor');
            
            Log::info('Iniciando generación de contenido de email para estudiante', [
                'student_id' => $student->id,
                'subject' => $subject
            ]);
            
            $emailContent = $this->generateStudentEmailContent($data);
            
            Log::info('Contenido de email generado, enviando email', [
                'student_id' => $student->id,
                'content_length' => strlen($emailContent)
            ]);
            
            // Enviar email usando Mail facade
            Mail::send([], [], function ($message) use ($student, $subject, $emailContent) {
                $message->to($student->email)
                        ->subject($subject)
                        ->html($emailContent);
            });

            Log::info('✅ Email manual enviado exitosamente al estudiante', [
                'student_id' => $student->id,
                'email' => $student->email,
                'subject' => $subject
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error al enviar email manual al estudiante', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Genera el contenido del email para el tutor
     *
     * @param array $data
     * @return string
     */
    private function generateTutorEmailContent(array $data): string
    {
        $booking = $data['bookingDetails'];
        $sessionDate = $booking['start_time'] ? date('d/m/Y', strtotime($booking['start_time'])) : 'Fecha no definida';
        $sessionTime = $booking['start_time'] ? date('H:i', strtotime($booking['start_time'])) : 'Hora no definida';

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tutoría Aceptada</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #fff3cd; border: 2px solid #ffc107; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="color: #856404; margin: 0 0 15px 0;">🎉 ¡FELICITACIONES! Tu tutoría ha sido aceptada</h2>
                <p style="color: #856404; font-size: 16px; margin: 0 0 10px 0;"><strong>Hola ' . ($data['tutorName'] ?? 'Tutor') . ',</strong></p>
                <p style="color: #856404; font-size: 16px; margin: 0 0 15px 0;">¡Excelente noticia! Una nueva tutoría ha sido aceptada y está lista para comenzar.</p>
            </div>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #495057; margin: 0 0 15px 0;">📋 Detalles de la Sesión:</h3>
                <ul style="color: #495057; font-size: 14px; line-height: 1.6;">
                    <li><strong>Estudiante:</strong> ' . ($data['studentName'] ?? 'Estudiante') . '</li>
                    <li><strong>Materia:</strong> ' . ($booking['subject'] ?? 'Materia no definida') . '</li>
                    <li><strong>Fecha:</strong> ' . $sessionDate . '</li>
                    <li><strong>Hora:</strong> ' . $sessionTime . '</li>
                    <li><strong>Estado:</strong> <span style="color: #28a745; font-weight: bold;">' . ($booking['status'] ?? 'Aceptado') . '</span></li>
                </ul>
            </div>
            
            <div style="background-color: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #0056b3; margin: 0 0 10px 0;">🔗 Enlace de la Reunión:</h4>
                <p style="color: #0056b3; font-size: 14px; margin: 0 0 10px 0;"><strong>' . ($booking['meeting_link'] ?? 'Enlace no disponible') . '</strong></p>
                <p style="color: #0056b3; font-size: 12px; margin: 0;">Guarda este enlace para acceder a la sesión cuando sea el momento.</p>
            </div>
            
            <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #155724; margin: 0 0 10px 0;">⚡ Acción Requerida:</h4>
                <p style="color: #155724; font-size: 14px; margin: 0 0 15px 0;">Por favor, revisa los detalles de la sesión y prepárate para la tutoría. ¡Tu estudiante está esperando!</p>
                <a href="' . route('tutor.bookings.upcoming-bookings') . '" style="background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">Ver Mis Tutorías</a>
            </div>
            
            <div style="background-color: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="color: #666; font-size: 12px; margin: 0; text-align: center;">
                    <strong>Importante:</strong> Esta es una notificación de alta prioridad. Por favor, responde lo antes posible.
                </p>
            </div>
            
            <p style="color: #495057; font-size: 14px; margin: 20px 0 0 0;">
                ¡Gracias por ser parte de nuestra comunidad de tutores!<br>
                <strong>Equipo ClassGo</strong>
            </p>
        </body>
        </html>';
    }

    /**
     * Genera el contenido del email para el estudiante
     *
     * @param array $data
     * @return string
     */
    private function generateStudentEmailContent(array $data): string
    {
        $booking = $data['bookingDetails'];
        $sessionDate = $booking['start_time'] ? date('d/m/Y', strtotime($booking['start_time'])) : 'Fecha no definida';
        $sessionTime = $booking['start_time'] ? date('H:i', strtotime($booking['start_time'])) : 'Hora no definida';

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tutoría Aceptada</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #d4edda; border: 2px solid #28a745; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="color: #155724; margin: 0 0 15px 0;">✅ ¡Excelente! Tu tutoría ha sido aceptada</h2>
                <p style="color: #155724; font-size: 16px; margin: 0 0 10px 0;"><strong>Hola ' . ($data['studentName'] ?? 'Estudiante') . ',</strong></p>
                <p style="color: #155724; font-size: 16px; margin: 0 0 15px 0;">¡Buenas noticias! Tu tutor ha aceptado la tutoría y está listo para comenzar.</p>
            </div>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #495057; margin: 0 0 15px 0;">📋 Detalles de la Sesión:</h3>
                <ul style="color: #495057; font-size: 14px; line-height: 1.6;">
                    <li><strong>Tutor:</strong> ' . ($data['tutorName'] ?? 'Tutor') . '</li>
                    <li><strong>Materia:</strong> ' . ($booking['subject'] ?? 'Materia no definida') . '</li>
                    <li><strong>Fecha:</strong> ' . $sessionDate . '</li>
                    <li><strong>Hora:</strong> ' . $sessionTime . '</li>
                    <li><strong>Estado:</strong> <span style="color: #28a745; font-weight: bold;">' . ($booking['status'] ?? 'Aceptado') . '</span></li>
                </ul>
            </div>
            
            <div style="background-color: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #0056b3; margin: 0 0 10px 0;">🔗 Enlace de la Reunión:</h4>
                <p style="color: #0056b3; font-size: 14px; margin: 0 0 10px 0;"><strong>' . ($booking['meeting_link'] ?? 'Enlace no disponible') . '</strong></p>
                <p style="color: #0056b3; font-size: 12px; margin: 0;">Usa este enlace para unirte a la sesión cuando sea el momento.</p>
            </div>
            
            <div style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #856404; margin: 0 0 10px 0;">📝 Preparación:</h4>
                <p style="color: #856404; font-size: 14px; margin: 0 0 15px 0;">Asegúrate de tener todo listo para la sesión. ¡Tu tutor está esperando para ayudarte!</p>
                <a href="' . route('student.bookings') . '" style="background-color: #ffc107; color: #856404; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">Ver Mis Tutorías</a>
            </div>
            
            <p style="color: #495057; font-size: 14px; margin: 20px 0 0 0;">
                ¡Gracias por usar ClassGo!<br>
                <strong>Equipo ClassGo</strong>
            </p>
        </body>
        </html>';
    }
} 