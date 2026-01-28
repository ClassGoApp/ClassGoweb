<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tutoría al instante</title>
</head>

<body style="margin:0;padding:0;font-family:Arial,sans-serif;background-color:#023047;">
  <div style="display:flex;flex-direction:column;min-height:100vh;padding:20px;box-sizing:border-box;">

    {{-- 1) GIF/imagen --}}
    <div style="margin-bottom:20px;">
      <img
        src="{{ $gifUrl }}"
        alt="ClassGo"
        style="width:200px;max-width:100%;height:auto;display:block;margin:0 auto;"
      />
    </div>

    {{-- 2) Bloque de texto --}}
    <div style="background-color:#219EBC;color:#fff;padding:20px;border-radius:10px;text-align:center;margin-bottom:20px;max-width:600px;box-sizing:border-box;">
      <p style="font-size:20px;font-weight:bold;margin:0 0 12px 0;">
        {{ $title ?? 'Fuiste solicitado para una tutoría al instante' }}
      </p>
      <p style="font-size:14px;margin:0;">
        {{ $description ?? 'Un estudiante está buscando tutor y tu perfil coincide con sus necesidades.' }}
      </p>
    </div>

    {{-- 3) Botón (link) --}}
    <div style="text-align:center;">
      <a
        href="{{ $buttonUrl }}"
        style="background-color:#FB8500;color:#fff;padding:15px 30px;border-radius:8px;font-size:16px;font-weight:bold;text-decoration:none;display:inline-block;"
        target="_blank"
        rel="noopener"
      >
        {{ $buttonText ?? 'Ir a lista de espera' }}
      </a>
    </div>

  </div>
</body>
</html>
