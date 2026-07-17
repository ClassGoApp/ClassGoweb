<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class Attachment extends Model
{
    // Habilitamos los campos para asignación masiva
    protected $fillable = [
        'original_name', 
        'path', 
        'extension', 
        'mime_type', 
        'size', 
        'description'
    ];

    /**
     * Obtiene el modelo padre (SlotBooking, SupportMaterial, etc.)
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
