<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva Contrapropuesta de Tutoría - {{ $subjectName }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #CDD6DA; padding: 20px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #FB8500; padding: 28px 24px; text-align: left;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <div style="color: #ffffff; font-size: 22px; font-weight: bold;">
                                            Hola, {{ $recipientName }}
                                        </div>
                                        <div style="color: #ffebd5; font-size: 14px; margin-top: 4px;">
                                            Tienes una nueva contrapropuesta de horario
                                        </div>
                                    </td>
                                    <td align="right" style="font-size: 38px;">🔄</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding: 32px 32px 24px;">
                            <p style="color: #374151; font-size: 16px; line-height: 1.7; margin: 0 0 20px;">
                                <strong style="color: #023047;">{{ $senderName }}</strong> ha enviado una contrapropuesta de horario para la clase de <strong style="color: #023047;">{{ $subjectName }}</strong>.
                            </p>

                            <!-- Info box: Nueva Propuesta -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color: #fff7ed; border-left: 4px solid #FB8500; border-radius: 6px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0 0 10px; font-size: 13px; color: #c2410c; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">
                                            Nuevo Horario Propuesto
                                        </p>
                                        <p style="margin: 0 0 8px; font-size: 15px; color: #111827;">
                                            📅 <strong>Fecha:</strong> {{ $counterDate }}
                                        </p>
                                        <p style="margin: 0 0 8px; font-size: 15px; color: #111827;">
                                            🕐 <strong>Hora de Inicio:</strong> {{ $counterTime }}
                                        </p>
                                        <p style="margin: 0; font-size: 15px; color: #111827;">
                                            ⏳ <strong>Duración:</strong> {{ $counterDuration }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            @if(!empty($note))
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color: #f8fafc; border-left: 4px solid #cbd5e1; border-radius: 6px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 14px 20px;">
                                        <p style="margin: 0 0 6px; font-size: 13px; color: #475569; font-weight: 600; text-transform: uppercase;">
                                            💬 Comentario
                                        </p>
                                        <p style="margin: 0; font-size: 14px; color: #334155; font-style: italic; line-height: 1.5;">
                                            "{{ $note }}"
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 28px;">
                                Por favor, revisa esta contrapropuesta. Puedes aceptarla, rechazarla o enviar otra contraoferta de regreso.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $actionUrl }}"
                                            style="display: inline-block; background-color: #FB8500; color: #ffffff; text-decoration: none;
                                                   font-size: 15px; font-weight: bold; padding: 14px 36px; border-radius: 8px;
                                                   letter-spacing: 0.03em;">
                                            Ver Contrapropuesta →
                                        </a>
                                    </td>
                                </tr>
                            </table>
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
