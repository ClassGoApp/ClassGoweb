<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Sesión de Tutoría</title>
</head>

<body style="margin:0;padding:0;background:#f1f3f4;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f3f4;padding:24px 12px;">
        <tr>
            <td align="center">

                <!-- Card container -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:420px;background:#ffffff;border:1px solid #CDD6DA;border-radius:18px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#023047;padding:22px 22px 16px 22px;color:#ffffff;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div style="font-size:18px;font-weight:800;line-height:1.2;">Sesión de Tutoría
                                        </div>
                                        <div
                                            style="margin-top:6px;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#8ECAE6;font-weight:700;">
                                            ID: #{{ $sessionId }}
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <span
                                            style="display:inline-block;font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase;border:1px solid rgba(255,255,255,.25);border-radius:999px;padding:6px 10px;background:rgba(255,255,255,.12);">
                                            {{ $durationLabel ?? '20 minutos' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Time block -->
                    <tr>
                        <td style="padding:16px 22px 8px 22px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="background:#ffffff;border:1px solid #E2E8F0;border-radius:14px;">
                                <tr>
                                    <td align="center" style="padding:14px 10px;">
                                        <div
                                            style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#888;margin-bottom:6px;">
                                            Inicia
                                        </div>
                                        <div style="font-size:18px;font-weight:900;color:#023047;">
                                            {{ $startTime ?? '09:00' }}
                                        </div>
                                    </td>

                                    <!-- SVG ICON (círculo) -->
                                    <td align="center" style="padding:14px 10px;">
                                        <span
                                            style="display:inline-block;width:40px;height:40px;line-height:34px;text-align:center;border-radius:999px;background:#E8F4FB;color:#219EBC;font-size:30px;font-weight:900;">
                                            🕑
                                        </span>
                                    </td>


                                    <td align="center" style="padding:14px 10px;">
                                        <div
                                            style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#888;margin-bottom:6px;">
                                            Termina
                                        </div>
                                        <div style="font-size:18px;font-weight:900;color:#219EBC;">
                                            {{ $endTime ?? '09:20' }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Subject / Materia -->
                    <tr>
                        <td style="padding:10px 22px 6px 22px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f1f3f4;border-radius:12px;">
                                <tr>
                                    <td style="padding:12px 12px;border-left:4px solid #219EBC;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="44" valign="middle" style="padding-right:10px;">
                                                    <span
                                                        style="display:inline-block;width:40px;height:40px;border-radius:999px;background:#E8F4FB;line-height:40px;text-align:center;font-size:20px;font-weight:900;color:#219EBC;">
                                                        📘
                                                    </span>
                                                </td>
                                                <td valign="middle">
                                                    <div
                                                        style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#888;">
                                                        Materia
                                                    </div>
                                                    <div
                                                        style="margin-top:4px;font-size:14px;font-weight:900;color:#023047;">
                                                        {{ $subjectName ?? 'Materia' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Participants -->
                    <tr>
                        <td style="padding:10px 22px 6px 22px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f1f3f4;border-radius:12px;">
                                <tr>
                                    <td style="padding:12px 12px;border-left:4px solid #023047;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="44" valign="middle" style="padding-right:10px;">
                                                    <span
                                                        style="display:inline-block;width:40px;height:40px;border-radius:999px;background:rgba(2,48,71,.10);line-height:40px;text-align:center; font-size:20px;font-weight:900;color:#023047;">
                                                        👤
                                                    </span>
                                                </td>
                                                <td valign="middle">
                                                    <div
                                                        style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#888;">
                                                        Docente / Tutor
                                                    </div>
                                                    <div
                                                        style="margin-top:4px;font-size:14px;font-weight:800;color:#023047;font-style:italic;">
                                                        {{ $tutorName ?? 'Dr. Ronald Laravel' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:10px 22px 12px 22px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f1f3f4;border-radius:12px;">
                                <tr>
                                    <td style="padding:12px 12px;border-left:4px solid #FB8500;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="44" valign="middle" style="padding-right:10px;">
                                                    <span
                                                        style="display:inline-block;width:40px;height:40px;border-radius:999px;background:rgba(251,133,0,.10);line-height:40px;text-align:center; font-size:20px;font-weight:900;color:#FB8500;">
                                                        🎓
                                                    </span>
                                                </td>
                                                <td valign="middle">
                                                    <div
                                                        style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#888;">
                                                        Estudiante
                                                    </div>
                                                    <div
                                                        style="margin-top:4px;font-size:14px;font-weight:800;color:#023047;font-style:italic;">
                                                        {{ $studentName ?? 'Nombre del Estudiante' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Button -->
                    <tr>
                        <td style="padding:12px 22px 22px 22px;">
                            <a href="{{ $meetLink ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                style="display:block;text-align:center;background:#FB8500;color:#ffffff;text-decoration:none;font-weight:900;letter-spacing:1px;text-transform:uppercase;font-size:12px;padding:14px 16px;border-radius:14px;">
                                <span style="display:inline-block;vertical-align:middle;margin-right:10px;">
                                    <svg width="18" height="18" fill="#ffffff" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" />
                                    </svg>
                                </span>
                                Unirse a la Clase
                            </a>

                            @if (!empty($meetLink))
                                <div style="margin-top:10px;font-size:12px;color:#64748b;line-height:1.4;">
                                    Si el botón no funciona, copia y pega este enlace:<br>
                                    <span style="word-break:break-all;color:#219EBC;">{{ $meetLink }}</span>
                                </div>
                            @endif
                        </td>
                    </tr>

                </table>
                <!-- /Card container -->

            </td>
        </tr>
    </table>
</body>

</html>
