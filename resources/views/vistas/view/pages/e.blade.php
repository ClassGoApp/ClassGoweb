{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Tutor | ClassGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Usamos una fuente más profesional y moderna */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #00838F; /* Tono de verde azulado del diseño original */
        }
        /* Estilos personalizados para el banner de la conferencia */
        .conference-banner {
            background-color: #E0F7FA; /* Un celeste muy claro para destacar sutilmente */
            border: 1px solid #4DD0E1; /* Borde en un tono cian brillante */
            color: #006064; /* Texto en un tono oscuro del color principal */
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .conference-banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.1);
        }
        .cta-button {
            background-color: #0097A7; /* Un tono cian más brillante para el botón */
            color: white;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #00ACC1; /* Un poco más claro al pasar el mouse */
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumbs / Navegación -->
        <nav class="text-white text-sm mb-4">
            <a href="#" class="hover:underline">Tutores</a> / 
            <a href="#" class="hover:underline">Encontrar tutor</a> / 
            <span class="font-semibold">Gabriel Alpiry Hurtado</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna principal del perfil -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tarjeta de Perfil Principal -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://placehold.co/800x200/0097A7/FFFFFF?text=ClassGo!')">
                        <!-- Imagen de banner del tutor -->
                    </div>
                    <div class="p-6">
                        <div class="flex items-start -mt-20">
                            <img class="h-24 w-24 rounded-full border-4 border-white" src="https://placehold.co/100x100/FFFFFF/00838F?text=G" alt="Foto de Gabriel Alpiry Hurtado">
                            <div class="ml-4 pt-12">
                                <h1 class="text-2xl font-bold text-gray-800">Gabriel Alpiry Hurtado</h1>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <span class="text-yellow-400">⭐</span>
                                    <span class="ml-1">0.0 (0 reseñas)</span>
                                    <span class="mx-2">|</span>
                                    <span>juan.perez@example.com</span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-600">Experienced tutor specializing in Mathematics and Physics.</p>
                    </div>
                </div>

                <!-- ========== INICIO: Banner de Conferencia Gratuita ========== -->
                <!-- Este es el nuevo bloque que puedes agregar dinámicamente -->
                <!-- cuando un tutor tenga una conferencia. -->
                <div class="conference-banner rounded-xl p-6 text-center">
                    <h3 class="text-xl font-bold mb-2">📣 ¡Próxima Conferencia Gratuita!</h3>
                    <h4 class="text-2xl font-semibold text-cyan-800 mb-4">Matemáticas para el Examen de Admisión</h4>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-x-6 gap-y-2 text-md mb-6">
                        <span>🗓️ <strong>Fecha:</strong> 25 de Septiembre, 2025</span>
                        <span>⏰ <strong>Hora:</strong> 18:00 (BOT)</span>
                    </div>
                    <a href="#" class="cta-button font-bold py-3 px-8 rounded-lg inline-block">
                        ¡Inscríbete aquí, es gratis!
                    </a>
                </div>
                <!-- ========== FIN: Banner de Conferencia Gratuita ========== -->


                <!-- Pestañas de Información Detallada -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-6">
                            <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-cyan-600 border-cyan-500">
                                Tutoría
                            </a>
                            <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Disponibilidad
                            </a>
                            <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Aspectos Destacados
                            </a>
                            <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Reseñas
                            </a>
                        </nav>
                    </div>
                    <div class="pt-6">
                        <h3 class="text-lg font-semibold text-gray-800">Puedo enseñar</h3>
                        <p class="mt-2 text-gray-600">Contenido de la pestaña tutoría...</p>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                       <p><span class="text-2xl font-bold">10</span> tutorías realizadas</p>
                    </div>
                     <div class="flex items-center text-green-600 mt-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="ml-2 font-semibold">Tutor verificado</span>
                    </div>
                    <button class="w-full mt-4 py-2 px-4 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50">
                        Compartir perfil
                    </button>
                    <button class="w-full mt-2 py-2 px-4 bg-cyan-700 text-white rounded-lg font-semibold hover:bg-cyan-800">
                        Buscar más Tutores
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuentra tu Tutor Ideal</title>
    <!-- Tailwind CSS para un diseño rápido y responsivo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts para una tipografía más atractiva -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        /* Estilos personalizados y definición de la paleta de colores */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #023047; /* Azul oscuro de fondo */
        }
        .text-custom-orange {
            color: #FB8500;
        }
        .bg-custom-orange {
            background-color: #FB8500;
        }
        .bg-custom-orange:hover {
            background-color: #e67800; /* Un tono más oscuro para el hover */
        }
        .text-custom-blue-light {
            color: #219EBC;
        }
        .border-custom-blue-light {
            border-color: #219EBC;
        }
        .tag {
            background-color: #219ebc20; /* Azul claro con opacidad */
            color: #219EBC;
        }
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="antialiased text-white">
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-6xl mx-auto">
            <!-- Encabezado de la sección -->
            <div class="text-center mb-12">
                <span class="text-custom-blue-light font-semibold uppercase tracking-wider text-sm">Tutores Destacados</span>
                <h1 class="text-4xl md:text-5xl font-extrabold mt-2">Encuentra tu Tutor Ideal</h1>
                <p class="text-slate-300 mt-4 max-w-2xl mx-auto">
                    Descubre una variedad de temáticas académicas y prácticas para potenciar tu experiencia de aprendizaje.
                </p>
            </div>

            <!-- Contenedor principal con flechas de navegación -->
            <div class="relative">
                <!-- Flecha Izquierda -->
                <button class="absolute top-1/2 -left-4 md:-left-6 lg:-left-12 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full p-3 transition-all z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Grid para las tarjetas de tutores -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Tarjeta de Tutor 1 -->
                    <div class="bg-[#073b57] rounded-2xl p-6 flex flex-col text-center items-center card-shadow transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="relative">
                            <img src="https://placehold.co/100x100/FB8500/023047?text=GA" alt="Avatar de Gabriel Alpiry Hurtado" class="w-24 h-24 rounded-full border-4 border-custom-blue-light object-cover">
                            <span class="absolute -top-1 -right-1 flex h-6 w-6">
                                <span class="relative inline-flex rounded-full h-6 w-6 bg-custom-orange items-center justify-center">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <h3 class="font-bold text-xl mt-4">Gabriel Alpiry Hurtado</h3>
                        <p class="text-slate-300 text-sm mt-1">Tutor de Ciencias Sociales</p>
                        <div class="mt-4 flex flex-wrap gap-2 justify-center">
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Estudios Sociales</span>
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Historia</span>
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Geografía</span>
                        </div>
                        <button class="bg-custom-orange text-white font-bold py-2 px-6 rounded-lg mt-6 w-full transition-colors">
                            Ver Perfil
                        </button>
                    </div>

                    <!-- Tarjeta de Tutor 2 -->
                    <div class="bg-[#073b57] rounded-2xl p-6 flex flex-col text-center items-center card-shadow transform hover:-translate-y-2 transition-transform duration-300">
                         <div class="relative">
                            <img src="https://placehold.co/100x100/219EBC/FFFFFF?text=JR" alt="Avatar de Johana Rocha Rodriguez" class="w-24 h-24 rounded-full border-4 border-custom-blue-light object-cover">
                            <span class="absolute -top-1 -right-1 flex h-6 w-6">
                                <span class="relative inline-flex rounded-full h-6 w-6 bg-custom-orange items-center justify-center">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <h3 class="font-bold text-xl mt-4">Johana Rocha Rodriguez</h3>
                        <p class="text-slate-300 text-sm mt-1">Especialista en Psicología</p>
                        <div class="mt-4 flex flex-wrap gap-2 justify-center">
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Psicología</span>
                             <span class="tag font-medium py-1 px-3 rounded-full text-xs">Desarrollo Personal</span>
                        </div>
                        <button class="bg-custom-orange text-white font-bold py-2 px-6 rounded-lg mt-6 w-full transition-colors">
                            Ver Perfil
                        </button>
                    </div>

                    <!-- Tarjeta de Tutor 3 -->
                    <div class="bg-[#073b57] rounded-2xl p-6 flex flex-col text-center items-center card-shadow transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="relative">
                            <img src="https://placehold.co/100x100/FFFFFF/023047?text=AR" alt="Avatar de Alvaro rojas machuca" class="w-24 h-24 rounded-full border-4 border-custom-blue-light object-cover">
                            <span class="absolute -top-1 -right-1 flex h-6 w-6">
                                <span class="relative inline-flex rounded-full h-6 w-6 bg-custom-orange items-center justify-center">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <h3 class="font-bold text-xl mt-4">Alvaro rojas machuca</h3>
                        <p class="text-slate-300 text-sm mt-1">Experto en Ciencias Exactas</p>
                        <div class="mt-4 flex flex-wrap gap-2 justify-center">
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Matemáticas</span>
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Lenguaje</span>
                            <span class="tag font-medium py-1 px-3 rounded-full text-xs">Literatura</span>
                        </div>
                        <button class="bg-custom-orange text-white font-bold py-2 px-6 rounded-lg mt-6 w-full transition-colors">
                            Ver Perfil
                        </button>
                    </div>

                </div>

                <!-- Flecha Derecha -->
                <button class="absolute top-1/2 -right-4 md:-right-6 lg:-right-12 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full p-3 transition-all z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>

