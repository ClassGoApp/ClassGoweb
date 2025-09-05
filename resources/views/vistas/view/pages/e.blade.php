<!DOCTYPE html>
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
</html>
