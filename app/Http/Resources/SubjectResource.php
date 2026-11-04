<?php

namespace App\Http\Resources;

use App\Helpers\SubjectTranslationHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseData = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'subject_group_id' => $this->subject_group_id,
        ];

        // Agregar traducciones automáticamente
        $translations = SubjectTranslationHelper::getTranslation($this->id);

        if ($translations) {
            $baseData['translations'] = $translations;
        } else {
            // Fallback: usar el nombre como español por defecto
            $baseData['translations'] = [
                'es' => $this->name,
                'en' => '',
                'pt' => ''
            ];
        }

        // Incluir relaciones si están cargadas
        if ($this->relationLoaded('group')) {
            $baseData['group'] = [
                'id' => $this->group->id,
                'name' => $this->group->name,
            ];
        }

        return $baseData;
    }
}
