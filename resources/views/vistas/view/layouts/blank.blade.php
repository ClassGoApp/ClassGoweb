<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    @php $siteTitle = setting('_general.site_name'); @endphp
    <title>{{ $siteTitle }}{!! !empty($title) ? ' | ' . $title : '' !!}</title>

    <x-favicon />

    {{-- iconos (si los usas en botones/cards) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- fuentes (opcional, si no te importa el fallback, bórralo) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:wght@100..900&display=swap"
        rel="stylesheet">

    @livewireStyles
</head>

<body class="@yield('body-class')">
    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>
   


    @livewireScripts
</body>

</html>
