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
                <!-- Grid de las alianzas agrupadas por categoría -->
                <script>console.log('Categoría:', @json($alianzas));</script>
                @php
                    $groups = $alianzas->groupBy(function($item) {
                        $cat = strtolower(trim($item->categoria ?: 'otros'));
                        
                        return match($cat) {
                            'empresas' => 'Empresas',
                            'colegio de profesionales' => 'Colegio de Profesionales',
                            'universidad e instituto' => 'Universidad e Instituto',
                            'otros' => 'Otros',
                            default => ucwords($cat) // Para los "etc", pone la primera letra en mayúscula
                        };
                    });
                    
                    // Reordenar para que "Otros" aparezca al final y el orden de las catergorias
                    $groups = $groups->sortBy(function($items, $categoria){
                        return match($categoria){
                            'Colegio de Profesionales' => 1,
                            'Universidad e Instituto' => 2,
                            'Empresas' => 3,
                            'Otros' => 999,
                            default => 50
                        };
                    });
                   
                @endphp

                @foreach($groups as $categoria => $items)
                    <div class="alianzas-category-section" style="margin-bottom: 48px;">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                            <!-- Encabezado de categoría: ocupa toda la fila -->
                            <div style="grid-column: 1 / -1; display:flex; align-items:center; gap:14px; margin-bottom:12px;">
                                <div style="background:rgba(255,255,255,0.12); border-radius:12px; padding:10px 12px; display:flex; align-items:center; justify-content:center;">
                                    @if(strtolower($categoria) === 'empresas')
                                        <svg fill="#ffffff" width="100" height="100" viewBox="0 0 50.00 50.00" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#ffffff" stroke-width="0.0005"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M8 2L8 6L4 6L4 48L46 48L46 14L30 14L30 6L26 6L26 2 Z M 10 4L24 4L24 8L28 8L28 46L19 46L19 39L15 39L15 46L6 46L6 8L10 8 Z M 10 10L10 12L12 12L12 10 Z M 14 10L14 12L16 12L16 10 Z M 18 10L18 12L20 12L20 10 Z M 22 10L22 12L24 12L24 10 Z M 10 15L10 19L12 19L12 15 Z M 14 15L14 19L16 19L16 15 Z M 18 15L18 19L20 19L20 15 Z M 22 15L22 19L24 19L24 15 Z M 30 16L44 16L44 46L30 46 Z M 32 18L32 20L34 20L34 18 Z M 36 18L36 20L38 20L38 18 Z M 40 18L40 20L42 20L42 18 Z M 10 21L10 25L12 25L12 21 Z M 14 21L14 25L16 25L16 21 Z M 18 21L18 25L20 25L20 21 Z M 22 21L22 25L24 25L24 21 Z M 32 22L32 24L34 24L34 22 Z M 36 22L36 24L38 24L38 22 Z M 40 22L40 24L42 24L42 22 Z M 32 26L32 28L34 28L34 26 Z M 36 26L36 28L38 28L38 26 Z M 40 26L40 28L42 28L42 26 Z M 10 27L10 31L12 31L12 27 Z M 14 27L14 31L16 31L16 27 Z M 18 27L18 31L20 31L20 27 Z M 22 27L22 31L24 31L24 27 Z M 32 30L32 32L34 32L34 30 Z M 36 30L36 32L38 32L38 30 Z M 40 30L40 32L42 32L42 30 Z M 10 33L10 37L12 37L12 33 Z M 14 33L14 37L16 37L16 33 Z M 18 33L18 37L20 37L20 33 Z M 22 33L22 37L24 37L24 33 Z M 32 34L32 36L34 36L34 34 Z M 36 34L36 36L38 36L38 34 Z M 40 34L40 36L42 36L42 34 Z M 32 38L32 40L34 40L34 38 Z M 36 38L36 40L38 40L38 38 Z M 40 38L40 40L42 40L42 38 Z M 10 39L10 44L12 44L12 39 Z M 22 39L22 44L24 44L24 39 Z M 32 42L32 44L34 44L34 42 Z M 36 42L36 44L38 44L38 42 Z M 40 42L40 44L42 44L42 42Z"></path></g></svg>
                                    @elseif (strtolower($categoria) === 'universidad e instituto')
                                        <svg fill="#ffffff" width="80" height="80" viewBox="0 0 16.00 16.00" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00016"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.096"></g><g id="SVGRepo_iconCarrier"><path d="M16 6.28a1.23 1.23 0 0 0-.62-1.07l-6.74-4a1.27 1.27 0 0 0-1.28 0l-6.75 4a1.25 1.25 0 0 0 0 2.15l1.92 1.12v2.81a1.28 1.28 0 0 0 .62 1.09l4.25 2.45a1.28 1.28 0 0 0 1.24 0l4.25-2.45a1.28 1.28 0 0 0 .62-1.09V8.45l1.24-.73v2.72H16V6.28zm-3.73 5L8 13.74l-4.22-2.45V9.22l3.58 2.13a1.29 1.29 0 0 0 1.28 0l3.62-2.16zM8 10.27l-6.75-4L8 2.26l6.75 4z"></path></g></svg>
                                    @elseif (strtolower($categoria) === 'colegio de profesionales')
                                        <svg fill="#ffffff" height="80" width="80" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M187.733,315.733c0,4.71,3.823,8.533,8.533,8.533H230.4c4.71,0,8.533-3.823,8.533-8.533v-51.2 c0-4.71-3.823-8.533-8.533-8.533h-34.133c-4.71,0-8.533,3.823-8.533,8.533V315.733z M204.8,273.067h17.067V307.2H204.8V273.067z"></path> <path d="M196.267,221.867H230.4c4.71,0,8.533-3.823,8.533-8.533v-51.2c0-4.71-3.823-8.533-8.533-8.533h-34.133 c-4.71,0-8.533,3.823-8.533,8.533v51.2C187.733,218.044,191.556,221.867,196.267,221.867z M204.8,170.667h17.067V204.8H204.8 V170.667z"></path> <path d="M132.395,160.913L256,86.75l123.605,74.163c1.374,0.828,2.893,1.22,4.386,1.22c2.901,0,5.726-1.476,7.322-4.139 c2.432-4.045,1.118-9.284-2.918-11.708L264.533,71.97V17.067H307.2v17.067h-25.6c-4.71,0-8.533,3.823-8.533,8.533 c0,4.71,3.823,8.533,8.533,8.533h34.133c4.71,0,8.533-3.823,8.533-8.533V8.533c0-4.71-3.823-8.533-8.533-8.533H256 c-4.71,0-8.533,3.823-8.533,8.533V71.97l-123.861,74.317c-4.036,2.423-5.35,7.663-2.918,11.708 C123.102,162.031,128.358,163.345,132.395,160.913z"></path> <path d="M93.867,324.267c4.71,0,8.533-3.823,8.533-8.533v-51.2c0-4.71-3.823-8.533-8.533-8.533H59.733 c-4.71,0-8.533,3.823-8.533,8.533V281.6c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-8.533h17.067v42.667 C85.333,320.444,89.156,324.267,93.867,324.267z"></path> <path d="M153.6,435.2V187.733c0-4.71-3.823-8.533-8.533-8.533c-4.71,0-8.533,3.823-8.533,8.533V435.2 c0,4.71,3.823,8.533,8.533,8.533C149.777,443.733,153.6,439.91,153.6,435.2z"></path> <path d="M110.933,477.867h290.133c4.71,0,8.533-3.823,8.533-8.533s-3.823-8.533-8.533-8.533h-76.8v-85.333h8.533 c4.71,0,8.533-3.823,8.533-8.533s-3.823-8.533-8.533-8.533H179.2c-4.71,0-8.533,3.823-8.533,8.533s3.823,8.533,8.533,8.533h8.533 V460.8h-76.8c-4.71,0-8.533,3.823-8.533,8.533S106.223,477.867,110.933,477.867z M264.533,426.667 c4.71,0,8.533-3.823,8.533-8.533s-3.823-8.533-8.533-8.533v-34.133H307.2V460.8h-42.667V426.667z M204.8,375.467h42.667V409.6 c-4.71,0-8.533,3.823-8.533,8.533s3.823,8.533,8.533,8.533V460.8H204.8V375.467z"></path> <path d="M452.267,366.933h-34.133c-4.71,0-8.533,3.823-8.533,8.533v51.2c0,4.71,3.823,8.533,8.533,8.533h34.133 c4.71,0,8.533-3.823,8.533-8.533v-51.2C460.8,370.756,456.977,366.933,452.267,366.933z M443.733,418.133h-17.067V384h17.067 V418.133z"></path> <path d="M452.267,264.533h-34.133c-4.71,0-8.533,3.823-8.533,8.533v51.2c0,4.71,3.823,8.533,8.533,8.533h34.133 c4.71,0,8.533-3.823,8.533-8.533v-51.2C460.8,268.356,456.977,264.533,452.267,264.533z M443.733,315.733h-17.067V281.6h17.067 V315.733z"></path> <path d="M435.2,494.933H76.8c-4.71,0-8.533,3.823-8.533,8.533S72.09,512,76.8,512h358.4c4.71,0,8.533-3.823,8.533-8.533 S439.91,494.933,435.2,494.933z"></path> <path d="M503.467,187.733c-4.71,0-8.533,3.823-8.533,8.533v8.533h-93.867c-4.71,0-8.533,3.823-8.533,8.533 c0,4.71,3.823,8.533,8.533,8.533h93.867v281.6c0,4.71,3.823,8.533,8.533,8.533s8.533-3.823,8.533-8.533v-307.2 C512,191.556,508.177,187.733,503.467,187.733z"></path> <path d="M273.067,315.733c0,4.71,3.823,8.533,8.533,8.533h34.133c4.71,0,8.533-3.823,8.533-8.533v-51.2 c0-4.71-3.823-8.533-8.533-8.533H281.6c-4.71,0-8.533,3.823-8.533,8.533V315.733z M290.133,273.067H307.2V307.2h-17.067V273.067z "></path> <path d="M85.333,418.133c0-1.109-0.486-110.933-42.667-110.933C0.486,307.2,0,417.024,0,418.133 c0,20.608,14.686,37.837,34.133,41.805v43.529c0,4.71,3.823,8.533,8.533,8.533c4.71,0,8.533-3.823,8.533-8.533v-43.529 C70.647,455.97,85.333,438.741,85.333,418.133z M42.667,443.733c-14.114,0-25.6-11.486-25.6-25.6 c0-42.513,11.418-93.867,25.6-93.867c14.182,0,25.6,51.354,25.6,93.867C68.267,432.247,56.781,443.733,42.667,443.733z"></path> <path d="M375.467,435.2v-256c0-4.71-3.823-8.533-8.533-8.533s-8.533,3.823-8.533,8.533v256c0,4.71,3.823,8.533,8.533,8.533 S375.467,439.91,375.467,435.2z"></path> <path d="M281.6,221.867h34.133c4.71,0,8.533-3.823,8.533-8.533v-51.2c0-4.71-3.823-8.533-8.533-8.533H281.6 c-4.71,0-8.533,3.823-8.533,8.533v51.2C273.067,218.044,276.89,221.867,281.6,221.867z M290.133,170.667H307.2V204.8h-17.067 V170.667z"></path> <path d="M8.533,298.667c4.71,0,8.533-3.823,8.533-8.533v-68.267h93.867c4.71,0,8.533-3.823,8.533-8.533 c0-4.71-3.823-8.533-8.533-8.533H17.067v-8.533c0-4.71-3.823-8.533-8.533-8.533S0,191.556,0,196.267v93.867 C0,294.844,3.823,298.667,8.533,298.667z"></path> </g> </g> </g> </g></svg>
                                    @else
                                        <i class="fas fa-layer-group" style="color:#ffffff; font-size:1.2rem;"></i>
                                    @endif
                                </div>
                                <div style="line-height:1.3;">
                                    <h2 style="color:#ffffff; margin:0; font-size:1.6rem; font-weight:700;">{{ ucfirst($categoria) }}</h2>
                                    <p style="color:rgba(255,255,255,0.75); margin:0; font-size:0.85rem;">{{ $items->count() }} alianzas activas</p>
                                </div>
                            </div>
                            
                            @foreach ($items as $alianza)
                                <!--card de alianzas-->
                                <div class="fade-up">
                                    <div class="alliance-card" id="card-{{ $alianza->id }}">
                                        <div class="logo-circle-container">
                                            <div class="logo-circle" onclick="window.open('{{ $alianza->enlace }}', '_blank')">
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
                                                        <img src="{{ $imageSrc }}" alt="{{ $alianza->titulo }}">
                                                    @else
                                                        <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="front-footer">
                                            <h3 class="alliance-name-front">{{ $alianza->titulo }}</h3>
                                            <button class="btn-base btn-more" onclick="toggleDetails('card-{{ $alianza->id }}')">
                                                <i class="fas fa-plus-circle text-[10px]"></i> Ver detalles
                                            </button>
                                        </div>
                                        <!-- CAPA DE DESCRIPCIÓN  -->
                                        <div class="detail-layer">
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
                                                        class="detail-watermark">
                                                @else
                                                    <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                                        class="detail-watermark">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                                    class="detail-watermark">
                                            @endif
                                            <div class="detail-content">
                                                <span class="detail-tag">Información Detallada</span>
                                                <h3 class="mt-1" style="font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 1.3rem; color: var(--dark-teal); text-align: center; line-height: 1.2;">
                                                    {{ $alianza->titulo }}
                                                </h3>
                                                
                                                <div class="description-text">
                                                    {{ $alianza->descripcion }}
                                                </div>
                                                
                                                <div class="flex flex-col w-full px-4 mt-auto">
                                                    <a onclick="window.open('{{ $alianza->enlace }}', '_blank')" target="_blank" class="btn-base btn-visit shadow-xl">
                                                        Visitar sitio oficial <i class="fas fa-external-link-alt ml-2 text-[10px]"></i>
                                                    </a>
                                                    <button class="btn-base btn-return mx-auto" onclick="toggleDetails('card-{{ $alianza->id }}')">
                                                        Regresar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
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
    {{-- estilos en nosotros.css --}}
    <script>
        /// ===========================
        /// FUNCIONALIDAD DE LAS TARJETAS DE ALIANZAS
        /// ===========================
        function toggleDetails(id) {
            const card = document.getElementById(id);
            if (card) {
                card.classList.toggle('is-active');
            }
        }
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
