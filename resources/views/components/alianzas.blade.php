
<section class="client-testimonials-section">
    <div class="section-header">
        <span class="section-tagline"></span>
        <h1 class="over-text"><div class="linea"></div><span data-translate="alianzas"></span><div class="linea"></div></h1>

        <h1 class="section-title"><span data-translate="alianzas_edu"></span></h1>
        <p class="section-description">
            <span data-translate="alianzas_Classgo"></span>
        </p>
    </div>

    <div class="client-carousel-wrapper">
        <div id="client-carousel-container" class="client-carousel-container">
            <div id="client-carousel-track" class="client-carousel-track">

                @foreach($alianzas as $alianza)
                    <div class="client-card-slide" onclick="window.location.href='{{ $alianza->enlace }}' ">
                        <div class="client-card">
                            <img src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" alt="Imagen de {{ $alianza->titulo }}" class="client-logo">

                            <h3 class="client-name">{{ $alianza->titulo }}</h3>
                            {{-- <p class="client-description">Plataforma de Investigación y Formación Especializada</p> --}}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <button id="client-prev-button" class="client-carousel-nav-btn prev">
            <svg xmlns="http://www.w3.org/2000/svg" class="client-carousel-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button id="client-next-button" class="client-carousel-nav-btn next">
            <svg xmlns="http://www.w3.org/2000/svg" class="client-carousel-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>

    <div id="client-pagination-dots" class="client-pagination-dots-container">
        <button class="pagination-dot active"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
    </div>
</section>



