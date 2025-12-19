@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')
    <!--NOSOTROS-->
    <section class="nosotros">
        <div class="nosotros-container">
            <div class="nosotros-header fade-down">
                <div class="nosotros-header-content ">
                    <div class="nosotros-header-text fade-left">
                        <nav class="breadcrumb">
                            <a href="{{ route('home') }}" class="breadcrumb-link"><span data-translate="ini_n"></span></a> /
                            <span class="breadcrumb-current" data-translate="i_nos"></span>
                        </nav>
                        <h1 data-translate="who"></h1>
                        <p data-translate="plataforma_d_tutoria">
                        </p>
                    </div>
                    <div class="nosotros-header-image">
                        <img src="{{ asset('images/home/tugo2.webp') }}" alt="Misión ClassGo" class="tugo-image">
                    </div>
                </div>
            </div>

            <div class="nosotros-mision" id="mision">
                <div class="nosotros-mision-text fade-left">
                    <h2 class="nosotros-mision-title" data-translate="mision"></h2>
                    <p class="nosotros-mision-text-general1" data-translate="plataforma_d_educacion">
                    </p>
                    <p class="nosotros-mision-text-general2" data-translate="proporcionamos_educacion">
                    </p>
                </div>
                <div class="nosotros-mision-image">
                    {{-- <p class="nosotros-mision-porcentaje">
                    <span class="nosotros-mision-porcentaje-text">
                        +200 <!-- Porcentaje de Tutores Disponibles -->
                    </span>
                    <span class="nosotros-porcentaje-subtext" data-translate="tutorias_disponibles">
                    </span>
                </p> --}}
                    <img src="{{ asset('images/home/models/img1.webp') }}" alt="Misión ClassGo" class="tugo-image">
                </div>
            </div>

            <div class="nosotros-vision" id="vision">
                <div class="vision-image">
                    <img src="{{ asset('images/home/models/img2.webp') }}" alt="Visión ClassGo" class="tugo-image">
                </div>
                <div class="nosotros-vision-text fade-right">
                    <h2 class="nosotros-vision-title" data-translate="vision"></h2>
                    <p class="nosotros-vision-subtext" data-translate="ser_plataforma_lider">
                    </p>
                    <p class="nosotros-vision-subtext2" data-translate="fomentar_aprendizaje">
                    </p>
                </div>
            </div>

            <!-- SECCIÓN ALIANZAS -->
            <div class="alianzas-eventos-section">
                <div class="section-header">
                    <span data-translate="alianzas" class="section-tagline-nosotros"></span>
                    <h1 class="over-text-nosotros"><span data-translate="alianzas_edu"></span></h1>
                    <p class="section-description-nosotros">
                        <span data-translate="alianzas_Classgo"></span>
                    </p>
                </div>

                <div class="alianzas-eventos-grid">
                    @foreach ($alianzas as $alianza)
                        <div class="fade-up">
                            <div class="alianza-evento-card animate-in">
                                @if ($alianza->imagen)
                                    @php
                                        $imagePath = storage_path('app/public/' . $alianza->imagen);
                                        $imageExists = file_exists($imagePath);
                                    @endphp

                                    @if ($imageExists)
                                        @php
                                            $imageData = base64_encode(file_get_contents($imagePath));
                                            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                            $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="{{ $alianza->titulo }}"
                                            class="client-logo alianza-evento-imagen">
                                    @else
                                        <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                            class="client-logo alianza-evento-imagen">
                                    @endif
                                    {{-- <img 
                            src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" 
                            alt="Imagen de {{ $alianza->titulo }}" 
                            class="client-logo alianza-evento-imagen"> --}}
                                @else
                                    <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                        class="client-logo alianza-evento-imagen">
                                @endif

                                <div class="alianza-evento-info">
                                    <h3>{{ $alianza->titulo }}</h3>
                                    <p class="alianza-descripcion">{{ $alianza->descripcion }}</p>
                                    <button class="btn-blanco" onclick="window.open('{{ $alianza->enlace }}', '_blank')">
                                        Visitar sitio
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SECCION TEAM-->
            <div class="team-section" id="team">
                <div class="team-header">
                    <h1 class="team-title" data-translate="team">Nuestro Equipo</h1>
                    <p class="team-subtitle" data-translate="creadores_classgo">Los creadores de la página y app...</p>
                </div>

                {{-- Iteramos sobre los GRUPOS (Fila 1, Fila 2, etc.) --}}
                @foreach($teamGroups as $order => $members)
                    
                    {{-- CONTENEDOR DE LA FILA --}}
                    <div class="{{ $order == 1 ? 'team-row-centered' : 'team-grid' }}" style="{{ $order > 1 ? 'margin-top: 30px;' : '' }}">
                        
                        @foreach($members as $member)
                            <div class="team-member fade-up">
                                <div class="member-item">
                                    
                                    {{-- FOTO DEL MIEMBRO (Lógica Base64 Robusta) --}}
                                    <div class="member-photo-wrapper">
                                        @php
                                            $imageSrc = asset('images/default-user.png'); // Imagen por defecto
                                            
                                            if($member->photo) {
                                                // 1. Buscamos la ruta física real en el servidor
                                                $imagePath = storage_path('app/public/' . $member->photo);
                                                
                                                // 2. Verificamos si el archivo existe realmente
                                                if(file_exists($imagePath)) {
                                                    // 3. Convertimos a Base64
                                                    $imageData = base64_encode(file_get_contents($imagePath));
                                                    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                    $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                                } else {
                                                    // Intento secundario con asset normal si falla el path físico
                                                    $imageSrc = asset('storage/' . $member->photo);
                                                }
                                            }
                                        @endphp

                                        <img src="{{ $imageSrc }}" 
                                            alt="Foto de {{ $member->name }}"
                                            class="member-photo"
                                            onerror="this.src='{{ asset('images/Tugo-rostro.png') }}'">
                                    </div>

                                    {{-- RED SOCIAL --}}
                                    @if($member->platform_link)
                                        @php
                                            $platformName = strtolower($member->platform); 
                                            
                                            $socialIcon = 'Tugo-rostro.png'; 

                                            switch ($platformName) {
                                                case 'linkedin':
                                                    $socialIcon = 'linkedin.png';
                                                    break;
                                                
                                                case 'github':
                                                    $socialIcon = 'Github.png';
                                                    break;
                                                
                                                case 'facebook':
                                                    $socialIcon = 'facebook.png';
                                                    break;
                                                
                                                case 'twitter':
                                                case 'x':
                                                    $socialIcon = 'twitter.png';
                                                    break;
                                                    
                                                default:
                                                    $socialIcon = 'Tugo-rostro.png';
                                                    break;
                                            }
                                        @endphp

                                        <a href="{{ $member->platform_link }}" target="_blank" class="member-link">
                                            <img class="arrow-icon" 
                                                src="{{ asset('images/' . $socialIcon) }}" 
                                                alt="{{ $platformName }}"
                                                style="display: inline-block;"
                                                onerror="this.src='{{ asset('images/Tugo-rostro.png') }}'">
                                        </a>
                                    @endif
                                </div>
                                
                                {{-- NOMBRE Y CARGO --}}
                                <h3 class="member-name">{{ $member->name }} {{ $member->last_name }}</h3>
                                <p class="member-title">{{ $member->role }}</p>
                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>


    </section>
    <style>
        /* =========================================
        ESTILOS DE ESTRUCTURA
        ========================================= */
        
        /* Clase para el CEO (Orden 1) */
        .team-row-centered {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
        }

        /* Flexbox */
        .team-grid {
            display: flex;             
            flex-wrap: wrap;           
            justify-content: center;    
            gap: 30px;                  
            width: 100%;
            max-width: 1200px;          
            margin: 0 auto;           
        }

        .team-member {
            /* Controlamos el ancho de cada tarjeta */
            flex: 0 0 auto;             
            width: 250px;               
            text-align: center;
            position: relative; 
        }

        /* Ajuste responsivo para móviles: que ocupen todo el ancho si la pantalla es muy pequeña */
        @media (max-width: 600px) {
            .team-member {
                width: 100%;
                max-width: 300px;
            }
        }

        .member-item {
            position: relative; 
            display: inline-block; 
            margin-bottom: 15px;
        }
        
        /* 1. El contenedor del enlace */
        .member-link {
            position: absolute;
            bottom: 0;
            right: 0; 
            
            width: 40px; 
            height: 40px;
            
            background-color: #ffffff; 
            border-radius: 50%; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.15); 
            
            display: flex;
            justify-content: center;
            align-items: center;
            
            transition: transform 0.3s ease;
            text-decoration: none;
            z-index: 10;
            overflow: hidden; 
        }

        .member-link:hover {
            transform: translateY(-3px) scale(1.1);
        }

        /* 2. La imagen del logo */
        .arrow-icon {
            width: 80%; 
            height: 80%;
            object-fit: cover; 
            border-radius: 50%; 
            padding: 2px; 
            background: transparent !important; 
            display: block;
        }

        /* Estilos de la foto de perfil */
        .member-photo-wrapper {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .member-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .member-title {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }
    </style>
    <script>
        // ===========================
        // 1. ANIMACIONES AL HACER SCROLL
        // ===========================
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.2
        });

        // Observar elementos con clases de animación
        document.querySelectorAll('.fade-up, .fade-left, .fade-right, .fade-down').forEach(el => {
            scrollObserver.observe(el);
        });
    </script>
@endsection
