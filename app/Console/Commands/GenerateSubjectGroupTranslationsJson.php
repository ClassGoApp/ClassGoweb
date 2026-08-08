<?php

namespace App\Console\Commands;

use App\Models\SubjectGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class GenerateSubjectGroupTranslationsJson extends Command
{
    /**
     * Nombre del comando.
     */
    protected $signature = 'subject-groups:generate-json';

    /**
     * Descripción del comando.
     */
    protected $description = 'Genera el archivo JSON de traducciones de todos los grupos de materias';

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        try {
            $jsonPath = public_path('js/subject-group-translations.json');

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
             * Obtener todos los grupos de materias, incluyendo los inactivos.
             */
            $subjectGroups = SubjectGroup::query()
                ->select('id', 'name')
                ->orderBy('id')
                ->get();

            $translations = [];

            /*
             * Traducciones iniciales conocidas (solo EN y PT).
             * El español siempre viene de la base de datos.
             */
            $initialTranslations = [
                '1' => [
                    'en' => 'Basic',
                    'pt' => 'Básico',
                ],
                '2' => [
                    'en' => 'Primary',
                    'pt' => 'Ensino Primário',
                ],
                '3' => [
                    'en' => 'Secondary',
                    'pt' => 'Ensino Secundário',
                ],
                '7' => [
                    'en' => 'Finance',
                    'pt' => 'Finanças',
                ],
                '9' => [
                    'en' => 'Accounting',
                    'pt' => 'Contabilidade',
                ],
                '10' => [
                    'en' => 'Budget and Cryptoassets',
                    'pt' => 'Orçamento e Criptoativos',
                ],
                '29' => [
                    'en' => 'Statistics',
                    'pt' => 'Estatística',
                ],
                '55' => [
                    'en' => 'Advanced English (CBA and Other Institutes)',
                    'pt' => 'Inglês Avançado (CBA e Outros Institutos)',
                ],
            ];

            foreach ($subjectGroups as $group) {
                $groupId = (string) $group->id;

                // Español siempre viene de la base de datos
                $esTranslation = $group->name;

                // Inglés: prioridad a existente no vacío, luego inicial conocida, luego vacío
                $existingEn = isset($existingTranslations[$groupId]['en']) 
                    ? trim($existingTranslations[$groupId]['en']) 
                    : '';
                $enTranslation = !empty($existingEn) 
                    ? $existingEn 
                    : ($initialTranslations[$groupId]['en'] ?? '');

                // Portugués: prioridad a existente no vacío, luego inicial conocida, luego vacío
                $existingPt = isset($existingTranslations[$groupId]['pt']) 
                    ? trim($existingTranslations[$groupId]['pt']) 
                    : '';
                $ptTranslation = !empty($existingPt) 
                    ? $existingPt 
                    : ($initialTranslations[$groupId]['pt'] ?? '');

                $translations[$groupId] = [
                    'es' => $esTranslation,
                    'en' => $enTranslation,
                    'pt' => $ptTranslation,
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

            $this->info('JSON de grupos de materias generado correctamente.');
            $this->info('Grupos registrados: ' . count($translations));
            $this->info('Archivo: ' . $jsonPath);

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Ocurrió un error al generar el JSON.');
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
