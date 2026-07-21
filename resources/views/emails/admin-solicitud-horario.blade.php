<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva solicitud de horario</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f8fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #CDD6DA; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #FB8500; padding: 24px; text-align: left;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #ffffff; font-size: 22px; font-weight: bold;">
                                        🗓️ Nueva solicitud de horario
                                    </td>
                                    <td align="right" style="color: #ffffff; font-size: 32px;">
                                        📋
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Intro -->
                    <tr>
                        <td style="padding: 28px 32px 8px 32px;">
                            <p style="margin: 0; color: #374151; font-size: 16px; line-height: 1.6;">
                                Un estudiante no encontró tutores disponibles y ha solicitado un horario personalizado.
                                A continuación los detalles:
                            </p>
                        </td>
                    </tr>

                    <!-- Detalles de la solicitud -->
                    <tr>
                        <td style="padding: 16px 32px 24px 32px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;">

                                <tr style="background-color: #f1f5f9;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; width: 40%;">
                                        Estudiante
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px;">
                                        {{ $studentName }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        Correo estudiante
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $studentEmail }}
                                    </td>
                                </tr>

                                <tr style="background-color: #f1f5f9;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        Materia
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $subjectName }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        Fecha sugerida
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $preferredDate }}
                                    </td>
                                </tr>

                                <tr style="background-color: #f1f5f9;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        Horario solicitado
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $preferredTime }}
                                    </td>
                                </tr>

                                @if($note)
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb; vertical-align: top;">
                                        Nota del estudiante
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $note }}
                                    </td>
                                </tr>
                                @endif

                                <tr style="background-color: #fff7ed;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #023047; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        Fecha de solicitud
                                    </td>
                                    <td style="padding: 12px 16px; color: #374151; font-size: 13px; border-top: 1px solid #e5e7eb;">
                                        {{ $requestDate }}
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- Nota informativa -->
                    <tr>
                        <td style="padding: 0 32px 28px 32px;">
                            <p style="margin: 0; color: #6b7280; font-size: 13px; line-height: 1.6; border-left: 3px solid #FB8500; padding-left: 12px;">
                                La solicitud ya fue enviada automáticamente a los tutores calificados en esa materia.
                                Este correo es solo una notificación para el equipo encargado.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f5f9; padding: 20px 32px; text-align: center;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                Tugo &mdash; Notificación automática del sistema
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
