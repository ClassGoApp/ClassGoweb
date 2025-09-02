<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta de Video Interactiva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos adicionales para la fuente y la tarjeta */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        .card-container {
            max-width: 360px;
            margin: 4rem auto;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-radius: 1rem;
            overflow: visible;
            position: relative;
            background-color: white;
        }
        .video-wrapper {
            position: relative;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            overflow: hidden;
        }
        /* Controles personalizados */
        .custom-controls {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }
        #playPauseBtn {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid white;
            transition: opacity 0.3s ease, transform 0.2s ease;
        }
        #playPauseBtn:hover {
            transform: scale(1.1);
        }
        /* Ocultar el botón de play cuando el video se está reproduciendo */
        .video-wrapper.playing #playPauseBtn {
            opacity: 0;
            pointer-events: none;
        }
        /* Contenedor del volumen */
        .volume-container {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            display: flex;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        /* Mostrar control de volumen al pasar el mouse sobre el video */
        .video-wrapper:hover .volume-container {
            opacity: 1;
        }
        #volumeSlider {
            width: 80px;
            cursor: pointer;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="card-container">
        <!-- Contenedor del video -->
        <div id="videoContainer" class="video-wrapper">
            <video id="miVideo" class="w-full" poster="https://placehold.co/600x400/cccccc/ffffff?text=Video">
                <!-- Reemplaza este video con el tuyo -->
                <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                Tu navegador no soporta la etiqueta de video.
            </video>

            <!-- Controles personalizados -->
            <div class="custom-controls">
                <button id="playPauseBtn">
                    <!-- Icono de Play (SVG) -->
                    <svg id="playIcon" class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.018 15.132A1.25 1.25 0 006 14.253V5.747a1.25 1.25 0 00-1.982-.979l-1.03.515a1.25 1.25 0 000 1.958l1.03.515zM6.25 5.11l8.32 4.16a1.25 1.25 0 010 2.22l-8.32 4.16A1.25 1.25 0 014 14.75V5.25a1.25 1.25 0 012.25-.86z"></path>
                    </svg>
                    <!-- Icono de Pausa (SVG) - Oculto por defecto -->
                    <svg id="pauseIcon" class="w-8 h-8 text-white hidden" fill="currentColor" viewBox="0 0 20 20">
                         <path d="M5.75 4.5a.75.75 0 00-.75.75v9.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V5.25a.75.75 0 00-.75-.75H5.75zm7.5 0a.75.75 0 00-.75.75v9.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V5.25a.75.75 0 00-.75-.75h-1.5z"></path>
                    </svg>
                </button>
            </div>
            <div class="volume-container">
                 <!-- Icono de Volumen (SVG) -->
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                   <path d="M9.25 4.75a.75.75 0 00-1.5 0v10.5a.75.75 0 001.5 0V4.75zM6.25 6.75a.75.75 0 00-1.5 0v6.5a.75.75 0 001.5 0V6.75zM12.25 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0V2.75zm3 4a.75.75 0 00-1.5 0v6.5a.75.75 0 001.5 0V6.75z"></path>
                </svg>
                <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="1">
            </div>
        </div>

        <!-- Imagen de perfil -->
        <div id="contenedorImagen" class="absolute w-full flex justify-center transition-opacity duration-300" style="top: 195px;">
             <img id="miImagen" src="http://googleusercontent.com/file_content/0" alt="Imagen de contacto" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg" style="transform: translateY(-50%);">
        </div>

        <!-- Contenido de texto -->
        <div class="p-6 pt-12 text-center">
            <h2 class="text-xl font-bold text-gray-800">Gabriel Alpiry Hurtado</h2>
            <p class="text-gray-600 mt-2">
                Puedo enseñar: Básico, Ciencias Naturales para Primaria, Mecánica Aplicada, Física de Materiales, Modelos de Regresión...
            </p>
        </div>
    </div>

    <script>
        // Obtener los elementos del DOM
        const videoContainer = document.getElementById('videoContainer');
        const video = document.getElementById('miVideo');
        const imagen = document.getElementById('contenedorImagen');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const volumeSlider = document.getElementById('volumeSlider');

        // Función para alternar entre play y pause
        function togglePlay() {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }

        // Event listeners para el botón y el video
        playPauseBtn.addEventListener('click', togglePlay);
        video.addEventListener('click', togglePlay);

        // Actualizar UI cuando el video se reproduce
        video.addEventListener('play', () => {
            videoContainer.classList.add('playing');
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            imagen.style.opacity = '0';
        });

        // Actualizar UI cuando el video se pausa
        video.addEventListener('pause', () => {
            videoContainer.classList.remove('playing');
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            imagen.style.opacity = '1';
        });
        
        // Actualizar UI cuando el video termina
        video.addEventListener('ended', () => {
            videoContainer.classList.remove('playing');
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            imagen.style.opacity = '1';
        });

        // Control de volumen
        volumeSlider.addEventListener('input', (e) => {
            video.volume = e.target.value;
        });
    </script>

</body>
</html>
