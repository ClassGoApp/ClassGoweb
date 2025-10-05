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

            // Obtener todos los estudiantes
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

            // PRIMERO: Buscar y enviar solo a rojasmachucaalvaro@gmail.com
            $testEmail = 'rojasmachucaalvaro@gmail.com';
            $testStudent = $students->where('email', $testEmail)->first();
            
            if ($testStudent) {
                Log::info('TutorVerificationNotificationService: Enviando notificación de prueba a usuario específico', [
                    'student_id' => $testStudent->id,
                    'student_email' => $testStudent->email,
                    'student_name' => $testStudent->profile->full_name ?? $testStudent->name ?? 'Estudiante'
                ]);
                
                try {
                    $this->sendNotificationToStudent($testStudent, $tutorInfo);
                    $successCount++;
                    Log::info('TutorVerificationNotificationService: ✅ Notificación de prueba enviada exitosamente', [
                        'student_id' => $testStudent->id,
                        'student_email' => $testStudent->email
                    ]);
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = [
                        'student_id' => $testStudent->id,
                        'student_email' => $testStudent->email,
                        'error' => $e->getMessage()
                    ];
                    Log::error('TutorVerificationNotificationService: Error al enviar notificación de prueba', [
                        'student_id' => $testStudent->id,
                        'student_email' => $testStudent->email,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                Log::warning('TutorVerificationNotificationService: Usuario de prueba no encontrado', [
                    'test_email' => $testEmail
                ]);
            }

            // SEGUNDO: Enviar a todos los demás estudiantes (COMENTADO TEMPORALMENTE)
            /*
            foreach ($students as $student) {
                // Saltar el usuario de prueba ya procesado
                if ($student->email === $testEmail) {
                    continue;
                }
                
                try {
                    $this->sendNotificationToStudentSilent($student, $tutorInfo);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = [
                        'student_id' => $student->id,
                        'student_email' => $student->email,
                        'error' => $e->getMessage()
                    ];
                }
            }
            */

            Log::info('TutorVerificationNotificationService: Resumen de notificaciones', [
                'total_students' => $students->count(),
                'emails_sent_successfully' => $successCount,
                'emails_failed' => $errorCount,
                'success_rate' => $students->count() > 0 ? round(($successCount / $students->count()) * 100, 2) . '%' : '0%',
                'tutor_id' => $verifiedTutor->id,
                'test_email_sent' => $testStudent ? true : false,
                'note' => 'Solo se envió al usuario de prueba. Envío masivo comentado temporalmente.'
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
     * Obtiene todos los estudiantes del sistema (sin filtro de status)
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
     * Obtiene la información del tutor verificado con sus materias reales
     *
     * @param User $tutor
     * @return array
     */
    private function getTutorInfo(User $tutor): array
    {
        // Cargar relaciones necesarias
        $tutor->load(['profile']);
        
        // Debugging del nombre del tutor
        Log::info('TutorVerificationNotificationService: Debugging tutor info', [
            'tutor_id' => $tutor->id,
            'tutor_email' => $tutor->email,
            'tutor_name_field' => $tutor->name,
            'profile_exists' => $tutor->profile ? true : false,
            'profile_full_name' => $tutor->profile ? $tutor->profile->full_name : 'No profile',
            'profile_first_name' => $tutor->profile ? $tutor->profile->first_name : 'No profile',
            'profile_last_name' => $tutor->profile ? $tutor->profile->last_name : 'No profile'
        ]);
        
        // Intentar obtener el nombre de diferentes maneras
        $tutorName = 'Tutor'; // Default
        
        if ($tutor->profile && $tutor->profile->full_name) {
            $tutorName = $tutor->profile->full_name;
        } elseif ($tutor->profile && $tutor->profile->first_name && $tutor->profile->last_name) {
            $tutorName = $tutor->profile->first_name . ' ' . $tutor->profile->last_name;
        } elseif ($tutor->name) {
            $tutorName = $tutor->name;
        } elseif ($tutor->email) {
            // Usar parte del email como nombre si no hay otro
            $emailParts = explode('@', $tutor->email);
            $tutorName = ucfirst($emailParts[0]);
        }
        
        // Obtener materias reales del tutor desde user_subject
        $subjects = [];
        
        // MÉTODO 1: Usar la relación directa del modelo User
        $subjectsViaRelation = $tutor->subjects;
        Log::info('TutorVerificationNotificationService: Materias via relación directa', [
            'tutor_id' => $tutor->id,
            'subjects_count' => $subjectsViaRelation->count(),
            'subjects' => $subjectsViaRelation->pluck('name')->toArray()
        ]);
        
        // MÉTODO 2: Usar UserSubject directamente
        $userSubjects = UserSubject::where('user_id', $tutor->id)
            ->with(['subject' => function($query) {
                $query->select('id', 'name');
            }])
            ->get();
            
        Log::info('TutorVerificationNotificationService: Debugging subjects via UserSubject', [
            'tutor_id' => $tutor->id,
            'user_subjects_count' => $userSubjects->count(),
            'user_subjects_raw' => $userSubjects->toArray(),
            'subjects_from_relation' => $userSubjects->pluck('subject.name')->filter()->toArray()
        ]);
        
        // Usar el método que funcione mejor
        if ($subjectsViaRelation->isNotEmpty()) {
            $subjects = $subjectsViaRelation->pluck('name')->toArray();
            Log::info('TutorVerificationNotificationService: Usando relación directa', [
                'subjects' => $subjects
            ]);
        } elseif ($userSubjects->isNotEmpty()) {
            $subjects = $userSubjects->pluck('subject.name')->filter()->toArray();
            Log::info('TutorVerificationNotificationService: Usando UserSubject', [
                'subjects' => $subjects
            ]);
        } else {
            Log::warning('TutorVerificationNotificationService: No se encontraron materias para el tutor', [
                'tutor_id' => $tutor->id,
                'relation_count' => $subjectsViaRelation->count(),
                'user_subject_count' => $userSubjects->count()
            ]);
        }

        Log::info('TutorVerificationNotificationService: Final tutor info', [
            'tutor_id' => $tutor->id,
            'final_name' => $tutorName,
            'subjects' => $subjects,
            'subjects_count' => count($subjects)
        ]);

        return [
            'id' => $tutor->id,
            'name' => $tutorName,
            'subjects' => $subjects,
            'profile_image' => $tutor->profile->image ?? null,
            'description' => $tutor->profile->description ?? null
        ];
    }

    /**
     * Envía notificación a un estudiante específico (con logs)
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
     * Envía notificación a un estudiante específico (sin logs detallados)
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendNotificationToStudentSilent(User $student, array $tutorInfo): void
    {
        // Enviar correo electrónico
        $this->sendEmailToStudentSilent($student, $tutorInfo);
        
        // Enviar notificación push si tiene FCM token
        if ($student->fcm_token) {
            $this->sendPushNotificationToStudentSilent($student, $tutorInfo);
        }
    }

    /**
     * Envía correo electrónico al estudiante (con logs)
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
     * Envía correo electrónico al estudiante (sin logs detallados)
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendEmailToStudentSilent(User $student, array $tutorInfo): void
    {
        try {
            $studentName = $student->profile->full_name ?? $student->name ?? 'Estudiante';
            $subject = '🎉 ¡Nuevo Tutor Verificado Disponible!';
            
            $emailContent = $this->generateStudentEmailContent($studentName, $tutorInfo);
            
            // Enviar email usando Mail facade
            Mail::send([], [], function ($message) use ($student, $subject, $emailContent) {
                $message->to($student->email)
                        ->subject($subject)
                        ->html($emailContent);
            });

        } catch (\Exception $e) {
            // Solo log de error, sin detalles
        }
    }

    /**
     * Envía notificación push al estudiante (con logs)
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendPushNotificationToStudent(User $student, array $tutorInfo): void
    {
        try {
            $title = '🎉 ¡Nuevo Tutor Verificado!';
            
            // Generar el texto del cuerpo basado en las materias del tutor
            $body = $this->generateNotificationBody($tutorInfo);
            
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
                'result' => $result,
                'body' => $body
            ]);

        } catch (\Exception $e) {
            Log::error('TutorVerificationNotificationService: Error al enviar push notification al estudiante', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía notificación push al estudiante (sin logs detallados)
     *
     * @param User $student
     * @param array $tutorInfo
     * @return void
     */
    private function sendPushNotificationToStudentSilent(User $student, array $tutorInfo): void
    {
        try {
            $title = '🎉 ¡Nuevo Tutor Verificado!';
            
            // Generar el texto del cuerpo basado en las materias del tutor
            $body = $this->generateNotificationBody($tutorInfo);
            
            // Usar el servicio de Firebase para enviar la notificación
            $fcmService = new \App\Services\FcmService();
            
            $fcmService->sendNotification(
                $student->fcm_token,
                $title,
                $body,
                [
                    'type' => 'tutor_verified',
                    'tutor_id' => $tutorInfo['id'],
                    'tutor_name' => $tutorInfo['name']
                ]
            );

        } catch (\Exception $e) {
            // Solo log de error, sin detalles
        }
    }

    /**
     * Genera el texto del cuerpo de la notificación basado en las materias del tutor
     *
     * @param array $tutorInfo
     * @return string
     */
    private function generateNotificationBody(array $tutorInfo): string
    {
        $tutorName = $tutorInfo['name'];
        $subjects = $tutorInfo['subjects'];
        
        Log::info('TutorVerificationNotificationService: Generating notification body', [
            'tutor_name' => $tutorName,
            'subjects' => $subjects,
            'subjects_count' => count($subjects)
        ]);
        
        // Si el tutor tiene materias registradas
        if (!empty($subjects) && count($subjects) > 0) {
            $subjectsText = implode(', ', $subjects);
            $body = "{$tutorName} está ahora disponible para tutorías en: {$subjectsText}";
        } else {
            // Si no tiene materias, solo mostrar el nombre
            $body = "{$tutorName} está ahora disponible para tutorías";
        }
        
        Log::info('TutorVerificationNotificationService: Final notification body', [
            'body' => $body
        ]);
        
        return $body;
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
            <title>¡Nuevo Tutor Verificado!</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #e6ffe6; border: 2px solid #4CAF50; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h2 style="color: #2E8B57; margin: 0 0 15px 0;">🎉 ¡Excelente noticia, ' . $studentName . '!</h2>
                <p style="color: #2E8B57; font-size: 16px; margin: 0 0 10px 0;">Tenemos un nuevo tutor verificado en nuestra plataforma que podría interesarte.</p>
                <p style="color: #2E8B57; font-size: 16px; margin: 0 0 15px 0;">Conoce a <strong>' . $tutorInfo['name'] . '</strong>, quien ha completado exitosamente su proceso de verificación.</p>
            </div>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #495057; margin: 0 0 15px 0;">👨‍🏫 Detalles del Tutor:</h3>
                <div style="text-align: center; margin-bottom: 15px;">
                    <img src="' . $profileImageUrl . '" alt="Foto de Perfil de ' . $tutorInfo['name'] . '" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #007bff;">
                </div>
                <ul style="color: #495057; font-size: 14px; line-height: 1.6; list-style-type: none; padding: 0;">
                    <li><strong>Nombre:</strong> ' . $tutorInfo['name'] . '</li>
                    <li><strong>Materias:</strong> ' . (!empty($tutorInfo['subjects']) ? implode(', ', $tutorInfo['subjects']) : 'No especificadas') . '</li>
                    <li><strong>Estado:</strong> <span style="color: #28a745; font-weight: bold;">Verificado ✅</span></li>
                </ul>
            </div>
            
            <div style="background-color: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #0056b3; margin: 0 0 10px 0;">✨ ¿Por qué es importante?</h4>
                <ul style="color: #0056b3; font-size: 14px; line-height: 1.6;">
                    <li>Acceso a tutores de alta calidad y confianza</li>
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
            
            <p style="color: #495057; font-size: 14px; margin: 20px 0 0 0;">
                ¡Esperamos que disfrutes de tus próximas sesiones!<br>
                <strong>Equipo ClassGo</strong>
            </p>
        </body>
        </html>';
    }
}