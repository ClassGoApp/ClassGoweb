<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSubject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TutorVerificationNotificationService
{
    /**
     * Notifica a todos los estudiantes cuando un tutor es verificado
     *
     * @param User $verifiedTutor
     * @return void
     */
    public function notifyStudentsAboutTutorVerification(User $verifiedTutor): void
    {
        try {
            Log::info('TutorVerificationNotificationService: Iniciando notificaciones a estudiantes', [
                'tutor_id' => $verifiedTutor->id,
                'tutor_name' => $verifiedTutor->profile->full_name ?? 'Tutor'
            ]);

            // Obtener todos los estudiantes activos
            $students = $this->getAllStudents();
            
            if ($students->isEmpty()) {
                Log::info('TutorVerificationNotificationService: No hay estudiantes para notificar');
                return;
            }

            // Obtener información del tutor
            $tutorInfo = $this->getTutorInfo($verifiedTutor);
            
            Log::info('TutorVerificationNotificationService: Información del tutor obtenida', [
                'tutor_name' => $tutorInfo['name'],
                'subjects_count' => count($tutorInfo['subjects']),
                'subjects' => $tutorInfo['subjects']
            ]);

            // Contadores para estadísticas
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            // Notificar a cada estudiante
            foreach ($students as $student) {
                try {
                    $this->sendNotificationToStudent($student, $tutorInfo);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = [
                        'student_id' => $student->id,
                        'student_email' => $student->email,
                        'error' => $e->getMessage()
                    ];
                    Log::error('TutorVerificationNotificationService: Error al notificar estudiante individual', [
                        'student_id' => $student->id,
                        'student_email' => $student->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('TutorVerificationNotificationService: Resumen de notificaciones', [
                'total_students' => $students->count(),
                'emails_sent_successfully' => $successCount,
                'emails_failed' => $errorCount,
                'success_rate' => $students->count() > 0 ? round(($successCount / $students->count()) * 100, 2) . '%' : '0%',
                'tutor_id' => $verifiedTutor->id,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('TutorVerificationNotificationService: Error al enviar notificaciones', [
                'tutor_id' => $verifiedTutor->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Obtiene todos los estudiantes activos del sistema
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getAllStudents()
    {
        $students = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })
        ->with('profile')
        ->get();
        
        Log::info('TutorVerificationNotificationService: Estudiantes encontrados', [
            'total_students' => $students->count(),
            'students_with_active_status' => $students->where('status', 'active')->count(),
            'students_with_inactive_status' => $students->where('status', 'inactive')->count(),
            'students_with_null_status' => $students->whereNull('status')->count(),
            'student_emails' => $students->pluck('email')->toArray(),
            'student_ids' => $students->pluck('id')->toArray()
        ]);
        
        return $students;
    }

    /**
     * Obtiene la información del tutor verificado
     *
     * @param User $tutor
     * @return array
     */
    private function getTutorInfo(User $tutor): array
    {
        // Cargar relaciones necesarias
        $tutor->load(['profile', 'subjects']);
        
        $tutorName = $tutor->profile->full_name ?? $tutor->name ?? 'Tutor';
        
        // Obtener materias que imparte el tutor
        $subjects = [];
        if ($tutor->subjects && $tutor->subjects->isNotEmpty()) {
            $subjects = $tutor->subjects->pluck('name')->toArray();
        }

        return [
            'id' => $tutor->id,
            'name' => $tutorName,
            'subjects' => $subjects,
            'profile_image' => $tutor->profile->image ?? null,
            'description' => $tutor->profile->description ?? null
        ];
    }

    /**
     * Envía notificación a un estudiante específico
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendNotificationToStudent(User $student, array $tutorInfo): void
    {
        // Enviar correo electrónico
        $this->sendEmailToStudent($student, $tutorInfo);
        
        // Enviar notificación push si tiene FCM token
        if ($student->fcm_token) {
            $this->sendPushNotificationToStudent($student, $tutorInfo);
        }

        Log::info('TutorVerificationNotificationService: Notificación enviada al estudiante', [
            'student_id' => $student->id,
            'student_email' => $student->email,
            'has_fcm_token' => !empty($student->fcm_token)
        ]);
    }

    /**
     * Envía correo electrónico al estudiante
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendEmailToStudent(User $student, array $tutorInfo): void
    {
        try {
            $studentName = $student->profile->full_name ?? $student->name ?? 'Estudiante';
            $subject = '🎉 ¡Nuevo Tutor Verificado Disponible!';
            
            Log::info('TutorVerificationNotificationService: Preparando email para estudiante', [
                'student_id' => $student->id,
                'student_email' => $student->email,
                'student_name' => $studentName,
                'tutor_name' => $tutorInfo['name']
            ]);
            
            $emailContent = $this->generateStudentEmailContent($studentName, $tutorInfo);
            
            // Enviar email usando Mail facade
            Mail::send([], [], function ($message) use ($student, $subject, $emailContent) {
                $message->to($student->email)
                        ->subject($subject)
                        ->html($emailContent);
            });
            
            Log::info('TutorVerificationNotificationService: Email enviado exitosamente', [
                'student_id' => $student->id,
                'student_email' => $student->email,
                'subject' => $subject
            ]);

            Log::info('TutorVerificationNotificationService: Email enviado al estudiante', [
                'student_id' => $student->id,
                'student_email' => $student->email
            ]);

        } catch (\Exception $e) {
            Log::error('TutorVerificationNotificationService: Error al enviar email al estudiante', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía notificación push al estudiante
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendPushNotificationToStudent(User $student, array $tutorInfo): void
    {
        try {
            $subjectsText = !empty($tutorInfo['subjects']) 
                ? ' en ' . implode(', ', $tutorInfo['subjects'])
                : '';
            
            $title = '🎉 ¡Nuevo Tutor Verificado!';
            $body = "{$tutorInfo['name']} está ahora disponible para tutorías{$subjectsText}";
            
            // Usar el servicio de Firebase para enviar la notificación
            $fcmService = new \App\Services\FcmService();
            
            $result = $fcmService->sendNotification(
                $student->fcm_token,
                $title,
                $body,
                [
                    'type' => 'tutor_verified',
                    'tutor_id' => $tutorInfo['id'],
                    'tutor_name' => $tutorInfo['name']
                ]
            );

            Log::info('TutorVerificationNotificationService: Push notification enviada al estudiante', [
                'student_id' => $student->id,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('TutorVerificationNotificationService: Error al enviar push notification al estudiante', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Genera el contenido del email para el estudiante
     *
     * @param string $studentName
     * @param array $tutorInfo
     * @return string
     */
    private function generateStudentEmailContent(string $studentName, array $tutorInfo): string
    {
        $subjectsText = !empty($tutorInfo['subjects']) 
            ? ' en las siguientes materias: ' . implode(', ', $tutorInfo['subjects'])
            : '';
        
            $profileImageUrl = $tutorInfo['profile_image'] 
                ? \url('public/storage/' . $tutorInfo['profile_image'])
                : \url('public/images/default-avatar.png');

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nuevo Tutor Verificado</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #d4edda; border: 2px solid #28a745; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="color: #155724; margin: 0 0 15px 0;">🎉 ¡Nuevo Tutor Verificado Disponible!</h2>
                <p style="color: #155724; font-size: 16px; margin: 0 0 10px 0;"><strong>Hola ' . $studentName . ',</strong></p>
                <p style="color: #155724; font-size: 16px; margin: 0 0 15px 0;">¡Excelentes noticias! Un nuevo tutor ha sido verificado y está disponible para ayudarte con tus estudios.</p>
            </div>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #495057; margin: 0 0 15px 0;">👨‍🏫 Información del Tutor:</h3>
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                    <img src="' . $profileImageUrl . '" alt="Foto del tutor" style="width: 60px; height: 60px; border-radius: 50%; margin-right: 15px; object-fit: cover;">
                    <div>
                        <h4 style="color: #495057; margin: 0 0 5px 0;">' . $tutorInfo['name'] . '</h4>
                        <p style="color: #6c757d; font-size: 14px; margin: 0;">Tutor Verificado</p>
                    </div>
                </div>
                ' . (!empty($tutorInfo['subjects']) ? '
                <div style="background-color: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <h4 style="color: #0056b3; margin: 0 0 10px 0;">📚 Materias que imparte:</h4>
                    <p style="color: #0056b3; font-size: 14px; margin: 0;">' . implode(', ', $tutorInfo['subjects']) . '</p>
                </div>
                ' : '') . '
                ' . ($tutorInfo['description'] ? '
                <div style="background-color: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin: 15px 0;">
                    <h4 style="color: #856404; margin: 0 0 10px 0;">📝 Descripción:</h4>
                    <p style="color: #856404; font-size: 14px; margin: 0;">' . $tutorInfo['description'] . '</p>
                </div>
                ' : '') . '
            </div>
            
            <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #0c5460; margin: 0 0 10px 0;">💡 ¿Qué significa esto para ti?</h4>
                <ul style="color: #0c5460; font-size: 14px; margin: 0; padding-left: 20px;">
                    <li>Puedes reservar tutorías con este tutor verificado</li>
                    <li>El tutor ha pasado por un proceso de verificación de identidad</li>
                    <li>Mayor confianza y seguridad en tus sesiones de estudio</li>
                </ul>
            </div>
            
            <div style="background-color: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <a href="' . \url('/tutors') . '" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">Ver Todos los Tutores</a>
            </div>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="color: #6c757d; font-size: 12px; margin: 0; text-align: center;">
                    <strong>ClassGo</strong> - Tu plataforma de aprendizaje confiable
                </p>
            </div>
        </body>
        </html>';
    }
}
