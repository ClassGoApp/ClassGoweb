<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-favicon />
    </head>
    
    @livewireStyles


<body class="@yield('body-class')">

    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif

        {{-- Solo mostrar floating button si NO estamos en la vista del tutor --}}
    </main>


    
        @livewireScripts
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

        <script src="{{ asset('js/translations.js') }}"></script>

</body>
</html>