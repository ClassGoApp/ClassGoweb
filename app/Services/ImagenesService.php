<?php
// filepath: app/Services/MailService.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class ImagenesService
{
    /**
     * Aquí puedes agregar métodos relacionados con la gestión de imágenes.
     * Por ejemplo, subir imágenes, eliminar imágenes, etc.
     */

    public function uploadImage($image)
    {
        // Lógica para subir una imagen
    }

    public function deleteImage($imageId)
    {
        // Lógica para eliminar una imagen
    }


    public function guardarqrEstudianteReserva($image):string
    {
        // Lógica para guardar el QR de estudiante en la reserva
        // Aquí puedes implementar la lógica específica para guardar el QR
        // por ejemplo, generando un nombre único y guardándolo en una carpeta específica.


          // Nombre único para evitar sobrescribir archivos
                    $fileName = uniqid() . '_' . $image->getClientOriginalName();
                    // Guarda el archivo en storage/app/public/uploads/bookings
                    $image->storeAs('uploads/bookings', $fileName, 'public');
                    // Copia el archivo a public/storage/uploads/bookings
                    $source = storage_path('app/public/uploads/bookings/' . $fileName);
                    $destination = public_path('storage/uploads/bookings/' . $fileName);
                    if (!file_exists(dirname($destination))) {
                        mkdir(dirname($destination), 0775, true);
                    }
                    copy($source, $destination);

        return 'uploads/bookings/' . $fileName;
    }

       public function guardarMaterialApoyoEstudiante(UploadedFile $file, string $targetModelClass = null): array
    {
        // 1. Verificación de seguridad usando el método nativo de UploadedFile
        if (!$file->isValid()) {
            throw new \Exception("El archivo no se subió correctamente al servidor o está corrupto.");
        }
        // 2. Extraemos el nombre de la carpeta de forma dinámica
        // Si nos pasan "App\Models\SlotBooking", class_basename lo convierte en "SlotBooking"
        // y luego lo formateamos a plural ("slot_bookings").
        if($targetModelClass){
            $folderName=  $this->snake_case_plural(class_basename($targetModelClass));
        }else{
            $folderName= "slot_bookings";
        }
        
        // 3. Guardamos en la carpeta dinámica dentro del disco public
        $rutaDefinitiva = $file->store("uploads/{$folderName}", 'public');
        
        // 4. Retornamos el array con las claves listas para tu base de datos
        return [
            "path"       => $rutaDefinitiva,
            "originName" => $file->getClientOriginalName(),
            "extension"  => $file->getClientOriginalExtension(),
            "size"       => $file->getSize(),
            "mime_type"  => $file->getClientMimeType(), // Mantenemos tu clave mine_type
        ];
    }

    function snake_case_plural(string $className): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className)) . 's';
    }

}