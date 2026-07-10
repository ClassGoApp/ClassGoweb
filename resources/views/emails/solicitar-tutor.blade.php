<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Solicitud de Tutoría - {{ $subjectName }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #CDD6DA; padding: 20px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #219EBC; padding: 28px 24px; text-align: left;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <div style="color: #ffffff; font-size: 22px; font-weight: bold;">
                                            ¡Hola, {{ $tutorName }}!
                                        </div>
                                        <div style="color: #e0f4fb; font-size: 14px; margin-top: 4px;">
                                            Tienes una nueva solicitud de tutoría con fecha preferida
                                        </div>
                                    </td>
                                    <td align="right" style="font-size: 38px;">📬</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding: 32px 32px 24px;">

                            <p style="color: #374151; font-size: 16px; line-height: 1.7; margin: 0 0 20px;">
                                El estudiante <strong style="color: #023047;">{{ $studentName }}</strong>
                                está buscando un tutor para
                                <strong style="color: #023047;">{{ $subjectName }}</strong>
                                y ha indicado su disponibilidad preferida.
                            </p>

                            <!-- Info box: Detalles de la solicitud -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color: #f0f9ff; border-left: 4px solid #219EBC; border-radius: 6px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0 0 10px; font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">
                                            Detalles de la solicitud
                                        </p>
                                        <p style="margin: 0 0 8px; font-size: 15px; color: #111827;">
                                            📚 <strong>Materia:</strong> {{ $subjectName }}
                                        </p>
                                        <p style="margin: 0 0 8px; font-size: 15px; color: #111827;">
                                            📅 <strong>Fecha preferida:</strong> {{ $preferredDate }}
                                        </p>
                                        <p style="margin: 0 0 8px; font-size: 15px; color: #111827;">
                                            🕐 <strong>Horario preferido:</strong> {{ $preferredTime }}
                                        </p>
                                        <p style="margin: 0; font-size: 15px; color: #111827;">
                                            📝 <strong>Solicitado el:</strong> {{ $requestDate }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Nota adicional (solo si hay) -->
                            @if(!empty($note))
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color: #fefce8; border-left: 4px solid #facc15; border-radius: 6px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 14px 20px;">
                                        <p style="margin: 0 0 6px; font-size: 13px; color: #92400e; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
                                            💬 Nota del estudiante
                                        </p>
                                        <p style="margin: 0; font-size: 14px; color: #78350f; font-style: italic; line-height: 1.5;">
                                            "{{ $note }}"
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 28px;">
                                Si estás disponible para dar clases de <strong>{{ $subjectName }}</strong>
                                en esa fecha, accede a tu panel y publica tus horarios disponibles para que
                                <strong>{{ $studentName }}</strong> pueda reservar contigo.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $dashboardUrl }}"
                                            style="display: inline-block; background-color: #219EBC; color: #ffffff; text-decoration: none;
                                                   font-size: 15px; font-weight: bold; padding: 14px 36px; border-radius: 8px;
                                                   letter-spacing: 0.03em;">
                                            Ver mi agenda →
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
                                Este correo fue enviado automáticamente por <strong>ClassGo</strong> porque un
                                estudiante solicitó tutoría en <strong>{{ $subjectName }}</strong>.<br>
                                Si no deseas recibir estas notificaciones, configúralo en tu perfil.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
