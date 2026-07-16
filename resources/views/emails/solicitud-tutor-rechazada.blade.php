<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Solicitud de Tutoría Cancelada - {{ $subjectName }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #CDD6DA; padding: 20px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #ef4444; padding: 28px 24px; text-align: left;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <div style="color: #ffffff; font-size: 22px; font-weight: bold;">
                                            Hola, {{ $recipientName }}
                                        </div>
                                        <div style="color: #fee2e2; font-size: 14px; margin-top: 4px;">
                                            La solicitud de tutoría ha sido rechazada
                                        </div>
                                    </td>
                                    <td align="right" style="font-size: 38px;">❌</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding: 32px 32px 24px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.7; margin: 0 0 20px;">
                                Te informamos que <strong style="color: #023047;">{{ $senderName }}</strong> ha rechazado/cancelado la propuesta de horario para la materia de <strong style="color: #023047;">{{ $subjectName }}</strong>.
                            </p>
                            
                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 28px;">
                                Debido a esto, la negociación ha sido cerrada y los enlaces anteriores han quedado invalidados. Puedes realizar una nueva solicitud de horario desde la plataforma cuando lo desees.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 32px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af; text-align: center;">
                                Este correo fue enviado automáticamente por <strong>ClassGo</strong>.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
