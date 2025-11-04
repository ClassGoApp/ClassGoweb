@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')



    <section class="seccion-blog">
        <div class="contenido-blog">

            <div class="blog-header">
                <div class="blog-header-content">
                    <div class="information">
                        <h1>Ideas y consejos de expertos para estudiantes de por vida</h1>
                        <h2>Acceda a informacion valiosa,
                            consejos de expertos y sugerencias de nuestra activa comunidad de tutores.
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
            const scrollContainer = document.getElementById('tagsScroll');
            const track = scrollContainer.querySelector('.tags-track');
            track.innerHTML += track.innerHTML;

            let scrollSpeed = 0.5;
            let isUserInteracting = false;

            function autoScroll() {
                if (!isUserInteracting) {
                    scrollContainer.scrollLeft += scrollSpeed;
                    if (scrollContainer.scrollLeft >= track.scrollWidth / 2) {
                        scrollContainer.scrollLeft = 0;
                    }
                }
                requestAnimationFrame(autoScroll);
            }
            scrollContainer.addEventListener('mousedown', () => isUserInteracting = true);
            scrollContainer.addEventListener('mouseup', () => isUserInteracting = false);
            scrollContainer.addEventListener('touchstart', () => isUserInteracting = true);
            scrollContainer.addEventListener('touchend', () => isUserInteracting = false);

            autoScroll();
        });
    </script>
    


@endsection
