<!-- Informacion inicial del tutor -->
<div class="tutor-card-main">
    @include('vistas.view.pages.components.perfil-tutor.header-info',[
        'tutor' => $tutor
    ])
</div>

<!-- SEECION SI TIENE TUTORIA SEGUN EL ESTUDIANTE QUE MIRA EL PERFIL-->
@if($reservas)
    <div class="subjects-card" id="reservas-tutor">
        @include('vistas.view.pages.components.perfil-tutor.proxima-tutoria',[
            'reservas' => $reservas
        ])
    </div>
@else
@endif

<!-- SECCION DE MATERIAS-->
<div class="subjects-card">
    @include('vistas.view.pages.components.perfil-tutor.materias',[
        'tutor' => $tutor
    ])
</div>

<!-- SECCIÓN DE PESTAÑAS PRINCIPAL -->
<div class="tutor-tabs-card" id="reservar">
    <div class="tutor-tabs-nav">
        <nav class="tutor-tabs-list" aria-label="Tabs">
            <button onclick="changeTab(event, 'introduccion')" class="tutor-tab-btn active">Sobre mí</button>                            
            <button onclick="changeTab(event, 'disponibilidad')" class="tutor-tab-btn">Disponibilidad</button>
            <button onclick="changeTab(event, 'curriculum')" class="tutor-tab-btn">Aspectos Destacados</button>
            <button onclick="changeTab(event, 'resenas')" class="tutor-tab-btn">Reseñas</button>
        </nav>
    </div>
    
    <div class="tutor-tabs-content">
        <div id="introduccion" class="tutor-tab-content">
            <div>
                <h3 class="tutor-section-title">Hola👋 Soy {{ $tutor->profile->first_name ?? '' }}</h3>
                <p class="tutor-section-text">{{ $tutor->profile->description ?? '" Soy un Tutor verificado y aprobado por ClassGo! Listo para responder tus dudas."' }}</p>
            </div>

            <hr class="tutor-section-divider">
            <div>
                <h3 class="tutor-section-title">Puedo hablar</h3>
                @if($tutor->languages && count($tutor->languages))
                    @foreach($tutor->languages as $lang)
                        <span class="tutor-language-tag">{{ $lang->name }}</span>
                    @endforeach
                @else
                    <span class="tutor-language-tag">No especificado</span>
                @endif
            </div>
        </div>
        
        <div id="disponibilidad" class="tutor-tab-content hidden">
            {{-- <h3 class="tutor-section-title-lg">Reserva una sesión</h3> --}}
            {{-- <<<<======LOGICA PARA RESERVAR=======>>>>>>--}}
            <livewire:reserva :tutorId="$tutor->id" />
            
        </div>
        
        <div id="curriculum" class="tutor-tab-content hidden">
            <nav class="tutor-subtabs-nav"><button onclick="changeSubTab(event, 'educacion')" class="tutor-subtab-btn active">Educación</button><button onclick="changeSubTab(event, 'experiencia')" class="tutor-subtab-btn">Experiencia</button><button onclick="changeSubTab(event, 'certificaciones')" class="tutor-subtab-btn">Certificación</button></nav>

            <div id="educacion" class="tutor-subtab-content">
                @include('vistas.view.pages.components.perfil-tutor.education', [
                    'tutor' => $tutor
                ])
            </div>

            <div id="experiencia" class="tutor-subtab-content hidden">
                @include('vistas.view.pages.components.perfil-tutor.experience',[
                    'tutor' => $tutor
                ])
            </div>

            <div id="certificaciones" class="tutor-subtab-content hidden">
                @include('vistas.view.pages.components.perfil-tutor.certificates', [
                    'tutor' => $tutor
                ])

            </div>
        </div>

        <div id="resenas" class="tutor-tab-content hidden">
            <h3 class="tutor-section-title" style="margin-bottom: 1.5rem;">Reseñas de estudiantes</h3>

            <!--CONTENIDO DE COMENTARIOS Y CALIFICACIONES-->
            @include('vistas.view.pages.components.perfil-tutor.coments', [
                'tutor' => $tutor,
                'reviews' => $reviews,
                'avgRating' => $avgRating,
                'totalReviews' => $totalReviews,
                'ratingDistribution' => $ratingDistribution
            ])
        </div>
    </div>
</div>
