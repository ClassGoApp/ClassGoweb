@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | Preguntas')

@section('body-class', 'preguntas')

@section('content')
<!--PREGUNTAS-->
<section class="preguntas">
    <div class="preguntas-container">
        <div class="preguntas-header">
            <div class="preguntas-header-content">
                <div class="preguntas-header-text align-left">
                    <nav class="breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-link" data-translate="inicio">Inicio</a> / 
                        <span class="breadcrumb-current" data-translate="preguntas">Preguntas</span>
                    </nav>
                    <h1 data-translate="encuentra_respuesta">Encuentra tu respuesta</h1>
                    <p data-translate="empoderando_estudiantes">Empoderando a los estudiantes en todo el mundo</p>
                </div>
                <div class="preguntas-tabs tabs-centered">
                    <div class="tab-buttons">
                        <button class="tab-button active" data-tab="estudiantes">
                            <i class="fa-solid fa-book"></i>
                            <span data-translate="para_estudiantes_faq">Para estudiantes</span>
                        </button>
                        <button class="tab-button" data-tab="tutores">
                            <i class="fa-solid fa-briefcase"></i>
                            <span data-translate="para_tutores_faq">Para tutores</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

            <!-- Estudiantes Tab Content -->
            <div class="tab-content active" id="estudiantes-content">
                <div class="preguntas-section">
                    <div class="preguntas-content">
                        <div class="preguntas-faq">
                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_encontrar_tutor">¿Cómo encontrar un tutor?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_encontrar_tutor_desc">Utilice la barra de búsqueda para encontrar tutores disponibles según la materia o tema que necesites</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_reservar_sesion">¿Cómo reservo una sesión?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_reservar_sesion_desc">Una vez que encuentres un tutor, consulta su perfil y selecciona un horario disponible que te convenga. Haz clic en "Reservar” y sigue las instrucciones para confirmar tu sesión.</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_cancelar_reprogramar">¿Qué pasa si necesito cancelar o reprogramar una sesión?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_cancelar_reprogramar_desc">Las tutorías no pueden cancelarse una vez reservadas. Si ocurrió algún inconveniente, contactanos y con gusto te ayudaremos</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_pagos">¿Cómo pago las sesiones?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_pagos_desc">Los pagos se realizan a través del Qr proporcionado en tu reserva o también por transferencia bancaria con los datos que se muestran en pantalla.</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_tutor_no_presente">¿Qué debo hacer si mi tutor no se presenta?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_tutor_no_presente_desc">Si tu tutor no se presenta a una sesión programada, comuníquese con nuestro equipo de soporte de inmediato para obtener ayuda y agender una reprogramación o agendar un reembolso.</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_comentarios_tutor">¿Cómo puedo dejar comentarios para mi tutor?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_comentarios_tutor_desc">Entra al perfil del tutor, desliza hacia abajo y dirígete a la sección de reseñas, donde podrás ver las calificaciones y comentarios de los estudiantes.</p>
                                </div>
                            </div>
                        </div>
                        <div class="preguntas-image">
                            <img src="{{ asset('images/home/TugoUniversitario.webp') }}" alt="Estudiante con preguntas">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tutores Tab Content -->
            <div class="tab-content" id="tutores-content">
                <div class="preguntas-section">
                    <div class="preguntas-content">
                        <div class="preguntas-faq">
                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_ser_tutor">¿Cómo puedo ser tutor?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p>
                                        <span data-translate="faq_ser_tutor_desc_txt1">Si no te creaste aún cuenta </span>
                                        <a href="{{ route('login') }}">
                                            <span data-translate="faq_ser_tutor_desc_link">haz click aquí</span>
                                        </a>
                                        <span data-translate="faq_ser_tutor_desc_txt2">
                                            y rellena el formulario y al final selecciona "Tutor". Cree su perfil y envie la documentación necesaria para su aprobación.
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_cualificaciones_tutor">¿Qué cualificaciones necesito para ser tutor?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_cualificaciones_tutor_desc">No es requisito tener titulación académica. Si quieres enseñar "algo" puedes hacerlo.</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_configurar_disponibilidad">¿Cómo configuro mi disponibilidad?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_configurar_disponibilidad_desc">Inicia sesión en tu cuenta, accede a la sección “Administrar tiempo disponible” y actualiza tu calendario con tus franjas horarias disponibles.</p>
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-question" onclick="toggleFaq(this)">
                                    <h3 data-translate="faq_estudiante_cancela">¿Qué debo hacer si un estudiante cancela una sesión?</h3>
                                    <div class="faq-toggle">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="faq-answer">
                                    <p data-translate="faq_estudiante_cancela_desc">Los estudiantes no tienen la opción de cancelar una sesión después de reservarla. Si el alumno te informa de algún problema, recomiéndale escribir a nuestro contacto para recibir ayuda.</p>
                                </div>
                            </div>
                        </div>
                        <div class="preguntas-image">
                            <img src="{{ asset('images/home/Tugotecnológico.webp') }}" alt="Tutor con preguntas">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    // Funcionalidad de tabs
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remover clase active de todos los botones y contenidos
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Agregar clase active al botón clickeado y su contenido
                this.classList.add('active');
                document.getElementById(targetTab + '-content').classList.add('active');
            });
        });
    });

    // Funcionalidad del acordeón FAQ
    function toggleFaq(element) {
        const faqItem = element.parentElement;
        const answer = faqItem.querySelector('.faq-answer');
        const toggle = element.querySelector('.faq-toggle i');

        // Cerrar todos los otros items
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== faqItem) {
                item.classList.remove('active');
                item.querySelector('.faq-answer').style.maxHeight = '0px';
                item.querySelector('.faq-toggle i').className = 'fa-solid fa-chevron-down';
            }
        });

        // Toggle del item actual
        if (faqItem.classList.contains('active')) {
            faqItem.classList.remove('active');
            answer.style.maxHeight = '0px';
            toggle.className = 'fa-solid fa-chevron-down';
        } else {
            faqItem.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            toggle.className = 'fa-solid fa-chevron-up';
        }
    }
</script>

@endsection