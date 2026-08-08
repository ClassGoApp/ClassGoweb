<h2 class="subjects-card__title" data-translate="tutor_profile_my_tutoring">
    Mis Tutorías
</h2>
    <div class="subjects-list">
        @php
            // Agrupar materias por grupo usando group_id como clave
            $materiasPorGrupo = [];

            if (isset($tutor->userSubjects)) {
                foreach ($tutor->userSubjects as $userSubject) {
                    $subject = $userSubject->subject;

                    if (!$subject) {
                        continue;
                    }

                    // Usar group_id como clave, o 'sin_grupo' para materias sin grupo
                    $grupoId = $subject->group->id ?? 'sin_grupo';
                    $grupoNombre = $subject->group->name ?? 'Otros';

                    // Inicializar el grupo si no existe
                    if (!isset($materiasPorGrupo[$grupoId])) {
                        $materiasPorGrupo[$grupoId] = [
                            'group_id' => $grupoId === 'sin_grupo' ? null : $grupoId,
                            'group_name' => $grupoNombre,
                            'subjects' => []
                        ];
                    }

                    // Agregar la materia al grupo
                    $materiasPorGrupo[$grupoId]['subjects'][] = [
                        'id' => $subject->id,
                        'name' => $subject->name,
                    ];
                }
            }
            
            // Ordenar grupos para que IDs 1, 2, 3 (Básico, Primaria, Secundaria) queden al final
            $materiasPorGrupo = collect($materiasPorGrupo)->sortBy(function($grupoData, $key) {
                // Grupos que van al final por ID
                $gruposAlFinal = [1, 2, 3];
                
                // Si el grupo está en la lista, prioridad 1 (al final)
                // Si no está, prioridad 0 (al inicio)
                return in_array($grupoData['group_id'], $gruposAlFinal, true) ? 1 : 0;
            })->toArray();
      
            // Definir los 3 bloques SVG completos que quieres alternar.
            $icons = [
                '<span class="subject-item__icon subject-item__icon--math"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18" /></svg></span>',
                '<span class="subject-item__icon subject-item__icon--design"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></span>',
                '<span class="subject-item__icon subject-item__icon--mechanics"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>',
            ];
        @endphp

        @foreach($materiasPorGrupo as $grupoKey => $grupoData)
            <div class="subject-item">
                <div class="subject-item__header">
                    {!! $icons[$loop->index % count($icons)] !!}

                    @if($grupoData['group_id'] === null)
                        {{-- Grupo sin ID: usar traducción hardcodeada para "Otros" --}}
                        <h3 class="subject-item__name" data-translate="subject_group_others">
                            {{ $grupoData['group_name'] }}
                        </h3>
                    @else
                        {{-- Grupo con ID: usar traducción dinámica --}}
                        <h3 class="subject-item__name subject-group-translatable"
                            data-subject-group-id="{{ $grupoData['group_id'] }}"
                            data-subject-group-fallback="{{ $grupoData['group_name'] }}">
                            {{ $grupoData['group_name'] }}
                        </h3>
                    @endif
                </div>
                
                <div class="subject-item__topics">
                    @foreach($grupoData['subjects'] as $materia)
                        <span class="topic-tag subject-translatable"
                            data-subject-id="{{ $materia['id'] }}"
                            data-subject-fallback="{{ e($materia['name']) }}">
                            {{ $materia['name'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
        
        
    </div>
