<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards de Tutores</title>
    <style>
        :root {
            --primary-color: #1f2937;
            --secundary-color: #0ea5e9;
            --terciary-color2: #10b981;
            --white: #ffffff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        .carousel-container {
            overflow-x: auto;
            display: flex;
            gap: 1rem;
            scroll-behavior: smooth;
            padding-bottom: 1rem;
        }

        .tutor-card {
            width: 300px;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            position: relative;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
        }

        .tutor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.4);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
            z-index: 20;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            font-size: 1rem;
        }

        .favorite-btn.active {
            background: #FB8500;
            color: #fff;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
        }

        .tutor-card-img {
            position: relative;
            height: 160px;
            overflow: hidden;
        }

        .tutor-card-img video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .tutor-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .tutor-banner-play {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .tutor-banner-play svg {
            width: 25px;
            height: 25px;
            fill: #000;
            stroke: #000;
        }

        .tutor-video-controls {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 50px;
            z-index: 15;
            display: none;
        }

        .tutor-control-button {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
        }

        .tutor-control-button svg {
            width: 18px;
            height: 18px;
            fill: #fff;
            stroke: #fff;
        }

        .tutor-control-volume {
            width: 70px;
            margin-left: 10px;
        }

        .sound-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            cursor: pointer;
            z-index: 25;
        }

        .sound-btn:hover {
            background: #FB8500;
        }

        .tutor-card-content {
            padding: 0.8rem 1rem 1rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .tutor-card-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tutor-card-header img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .tutor-card-header h3 {
            font-size: 1.1rem;
            margin: 0;
            color: var(--primary-color);
        }

        .tutor-card-sub {
            font-size: 0.9rem;
            color: #334155;
            line-height: 1.4;
            max-height: 3.6em;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tutor-card-rating-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #1a3b4d;
        }

        .tutor-card-rating {
            display: flex;
            align-items: center;
            background: rgba(251, 191, 36, 0.1);
            color: #b45309;
            padding: 0.2rem 0.5rem;
            border-radius: 0.3rem;
            gap: 0.25rem;
        }

        .tutor-card-rating .star {
            color: #f59e42;
        }

        .tutor-nr-claces {
            font-size: 15px;
        }
    </style>
</head>

<body>

    <div class="carousel-container">
        <div class="tutor-card" data-url="https://example.com/perfil-tutor">
            <button class="favorite-btn">⭐</button>

            <div class="tutor-card-img">
                <video class="tutor-intro-video" muted playsinline preload="none" poster="https://via.placeholder.com/300x160" src="https://www.w3schools.com/html/mov_bbb.mp4"></video>
                <div class="tutor-banner-overlay">
                    <div class="tutor-banner-play">
                        <svg viewBox="0 0 24 24">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                    </div>
                </div>
                <div class="tutor-video-controls">
                    <button class="tutor-control-button">
                        <svg viewBox="0 0 24 24">
                            <rect x="6" y="4" width="4" height="16"></rect>
                            <rect x="14" y="4" width="4" height="16"></rect>
                        </svg>
                    </button>
                    <input type="range" min="0" max="1" step="0.01" value="0.5" class="tutor-control-volume">
                </div>
                <button class="sound-btn">🔊</button>
            </div>

            <div class="tutor-card-content">
                <div class="tutor-card-header">
                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Tutor">
                    <h3>Juan Pérez</h3>
                </div>
                <p class="tutor-card-sub">Puedo enseñar: Matemáticas, Física, Química, Biología</p>
                <div class="tutor-card-rating-row">
                    <div class="tutor-card-rating"><span class="star">⭐</span>4.8 <span>(120 reseñas)</span></div>
                    <div class="tutor-card-price"><i class="fa-solid fa-book"></i><strong class="tutor-nr-claces">10</strong> tutorías</div>
                </div>
                <div class="space-y-4">
                    <button id="copyButton" class="w-full bg-white/90 hover:bg-white text-[#0f3443] font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                        Copiar Código
                    </button>
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                        Compartir
                    </button>
                </div>
                 <p id="copyMessage" class="mt-4 h-5"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.tutor-card');

            cards.forEach(card => {
                const video = card.querySelector('.tutor-intro-video');
                const overlay = card.querySelector('.tutor-banner-overlay');
                const playButton = overlay.querySelector('.tutor-banner-play');
                const controls = card.querySelector('.tutor-video-controls');
                const pauseButton = controls.querySelector('.tutor-control-button');
                const volumeControl = controls.querySelector('.tutor-control-volume');
                const favBtn = card.querySelector('.favorite-btn');
                const soundBtn = card.querySelector('.sound-btn');

                card.addEventListener('click', (e) => {
                    if (!e.target.closest('.tutor-card-img') && !e.target.closest('.favorite-btn')) {
                        window.location.href = card.dataset.url;
                    }
                });

                overlay.addEventListener('click', (e) => {
                    e.stopPropagation();
                    video.play();
                });

                playButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    video.play();
                });

                pauseButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    video.pause();
                });

                volumeControl.addEventListener('input', () => {
                    video.volume = volumeControl.value;
                });

                video.addEventListener('play', () => {
                    overlay.style.display = 'none';
                    controls.style.display = 'flex';
                });

                video.addEventListener('pause', () => {
                    overlay.style.display = 'flex';
                    controls.style.display = 'none';
                });

                video.addEventListener('ended', () => {
                    overlay.style.display = 'flex';
                    controls.style.display = 'none';
                    video.currentTime = 0;
                });

                video.volume = volumeControl.value;

                favBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    favBtn.classList.toggle('active');
                });

                if (soundBtn) {
                    soundBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        video.muted = !video.muted;
                        soundBtn.textContent = video.muted ? "🔇" : "🔊";
                    });
                }
            });
        });
    </script>

</body>

</html>