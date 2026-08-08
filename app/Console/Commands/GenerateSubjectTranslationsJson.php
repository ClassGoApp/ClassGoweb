<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class GenerateSubjectTranslationsJson extends Command
{
    /**
     * Nombre del comando.
     */
    protected $signature = 'subjects:generate-json';

    /**
     * Descripción del comando.
     */
    protected $description = 'Genera el archivo JSON de traducciones de todas las materias';

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        try {
            $jsonPath = public_path('js/subject-translations.json');

            /*
             * Leer el JSON existente para conservar las traducciones
             * en inglés y portugués que ya hayan sido agregadas.
             */
            $existingTranslations = [];

            if (File::exists($jsonPath)) {
                $jsonContent = File::get($jsonPath);
                $decodedJson = json_decode($jsonContent, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedJson)) {
                    $existingTranslations = $decodedJson;
                }
            }

            /*
             * Obtener todas las materias, incluyendo las inactivas.
             * Si deseas excluir las eliminadas lógicamente, se mantiene
             * el comportamiento normal del modelo Subject.
             */
            $subjects = Subject::query()
                ->select('id', 'name')
                ->orderBy('id')
                ->get();

            $translations = [];

            foreach ($subjects as $subject) {
                $subjectId = (string) $subject->id;

                $translations[$subjectId] = [
                    'es' => $subject->name,
                    'en' => $existingTranslations[$subjectId]['en'] ?? '',
                    'pt' => $existingTranslations[$subjectId]['pt'] ?? '',
                ];
            }

            $json = json_encode(
                $translations,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
            );

            if ($json === false) {
                $this->error('No se pudo convertir la información a JSON.');

                return self::FAILURE;
            }

            File::ensureDirectoryExists(dirname($jsonPath));
            File::put($jsonPath, $json . PHP_EOL);

            $this->info('JSON de materias generado correctamente.');
            $this->info('Materias registradas: ' . count($translations));
            $this->info('Archivo: ' . $jsonPath);

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Ocurrió un error al generar el JSON.');
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}