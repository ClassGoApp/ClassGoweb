<?php

namespace App\Livewire\Pages\Admin\Notificaciones;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendBulkEmailJob;

class NotificacionesEmail extends Component
{
    use WithFileUploads;
    // Email Fields
    public $subject = '';
    public $emailBody = '';
    public $targetType = 'all'; // all, tutor, estudiante
    public $specificEmails = ''; // Comma-separated list of emails
    public $activeTab = 'massive'; // Tab control: massive, specific

    // User Selection for Specific Emails
    public $searchQuery = '';
    public $selectedUsers = [];
    public $availableUsers = [];
    public $searchResults = [];
    public $showSearchResults = false;

    // Attachments
    public $attachments = [];
    public $images = [];
    public $maxFileSize = 10485760; // 10 MB
    public $maxTotalSize = 20971520; // 20 MB
    public $allowedFileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip', 'rar'];
    public $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Response Tracking
    public $apiResponse = null;
    public $errorMessage = null;
    public $successMessage = null;

    public function sendMassiveEmail()
    {
        $this->resetResponses();

        $this->validate([
            'subject' => 'required|string|min:3',
            'emailBody' => 'required|string|min:3',
            'targetType' => 'required|string',
        ]);

        try {
            $emails = $this->getEmailsByType($this->targetType);

            Log::info('SendMassiveEmail iniciado', [
                'target_type' => $this->targetType,
                'total_emails' => count($emails),
            ]);

            if (empty($emails)) {
                $this->errorMessage = 'No hay usuarios con correo electrónico en la categoría seleccionada.';
                Log::warning('No emails found for target type: ' . $this->targetType);
                return;
            }

            // Ejecutar Job directamente para obtener resultado
            $job = new SendBulkEmailJob(
                $emails,
                $this->subject,
                $this->emailBody,
                $this->attachments,
                $this->images
            );

            $result = $job->handle();

            $this->apiResponse = $result;
            $successCount = $result['success_count'];
            $failureCount = $result['failure_count'];

            Log::info('SendMassiveEmail completado', [
                'success_count' => $successCount,
                'failure_count' => $failureCount,
            ]);

            $this->successMessage = "¡Emails enviados correctamente! Éxito: {$successCount} | Errores: {$failureCount}";
            session()->flash('success', $this->successMessage);

        } catch (\Exception $e) {
            Log::error('Admin Email Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    public function sendSpecificEmail()
    {
        $this->resetResponses();

        $this->validate([
            'subject' => 'required|string|min:3',
            'emailBody' => 'required|string|min:3',
            'specificEmails' => 'required|string',
        ]);

        try {
            // Parse emails
            $emails = array_filter(array_map('trim', explode(',', $this->specificEmails)));
            
            // Validate emails
            $validEmails = [];
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $email;
                }
            }

            if (empty($validEmails)) {
                $this->errorMessage = 'No hay direcciones de correo válidas.';
                return;
            }

            // Ejecutar Job directamente para obtener resultado
            $job = new SendBulkEmailJob(
                $validEmails,
                $this->subject,
                $this->emailBody,
                $this->attachments,
                $this->images
            );

            $result = $job->handle();

            $this->apiResponse = $result;
            $successCount = $result['success_count'];
            $failureCount = $result['failure_count'];

            $this->successMessage = "¡Emails enviados correctamente! Éxito: {$successCount} | Errores: {$failureCount}";
            session()->flash('success', $this->successMessage);

        } catch (\Exception $e) {
            Log::error('Admin Specific Email Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    private function getEmailsByType($type)
    {
        $query = DB::table('users');

        if ($type === 'tutor') {
            $query->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                  ->where('model_has_roles.role_id', 2);
        } elseif ($type === 'student') {
            $query->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                  ->where('model_has_roles.role_id', 3);
        }

        return $query->whereNotNull('email')
                     ->pluck('users.email')
                     ->toArray();
    }

    private function resetResponses()
    {
        $this->apiResponse = null;
        $this->errorMessage = null;
        $this->successMessage = null;
    }

    public function updatedAttachments()
    {
        // Procesar archivos adjuntos
        try {
            $this->processUploadedFiles('attachments', $this->allowedFileTypes);
        } catch (\Exception $e) {
            Log::error('Error en updatedAttachments: ' . $e->getMessage());
            $this->attachments = [];
        }
    }

    public function updatedImages()
    {
        // Procesar imágenes
        try {
            $this->processUploadedFiles('images', $this->allowedImageTypes);
        } catch (\Exception $e) {
            Log::error('Error en updatedImages: ' . $e->getMessage());
            $this->images = [];
        }
    }

    private function processUploadedFiles($property, $allowedExtensions)
    {
        $files = $this->$property;
        
        if (empty($files)) {
            return;
        }

        $processedFiles = [];
        $totalSize = 0;

        // Convertir a array si es un objeto único
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            try {
                // Verificar si es un TemporaryUploadedFile de Livewire
                if (is_object($file) && method_exists($file, 'getClientOriginalName')) {
                    $filename = $file->getClientOriginalName();
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $size = $file->getSize();

                    // Validar extensión
                    if (!in_array($extension, $allowedExtensions)) {
                        throw new \Exception("Extensión no permitida: .$extension");
                    }

                    // Validar tamaño individual
                    if ($size > $this->maxFileSize) {
                        throw new \Exception("Archivo demasiado grande: " . $this->formatFileSize($size));
                    }

                    $totalSize += $size;

                    // Validar tamaño total
                    if ($totalSize > $this->maxTotalSize) {
                        throw new \Exception("Tamaño total excedido");
                    }

                    // Guardar el archivo
                    $storagePath = $file->store('temp-uploads', 'local');

                    $processedFiles[] = [
                        'name' => $filename,
                        'path' => $storagePath,
                        'size' => $size,
                        'extension' => $extension,
                    ];

                    Log::info("Archivo procesado: $filename ($size bytes) guardado en: $storagePath");
                } 
                // Si ya es un array procesado
                elseif (is_array($file) && isset($file['path'])) {
                    $processedFiles[] = $file;
                    $totalSize += $file['size'] ?? 0;
                }
            } catch (\Exception $e) {
                Log::warning("Error procesando archivo: " . $e->getMessage());
                // No agregar el archivo si hay error
            }
        }

        $this->$property = $processedFiles;
    }



    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            Storage::disk('local')->delete($this->attachments[$index]['path']);
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            Storage::disk('local')->delete($this->images[$index]['path']);
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    private function calculateTotalSize()
    {
        $total = 0;
        
        foreach (array_merge($this->attachments, $this->images) as $file) {
            if (is_array($file) && isset($file['size'])) {
                $total += $file['size'];
            } elseif (is_object($file) && method_exists($file, 'getSize')) {
                $total += $file->getSize();
            }
        }
        
        return $total;
    }

    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) < 2) {
            $this->searchResults = [];
            $this->showSearchResults = false;
            return;
        }

        $this->searchResults = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('users.email', 'like', '%' . $this->searchQuery . '%')
            ->orWhere(DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name)"), 'like', '%' . $this->searchQuery . '%')
            ->whereNotIn('users.id', collect($this->selectedUsers)->pluck('id')->toArray())
            ->limit(10)
            ->get(['users.id', DB::raw("CONCAT(profiles.first_name, ' ', profiles.last_name) as name"), 'users.email'])
            ->toArray();

        $this->showSearchResults = !empty($this->searchResults);
    }

    public function selectUser($userId, $name, $email)
    {
        $this->selectedUsers[] = [
            'id' => $userId,
            'name' => $name,
            'email' => $email
        ];
        $this->searchQuery = '';
        $this->searchResults = [];
        $this->showSearchResults = false;
        $this->updateSpecificEmails();
    }

    public function removeSelectedUser($userId)
    {
        $this->selectedUsers = array_filter($this->selectedUsers, function($user) use ($userId) {
            return $user['id'] != $userId;
        });
        $this->selectedUsers = array_values($this->selectedUsers);
        $this->updateSpecificEmails();
    }

    private function updateSpecificEmails()
    {
        $this->specificEmails = collect($this->selectedUsers)
            ->pluck('email')
            ->implode(', ');
    }

    public function render()
    {
        // Get user counts by email
        $totalUsers = DB::table('users')->whereNotNull('email')->count();

        $tutorsWithEmail = DB::table('users')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->where('model_has_roles.role_id', 2)
            ->whereNotNull('users.email')
            ->count();

        $studentsWithEmail = DB::table('users')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->where('model_has_roles.role_id', 3)
            ->whereNotNull('users.email')
            ->count();

        return view('livewire.pages.admin.notificaciones.notificaciones-email', [
            'totalUsers' => $totalUsers,
            'tutorsWithEmail' => $tutorsWithEmail,
            'studentsWithEmail' => $studentsWithEmail,
        ])->layout('layouts.admin-app');
    }
}

