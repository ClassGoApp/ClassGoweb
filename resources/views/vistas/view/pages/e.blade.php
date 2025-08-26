<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards de Tutores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 30px;
            background: #f5f5f5;
            flex-wrap: wrap;
            /* Para que en móvil se apilen */
        }

        .tutor-card {
            position: relative;
            width: 300px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            background: #fff;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .tutor-card:hover {
            transform: translateY(-5px);
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.4);
            /* semi-transparente */
            border: none;
            font-size: 20px;
            cursor: pointer;
            z-index: 5;
            width: 35px;
            /* un poco más grande para mejor visual */
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1;
            /* evita que el texto se desplace verticalmente */
            padding: 0;
            /* elimina padding interno que puede descentrar */
            transition: background 0.3s;
        }

        .favorite-btn.active {
            background: #FB8500;
            /* naranja cuando está activado */
            color: white;
        }

        .fa-book {
            margin-right: 5px;
        }

        .tutor-card-img video {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }

        .tutor-card-content {
            padding: 15px;
        }

        .tutor-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tutor-card-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .tutor-card-sub {
            font-size: 14px;
            margin: 8px 0;
            color: #555;
        }

        .tutor-card-rating-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>

    <!-- Card izquierda: Video con controles, card clickeable excepto video -->
    <div class="tutor-card" onclick="window.location.href='https://example.com/perfil-tutor1'">
        <button class="favorite-btn" onclick="event.stopPropagation(); this.classList.toggle('active')">⭐</button>

        <div class="tutor-card-img">
            <video controls preload="auto"
                poster="https://via.placeholder.com/300x160"
                src="https://www.w3schools.com/html/mov_bbb.mp4"
                onclick="event.stopPropagation()"></video>
        </div>

        <div class="tutor-card-content">
            <div class="tutor-card-header">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Tutor">
                <h3>Carlos Ramírez</h3>
            </div>
            <p class="tutor-card-sub">Puedo enseñar: Historia, Literatura, Filosofía</p>
            <div class="tutor-card-rating-row">
                <div><span class="star">⭐</span>4.9 <span>(90 reseñas)</span></div>
                <div><i class="fa-solid fa-book"></i><strong>20</strong> tutorías</div>
            </div>
        </div>
    </div>


    <!-- Card derecha: Video en loop muteado, toda la card clickeable -->
    <div class="tutor-card" onclick="window.location.href='https://example.com/perfil-tutor2'">
        <button class="favorite-btn" onclick="event.stopPropagation(); this.classList.toggle('active')">⭐</button>
        <div class="tutor-card-img">
            <video autoplay loop muted playsinline preload="auto"
                poster="https://via.placeholder.com/300x160"
                src="https://www.w3schools.com/html/movie.mp4"></video>
        </div>
        <div class="tutor-card-content">
            <div class="tutor-card-header">
                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Tutor">
                <h3>María López</h3>
            </div>
            <p class="tutor-card-sub">Puedo enseñar: Matemáticas, Física, Química</p>
            <div class="tutor-card-rating-row">
                <div><span class="star">⭐</span>4.7 <span>(150 reseñas)</span></div>
                <div><i class="fa-solid fa-book"></i><strong>30</strong> tutorías</div>
            </div>
        </div>
    </div>

</body>

</html>