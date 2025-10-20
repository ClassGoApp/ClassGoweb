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
                        <a href="{{ route('home') }}" class="breadcrumb-link" data-translate="inicio"></a> / <span class="breadcrumb-current" data-translate="preguntas"></span>
                    </nav>
                    <h1 data-translate="encuentra_respuesta"></h1>
                    <p data-translate="empoderando_estudiantes"></p>
                </div>
                <div class="preguntas-tabs tabs-centered">
                    <div class="tab-buttons">
                        <button class="tab-button active" data-tab="estudiantes">
                            <i class="fa-solid fa-book"></i>
                            <a data-translate="para_estudiantes_faq"></a>
                        </button>
                        <button class="tab-button" data-tab="tutores">
                            <i class="fa-solid fa-briefcase"></i>
                            <a data-translate="para_tutores_faq"></a>
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
                                <h3 data-translate="faq_encontrar_tutor"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_encontrar_tutor_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_reservar_sesion"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_reservar_sesion_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_cancelar_reprogramar"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_cancelar_reprogramar_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_pagos"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_pagos_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_tutor_no_presente"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_tutor_no_presente_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_comentarios_tutor"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_comentarios_tutor_desc"></p>
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
                                <h3 data-translate="faq_ser_tutor"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p><a data-translate="faq_ser_tutor_desc_txt1"></a><a href="{{ route('register') }}"> <span data-translate="faq_ser_tutor_desc_link"></span></a><a data-translate="faq_ser_tutor_desc_txt2"></a></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_cualificaciones_tutor"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_cualificaciones_tutor_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_configurar_disponibilidad"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_configurar_disponibilidad_desc"></p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq(this)">
                                <h3 data-translate="faq_estudiante_cancela"></h3>
                                <div class="faq-toggle">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p data-translate="faq_estudiante_cancela_desc"></p>
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