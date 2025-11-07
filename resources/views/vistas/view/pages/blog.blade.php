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
                       
                        <livewire:blog-search />
                        <div class="logo-tugo-megafono">
                            <img src="{{ asset('images/home/blogs/Community-Management.png') }}" alt="togo">
                        </div>

                    </div>
                </div>

                <livewire:blogs-filter />
            </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Verificar que existan elementos con tags
            const tagsContainers = document.querySelectorAll('.tags');
            
            if (tagsContainers.length === 0) {
                console.log('No se encontraron contenedores de tags');
                return;
            }
            
            tagsContainers.forEach((scrollContainer, index) => {
                const track = scrollContainer.querySelector('.tags-track');
                
                if (!track) {
                    console.log(`No se encontró .tags-track en el contenedor ${index}`);
                    return;
                }
                
                // Verificar que hay contenido en el track
                if (track.children.length === 0) {
                    console.log(`El track ${index} está vacío`);
                    return;
                }
                
                // Duplicamos contenido para efecto infinito
                const originalContent = track.innerHTML;
                track.innerHTML += originalContent;

                let scrollSpeed = 0.5;
                let isUserInteracting = false;

                function autoScroll() {
                    if (!isUserInteracting && track.scrollWidth > scrollContainer.clientWidth) {
                        scrollContainer.scrollLeft += scrollSpeed;
                        
                        // Cuando llega al final, vuelve al inicio
                        if (scrollContainer.scrollLeft >= track.scrollWidth / 2) {
                            scrollContainer.scrollLeft = 0;
                        }
                    }
                    requestAnimationFrame(autoScroll);
                }

                // Detectar interacción del usuario
                scrollContainer.addEventListener('mousedown', () => isUserInteracting = true);
                scrollContainer.addEventListener('mouseup', () => isUserInteracting = false);
                scrollContainer.addEventListener('mouseleave', () => isUserInteracting = false);
                scrollContainer.addEventListener('touchstart', () => isUserInteracting = true);
                scrollContainer.addEventListener('touchend', () => isUserInteracting = false);

                autoScroll();
            });
        });
    </script>
    


@endsection
