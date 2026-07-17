<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentsService {



    public function createAttachment(Model $attachable, $fileProcesado, ?string $description = null)
    {
        // Genera una carpeta dinámica según el nombre del modelo (ej: "slotbookings" o "supportmaterials")
        // $folderName = strtolower(class_basename($attachable)) . 's';
        
        // // Guarda el archivo físico en el disco público
        // $path = $file->store("uploads/{$folderName}", 'public');

        // Crea el registro usando la relación polimórfica del modelo padre
        $attachable->attachments()->create([
            'original_name' => $fileProcesado['originName'] ?? null,
            'path'          => $fileProcesado['path'] ?? null,
            'extension'     => $fileProcesado['extension'] ?? null,
            'mime_type'     => $fileProcesado['mime_type'] ?? null,
            'size'          => $fileProcesado['size'] ?? null,
            'description'   => $description,
        ]);
    }

    public function updateAttachment(Attachment|int $attachment, ?UploadedFile $file = null, ?string $description = null)
    {

        if(is_int($attachment)){
            $attachment = Attachment::findOrFail($attachment);
        }
        // 1. Si se envió una nueva descripción, la actualizamos
        if ($description !== null) {
            $attachment->description = $description;
        }

        // 2. Si se envió un nuevo archivo, reemplazamos el anterior
        if ($file) {
            // Eliminamos el archivo físico antiguo del disco para no acumular basura
            if (Storage::disk('public')->exists($attachment->path)) {
                Storage::disk('public')->delete($attachment->path);
            }

            // Descubrimos el nombre de la carpeta destino basándonos en el tipo polimórfico original
            $folderName = strtolower(class_basename($attachment->attachable_type)) . 's';
            $newPath = $file->store("uploads/{$folderName}", 'public');

            // Actualizamos los datos técnicos del archivo
            $attachment->fill([
                'original_name' => $file->getClientOriginalName(),
                'path'          => $newPath,
                'extension'     => $file->getClientOriginalExtension(),
                'mime_type'     => $file->getClientMimeType(),
                'size'          => $file->getSize(),
            ]);
        }

        // Guardamos los cambios en la base de datos
        $attachment->save();

        // return $attachment;
    }

    public function deleteAttachment($idFile){
        $attachment = Attachment::find($idFile);
        
        if($attachment && $attachment->path){
            Storage::disk('public')->delete($attachment->path);
        }
        $attachment->delete();
    }
} 