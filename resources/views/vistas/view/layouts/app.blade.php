<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
            $siteTitle        = setting('_general.site_name');
    @endphp 
    <title>{{ $siteTitle }} {!! request()->is('messenger') ? ' | Messages' : (!empty($title) ? ' | ' . $title : '') !!}</title>
    <x-favicon />
    <link rel="stylesheet" href="{{ asset('css/estilos/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/nosotros.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/trabajamos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/preguntas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/buscartutor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/tutor-perfil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/terminos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/error404.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/floating-button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/promociones.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/estilos/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/blogshow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos/modal-reserva.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"></head>
    
    @livewireStyles


<body class="@yield('body-class')">
    @include('vistas.view.partials.navbar')
    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif

        {{-- Solo mostrar floating button si NO estamos en la vista del tutor --}}
        @unless(request()->routeIs('tutor') || request()->is('tutores/*'))
            @include('components.floating-button.index')
        @endunless

    </main>

        @include('vistas.view.partials.footer')
    
        @livewireScripts
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

        <script src="{{ asset('js/translations.js') }}"></script>

</body>
</html>