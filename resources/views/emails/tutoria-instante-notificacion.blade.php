<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoría ClassGo</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, a { font-family: Arial, sans-serif !important; }
    </style>
    <![endif]-->
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7f9; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f9;">
        <tr>
            <td align="center" style="padding: 20px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 400px; background-color: #005c8a; border-radius: 30px; overflow: hidden; border-collapse: separate; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">

                    <!-- Hero -->
                    <tr>
                        <td align="center" style="padding: 25px 15px 10px 15px;">
                            <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif"
                                alt="Tutoría" width="140" style="display: block; border: 0; max-width: 100%;">
                        </td>
                    </tr>

                    <!-- Cuerpo Blanco -->
                    <tr>
                        <td style="padding: 0 10px 10px 10px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="background-color: #ffffff; border-radius: 20px; border-collapse: separate;">

                                <!-- Encabezado -->
                                <tr>
                                    <td align="center" style="padding: 15px 15px 5px 15px;">
                                        <div
                                            style="background-color: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 10px; font-size: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 10px;">
                                            ⚡ Tutoría Al Instante
                                        </div>
                                        <h1
                                            style="color: #0f172a; margin: 0; font-size: 20px; font-weight: 800; line-height: 1.2;">
                                            ¡Hola, {{ $tutorName }}!
                                        </h1>
                                    </td>
                                </tr>



                                <!-- Info Materia -->
                                <tr>
                                    <td style="padding: 10px 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            style="background-color: #26a3bd; border-radius: 15px;">
                                            <!-- Descripción -->
                                            <tr>
                                                <td align="center" style="padding: 5px 10px;">
                                                    <p
                                                        style="color: #ffffff; font-size: 30px; margin: 0; line-height: 1.4; font-weight: bold;">
                                                        Fuiste solicitado para una tutoría al instante
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding: 10px;">
                                                    <p
                                                        style="color: #ddf3ff; font-size: 15px; margin: 0 0 5px 0; font-weight: 600;">
                                                        Un estudiante esta buscando tutor para esta materia: {{ $subjectName }}
                                                    </p>
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Botón -->
                                <tr>
                                    <td align="center" style="padding: 15px 15px 30px 15px;">
                                        <a href="{{ $buttonUrl ?? '#' }}"
                                            style="background-color: #ff8c00; color: #ffffff; display: inline-block; font-size: 14px; font-weight: 800; padding: 14px 28px; text-decoration: none; border-radius: 12px; text-transform: uppercase;">
                                            {{ $buttonText }}
                                        </a>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
