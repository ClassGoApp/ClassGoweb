<div class="hero-container">
    <!-- 1.1 Hero Titular -->
    <div class="hero-text fade-left">
        
        <h1 class="hero-title-arriba" data-translate="learn"></h1>
        <h1 class="hero-title-abajo" data-translate="tutoring"></h1>
        <p class="hero-subtext" data-translate="reach_goals">
        </p>

        <div class="buscador-home">
            @livewire('buscador-tutor')
        </div>

        <!-- 1.3 Botones-->
        <div class="hero-buttons">
            @guest
            <a href=" {{ route('buscar')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i><span data-translate="tutores"></span></button></a>
            <a href=" {{ route(name: 'register')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-user"></i><span data-translate="registrate"></span></button></a>
            <a href=" {{ route(name: 'login')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-right-to-bracket"></i><span data-translate="ingresa"></span></button></a>
            @endguest

            @auth
            <a href=" {{ route('buscar')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i> <span data-translate="buscar_tutor"></span> </button></a>
            <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><button class="button-explorar-tutores"><i class="fa-solid fa-mobile"></i> <span data-translate="nuestra_app"></span> </button></a>
            @endauth
        </div>
    </div>

    <!-- 1.4 Hero Mascota -->

    <img class = "hero-image" src="{{ asset(path: 'storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.webp') }}" alt="Mascota ClassGo">



</div>