@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')


    <section class="seccion-blog">
        <div class="contenido-blog">

            <div class="blog-header">
                <div class="blog-header-content">
                    <div class="information">
                        <h1 data-translate="ideas">Ideas y consejos de expertos para estudiantes de por vida</h1>
                        <h2 data-translate="Acceda">Acceda a informacion valiosa, consejos de expertos y sugerencias de nuestra activa comunidad de tutores.
                        </h2>
                        <div class="filtro">
                            <span class=filtro-blog-icon>
                                <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">

                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd">
                                    </path>

                                </svg>
                            </span>
                            <input class="filtro-blog-input" type="text" placeholder="Buscar por palabra clave">
                            <button class="button-buscar"><span data-translate="bus">Buscar</span></button>
                        </div>
                    </div>
                    <div class="logo-tugo-megafono">
                        <img src="{{ asset('images/home/blogs/Community-Management.png') }}" alt="togo">
                    </div>

                </div>
            </div>
            <header class="blog-section">
                <h2 class="todos-blogs" data-translate="td_bl">Todos los blogs</h2>

                <div class="blog-filters">
                    <select>
                        <option value=""><span data-translate="sel">Seleccionar categoría</span></option>
                        <option value="negocios"><span data-translate="neg">Negocios</span></option>
                        <option value="tecnologia"><span data-translate="tec">Tecnología</span></option>
                        <option value="educacion"><span data-translate="edu">Educación</span></option>
                    </select>

                    <select>
                        <option value=""><span data-translate="ord">Ordenar por</span></option>
                        <option value="recientes"><span data-translate="ma_rec">Más recientes</span></option>
                        <option value="populares"><span data-translate="ma_pop">Más populares</span></option>
                    </select>
                </div>
            </header>
            <div class="content-cards" id="content-cards">
                @forelse ($blogs as $blog)
                    <a href="{{ $blog->url }}" class="cards" style="text-decoration:none; color:inherit;">
                        {{-- @if ($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x250?text=Sin+imagen" alt="Sin imagen">
                        @endif --}}
                        <div class="img">
                            <img src="https://images.unsplash.com/photo-1510511459019-5dda7724fd87" alt="Ciberseguridad">

                        </div>
                        <h4 class="categoria">{{-- Negocio / 03 de febrero de 2025 --}}{{ $blog->main_category ?? 'General' }} /
                            {{ $blog->created_at ? $blog->created_at->format('d \d\e F \d\e Y') : '' }}</h4>
                        <div class="title-cards">
                            <h3 class="titulo">{{ $blog->title }}</h3>

                        </div>

                        <p class="descripcion">
                            {{ $blog->short_description }}
                        </p>
                        @if ($blog->tags && $blog->tags->count())
                            <div class="tags">
                                <div class="tags-track">
                                    @foreach ($blog->tags as $tag)
                                        <span class="tag">{{ $tag->name }}</span>
                                    @endforeach
                                    @foreach ($blog->tags as $tag)
                                        <span class="tag">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{-- 
                        <div class="tags">
                            <div class="tags-track">
                                @for ($j = 0; $j < 9; $j++)
                                    <span class="tag"><span data-translate="ciberseguridad">Ciberseguridad</span></span>
                                @endfor
                                @for ($j = 0; $j < 9; $j++)
                                    <span class="tag"><span data-translate="ciberseguridad">Ciberseguridad</span></span>
                                @endfor

                            </div>
                        </div> --}}
                    </a>
                @empty
                    <p data-translate="no_blog">No hay blogs disponibles.</p>
                @endforelse
            </div>
        </div>
    </section>


    {{-- <script src="{{ asset('js/blog.js') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollContainer = document.getElementById('tagsScroll');
            const track = scrollContainer.querySelector('.tags-track');

            // duplicamos contenido para efecto infinito
            track.innerHTML += track.innerHTML;

            let scrollSpeed = 0.5; // velocidad del auto-scroll
            let isUserInteracting = false;

            function autoScroll() {
                if (!isUserInteracting) {
                    scrollContainer.scrollLeft += scrollSpeed;
                    // cuando llega al final, vuelve al inicio
                    if (scrollContainer.scrollLeft >= track.scrollWidth / 2) {
                        scrollContainer.scrollLeft = 0;
                    }
                }
                requestAnimationFrame(autoScroll);
            }

            // detectar interacción del usuario
            scrollContainer.addEventListener('mousedown', () => isUserInteracting = true);
            scrollContainer.addEventListener('mouseup', () => isUserInteracting = false);
            scrollContainer.addEventListener('touchstart', () => isUserInteracting = true);
            scrollContainer.addEventListener('touchend', () => isUserInteracting = false);

            autoScroll();
        });
    </script>
@endsection
