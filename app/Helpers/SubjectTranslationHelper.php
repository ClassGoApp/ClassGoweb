<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SubjectTranslationHelper
{
    /**
     * Obtiene las traducciones de todas las materias desde el JSON
     * 
     * @return array
     */
    public static function getAllTranslations(): array
    {
        return Cache::remember('subject_translations', 3600, function () {
            $jsonPath = public_path('js/subject-translations.json');

            if (!File::exists($jsonPath)) {
                Log::warning('Subject translations JSON file not found', ['path' => $jsonPath]);
                return [];
            }

            $jsonContent = File::get($jsonPath);
            $translations = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error decoding subject translations JSON', [
                    'error' => json_last_error_msg(),
                    'path' => $jsonPath
                ]);
                return [];
            }

            return $translations ?? [];
        });
    }

    /**
     * Obtiene las traducciones de una materia específica
     * 
     * @param int $subjectId
     * @return array|null
     */
    public static function getTranslation(int $subjectId): ?array
    {
        $translations = self::getAllTranslations();
        return $translations[(string) $subjectId] ?? null;
    }

    /**
     * Obtiene el nombre traducido de una materia en un idioma específico
     * 
     * @param int $subjectId
     * @param string $locale (es, en, pt)
     * @param string|null $fallback Nombre por defecto si no hay traducción
     * @return string|null
     */
    public static function getTranslatedName(int $subjectId, string $locale = 'es', ?string $fallback = null): ?string
    {
        $translations = self::getTranslation($subjectId);

        if (!$translations) {
            return $fallback;
        }

        // Normalizar locale a los idiomas soportados
        $locale = strtolower(substr($locale, 0, 2));
        if (!in_array($locale, ['es', 'en', 'pt'])) {
            $locale = 'es';
        }

        return $translations[$locale] ?? $translations['es'] ?? $fallback;
    }

    /**
     * Limpia el cache de traducciones
     * 
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget('subject_translations');
    }

    /**
     * Agrega las traducciones a un objeto Subject o array
     * 
     * @param mixed $subject Modelo Subject o array con id
     * @return array
     */
    public static function addTranslationsToSubject($subject): array
    {
        $subjectArray = is_array($subject) ? $subject : $subject->toArray();
        $subjectId = $subjectArray['id'] ?? null;

        if (!$subjectId) {
            return $subjectArray;
        }

        $translations = self::getTranslation($subjectId);

        if ($translations) {
            $subjectArray['translations'] = $translations;
        } else {
            // Si no hay traducciones, usar el nombre como fallback en español
            $subjectArray['translations'] = [
                'es' => $subjectArray['name'] ?? '',
                'en' => '',
                'pt' => ''
            ];
        }

        return $subjectArray;
    }
}
