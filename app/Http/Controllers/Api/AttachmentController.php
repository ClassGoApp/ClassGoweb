<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\SlotBooking;
use App\Services\AttachmentsService;
use App\Services\ImagenesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Tipos de archivo y tamaño permitidos (igual que el web Livewire).
     * @var array{file:string}
     */
    private const VALIDATION_RULES = [
        'file' => 'file|mimes:pdf,doc,docx,ods,odt,xls,xlsx,jpg,jpeg,png|max:5120',
    ];

    /**
     * Listar los materiales de apoyo de una tutoría.
     */
    public function index(Request $request, int $bookingId)
    {
        $booking = SlotBooking::find($bookingId);

        if (!$booking || !$this->belongsToUser($booking)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a esta tutoría.',
            ], 403);
        }

        $attachments = $booking->attachments()
            ->orderByDesc('id')
            ->get()
            ->map(fn (Attachment $a) => $this->formatAttachment($a));

        return response()->json([
            'success' => true,
            'message' => 'Materiales obtenidos correctamente.',
            'data'    => $attachments,
        ]);
    }

    /**
     * Adjuntar un material de apoyo a una tutoría (solo estudiante).
     */
    public function store(Request $request, int $bookingId, ImagenesService $imagenesService, AttachmentsService $attachmentsService)
    {
        $booking = SlotBooking::find($bookingId);

        if (!$booking || !$this->isStudentOf($booking)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a esta tutoría.',
            ], 403);
        }

        $request->validate([
            ...self::VALIDATION_RULES,
            'file'        => 'required|' . self::VALIDATION_RULES['file'],
            'description' => 'required|string|min:2|max:500',
        ]);

        try {
            $fileProcesado = $imagenesService->guardarMaterialApoyoEstudiante(
                $request->file('file'),
                SlotBooking::class
            );

            $attachmentsService->createAttachment(
                $booking,
                $fileProcesado,
                $request->input('description')
            );

            return response()->json([
                'success' => true,
                'message' => 'Material adjuntado correctamente.',
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al adjuntar el material.',
                'debug'   => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Actualizar descripción y/o reemplazar el archivo (solo estudiante).
     */
    public function update(Request $request, int $attachmentId, AttachmentsService $attachmentsService)
    {
        $attachment = Attachment::find($attachmentId);

        if (!$attachment || !$this->isStudentOf($attachment->attachable)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a este archivo.',
            ], 403);
        }

        $request->validate([
            ...self::VALIDATION_RULES,
            'description' => 'nullable|string|min:2|max:500',
        ]);

        try {
            $attachmentsService->updateAttachment(
                $attachment,
                $request->file('file'),
                $request->input('description')
            );

            return response()->json([
                'success' => true,
                'message' => 'Material actualizado correctamente.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el material.',
                'debug'   => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Eliminar un material de apoyo (solo estudiante).
     */
    public function destroy(Request $request, int $attachmentId, AttachmentsService $attachmentsService)
    {
        $attachment = Attachment::find($attachmentId);

        if (!$attachment || !$this->isStudentOf($attachment->attachable)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a este archivo.',
            ], 403);
        }

        $attachmentsService->deleteAttachment($attachmentId);

        return response()->json([
            'success' => true,
            'message' => 'Material eliminado correctamente.',
        ]);
    }

    /**
     * Descargar el archivo (estudiante o tutor de la tutoría).
     */
    public function download(Request $request, int $attachmentId)
    {
        $attachment = Attachment::find($attachmentId);

        if (!$attachment || !$this->belongsToUser($attachment->attachable)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a este archivo.',
            ], 403);
        }

        if (!$attachment->path || !Storage::disk('public')->exists($attachment->path)) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo ya no está disponible.',
            ], 404);
        }

        return Storage::disk('public')->download(
            $attachment->path,
            $attachment->original_name
        );
    }

    /**
     * ¿El usuario autenticado es el estudiante de la tutoría?
     */
    private function isStudentOf(?SlotBooking $booking): bool
    {
        return $booking && (int) $booking->student_id === (int) Auth::id();
    }

    /**
     * ¿El usuario autenticado participa de la tutoría (estudiante o tutor)?
     */
    private function belongsToUser(?SlotBooking $booking): bool
    {
        return $booking && (
            (int) $booking->student_id === (int) Auth::id() ||
            (int) $booking->tutor_id === (int) Auth::id()
        );
    }

    private function formatAttachment(Attachment $a): array
    {
        return [
            'id'            => $a->id,
            'original_name' => $a->original_name,
            'extension'     => $a->extension,
            'mime_type'     => $a->mime_type,
            'size'          => $a->size,
            'description'   => $a->description,
            'created_at'    => optional($a->created_at)->toDateTimeString(),
        ];
    }
}
