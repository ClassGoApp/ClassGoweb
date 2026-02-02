<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tutoría al instante</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #219EBC;
      padding: 20px;
      text-align: center;
    }

    .email-container {
      background: #219EBC;
      display: block;
      max-width: 550px;
      margin: 30px auto;
      text-align: center;
      padding: 25px;
      border-radius: 25px;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
      border: 2px solid #219EBC;
    }

    /* =================== COMPONENTE 1: IMAGEN =================== */
    .image-section {
      text-align: center;
      /* margin-bottom: 30px; */
      animation: slideDown 0.6s ease-out;
      
    }

    .image-section img {
      width: 320px;
      max-width: 100%;
      height: auto;
      display: inline-block;
      background: transparent;
    }

    

    /* =================== COMPONENTE 2: CONTENIDO =================== */
    .content-section {
      background: #023047;
      color: #fff;
      padding: 30px 25px;
      border-radius: 18px;
      display: block;
      margin: 0 auto 25px;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: slideUp 0.6s ease-out 0.1s both;
      max-width: 100%;
      border: 2px solid #219EBC;
    }

    .content-section:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
    }

    .content-title {
      font-size: 22px;
      font-weight: 700;
      margin: 0 0 14px 0;
      line-height: 1.3;
      letter-spacing: 0.5px;
    }

    .content-description {
      font-size: 15px;
      line-height: 1.6;
      margin: 0;
      opacity: 0.95;
      font-weight: 500;
    }

    /* =================== COMPONENTE 3: BOTÓN =================== */
    .button-section {
      text-align: center;
      animation: slideUp 0.6s ease-out 0.2s both;
    }

    .btn-action {
      background: #FB8500;
      color: #fff !important;
      padding: 16px 40px;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 700;
      text-decoration: none !important;
      display: inline-block;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(251, 133, 0, 0.4);
      border: 2px solid rgba(255, 255, 255, 0.2);
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 0.8px;
    }

    .btn-action:hover {
      background: #f07a00;
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(251, 133, 0, 0.4);
    }

    .btn-action:active {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(251, 133, 0, 0.3);
    }

    /* =================== ANIMACIONES =================== */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* =================== RESPONSIVE DESIGN =================== */
    /* Tablets (768px) */
    @media (max-width: 768px) {
      .email-container {
        margin: 20px auto;
        max-width: 500px;
        padding: 20px;
      }

      .image-section {
        margin-bottom: 20px;
        /* padding: 18px; */
      }

      .image-section img {
        width: 250px;
      }

      .content-section {
        padding: 25px 20px;
        border-radius: 12px;
        margin: 0 auto 20px;
      }

      .content-title {
        font-size: 20px;
        margin-bottom: 12px;
      }

      .content-description {
        font-size: 14px;
      }

      .btn-action {
        padding: 14px 35px;
        font-size: 15px;
        border-radius: 8px;
      }
    }

    /* Celulares (480px - iPhone SE, Android pequeños) */
    @media (max-width: 480px) {
      body {
        padding: 12px;
      }

      .email-container {
        margin: 15px auto;
        max-width: 95%;
        padding: 18px;
      }

      .image-section {
        margin-bottom: 15px;
        /* padding: 15px; */
      }

      .image-section img {
        width: 180px;
      }

      .content-section {
        padding: 20px 18px;
        border-radius: 10px;
        margin: 0 auto 15px;
      }

      .content-title {
        font-size: 18px;
        margin-bottom: 10px;
      }

      .content-description {
        font-size: 13px;
        line-height: 1.5;
      }

      .btn-action {
        padding: 13px 30px;
        font-size: 14px;
        letter-spacing: 0.5px;
      }
    }

    /* Ultra móviles (320px - iPhone antiguo) */
    @media (max-width: 360px) {
      .email-container {
        padding: 15px;
      }

      .image-section img {
        width: 140px;
      }

      .image-section {
        /* padding: 12px; */
      }

      .content-section {
        padding: 18px 15px;
        margin: 0 auto 12px;
      }

      .content-title {
        font-size: 16px;
        margin-bottom: 8px;
      }

      .content-description {
        font-size: 12px;
      }

      .btn-action {
        padding: 12px 25px;
        font-size: 13px;
      }
    }

    /* Pantallas grandes (1024px+) */
    @media (min-width: 1024px) {
      .email-container {
        margin: 40px auto;
        max-width: 600px;
        padding: 30px;
      }

      .image-section {
        margin-bottom: 30px;
        /* padding: 25px; */
      }

      .image-section img {
        width: 380px;
      }

      .content-section {
        padding: 35px 30px;
        margin: 0 auto 30px;
      }

      .content-title {
        font-size: 26px;
        margin-bottom: 16px;
      }

      .content-description {
        font-size: 16px;
      }

      .btn-action {
        padding: 18px 50px;
        font-size: 17px;
      }
    }
  </style>
</head>

<body>
  <div class="email-container">

    {{-- 1) COMPONENTE: Imagen/GIF --}}
    <div class="image-section">
      <img
        src="https://www.classgoapp.com/storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif"
        alt="Animated Celebration"
      />
    </div>

    {{-- 2) COMPONENTE: Contenido (Título + Descripción) --}}
    <div class="content-section">
      <p class="content-title">
        {{ $title ?? 'Fuiste solicitado para una tutoría al instante' }}
      </p>
      <p class="content-description">
        {{ $description ?? 'Un estudiante está buscando tutor y tu perfil coincide con sus necesidades.' }}
      </p>
    </div>

    {{-- 3) COMPONENTE: Botón de Acción --}}
    <div class="button-section">
      <a
        href="{{ $buttonUrl }}"
        class="btn-action"
        target="_blank"
        rel="noopener noreferrer"
      >
        {{ $buttonText ?? 'Ir a lista de espera' }}
      </a>
    </div>

  </div>
</body>
</html>
