<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Búsqueda sin Resultados</title>
    <!-- Tailwind CSS para un diseño rápido y moderno -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Usando una fuente amigable como Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Encabezado con el degradado de la imagen -->
    <header class="bg-gradient-to-r from-teal-500 to-cyan-500 p-8 shadow-md">
        <div class="max-w-3xl mx-auto">
            <!-- Simulación de la barra de búsqueda -->
            <div class="bg-white rounded-full shadow-lg flex items-center p-2">
                <input 
                    type="text" 
                    placeholder="Busca un tutor o materia..." 
                    class="w-full bg-transparent text-gray-700 text-lg focus:outline-none px-4"
                    value="carlos enrique">
                <button class="text-gray-400 hover:text-teal-500 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="py-12">
        <div class="max-w-3xl mx-auto px-4">
            <!-- Componente "Sin Resultados" -->
            <div id="no-results" class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                
                <!-- Icono amigable -->
                <div class="mx-auto bg-yellow-100 rounded-full h-20 w-20 flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>

                <!-- Texto del Mensaje -->
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                    ¡Vaya! No encontramos resultados.
                </h2>
                <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                    Pero no te preocupes, ¡estamos aquí para ayudarte! Es posible que el tutor o la materia que buscas no esté disponible, o que haya un error de escritura.
                </p>

                <!-- Sugerencias -->
                <div class="text-left bg-gray-50 border border-gray-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">¿Qué puedes hacer?</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-teal-500 mr-3 mt-1">✓</span>
                            <strong>Revisa si escribiste bien</strong> el nombre.
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-500 mr-3 mt-1">✓</span>
                            Prueba con <strong>términos de búsqueda más generales</strong>.
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-500 mr-3 mt-1">✓</span>
                            <strong>¡Ponte en contacto con nosotros!</strong> Dinos qué necesitas.
                        </li>
                    </ul>
                </div>

                <!-- Botón de Llamada a la Acción -->
                <a href="#" class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform transform hover:scale-105 shadow-lg">
                    Contáctanos
                </a>
            </div>
        </div>
    </main>
</body>
</html>
