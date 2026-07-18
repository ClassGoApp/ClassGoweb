<h2 class="subjects-card__title" data-translate="tutor_profile_my_tutoring">
    Mis Tutorías
</h2>
    <div class="subjects-list">
        @php
            // Agrupar materias por grupo (asumiendo que $tutor->userSubjects está disponible)
            $materiasPorGrupo = [];
            if(isset($tutor->userSubjects)) {
                foreach($tutor->userSubjects as $userSubject) {
                    $grupo = $userSubject->subject->group->name ?? 'Otros';
                    $materia = $userSubject->subject->name ?? null;
                    if($materia) {
                        $materiasPorGrupo[$grupo][] = $materia;
                    }
                }
            }
            
            // Ordenar grupos para que "Secundaria" y "Primaria" queden al final
            $materiasPorGrupo = collect($materiasPorGrupo)->sortBy(function($value, $key) {
                // Grupos que van al final
                $gruposAlFinal = ['Secundaria', 'Primaria', 'Básico'];
                
                // Si el grupo está en la lista, prioridad 1 (al final)
                // Si no está, prioridad 0 (al inicio)
                return in_array($key, $gruposAlFinal, true) ? 1 : 0;
            })->toArray();
      
            // Definir los 3 bloques SVG completos que quieres alternar.
            $icons = [
                '<span class="subject-item__icon subject-item__icon--math"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18" /></svg></span>',
                '<span class="subject-item__icon subject-item__icon--design"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></span>',
                '<span class="subject-item__icon subject-item__icon--mechanics"><svg xmlns="http://www.w3.org/2000/svg" class="subject-item__svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>',
            ];
        @endphp

        @foreach($materiasPorGrupo as $grupo => $materiasGrupo)
            <div class="subject-item">
                <div class="subject-item__header">
                    {!! $icons[$loop->index % count($icons)] !!}

                    @php
                        $grupoTranslateKey = match($grupo) {
                            'Otros' => 'subject_group_others',
                            'Secundaria' => 'subject_group_secondary',
                            'Primaria' => 'subject_group_primary',
                            'Básico' => 'subject_group_basic',
                            default => null
                        };
                    @endphp

                    <h3 class="subject-item__name"
                        @if($grupoTranslateKey) data-translate="{{ $grupoTranslateKey }}" @endif>
                        {{ $grupo }}
                    </h3>
                </div>
                
                <div class="subject-item__topics">
                    @foreach($materiasGrupo as $materia)
                        <span class="topic-tag">{{ $materia }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
        
        
    </div>