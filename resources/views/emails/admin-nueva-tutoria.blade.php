<!-- filepath: resources/views/emails/admin-nueva-tutoria.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva Tutoría Programada</title>
    <style>
        /* Estilos para admin-nueva-tutoria.blade.php - Mobile-first y responsive */

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .gif-container {
            margin-bottom: 20px;
        }

        .gif-container img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .gif-container img {
            width: 200px;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .text-block {
            background-color: #219EBC; /* Celeste */
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            max-width: 90%;
            box-sizing: border-box;
        }

        .button-container {
            text-align: center;
        }

        .btn-primary {
            background-color: #FB8500; /* Color del proyecto */
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        /* Media queries para pantallas grandes */
        @media (min-width: 768px) {
            .container {
                padding: 40px;
            }

            .text-block {
                max-width: 600px;
                padding: 30px;
            }

            .btn-primary {
                padding: 20px 40px;
                font-size: 18px;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #023047;">
    <div class="container">
        <!-- Primer componente: GIF centrado -->
        <div class="gif-container">
            <img src="http://127.0.0.1:8000/storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.webp" alt="GIF de bienvenida" />
        </div>

        <!-- Segundo componente: Bloque de texto -->
        <div class="text-block">
            <p style="font-size: 20px; font-weight: bold; margin: 0 0 12px 0;">Fuiste solicitado para una tutoría al instante</p>
            <p style="font-size: 14px; margin: 0;">Un estudiante está buscando tutor y tu perfil coincide con sus necesidades.</p>
        </div>

        <!-- Tercer componente: Botón -->
        <div class="button-container">
            <button class="btn-primary">
                Ir a lista de espera
                {{-- Ruta comentada: <a href="{{ route('ruta.a.la.clase') }}"> --}}
            </button>
        </div>
    </div>
</body>
</html>