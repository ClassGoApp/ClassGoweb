<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Google Calendar</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            font-family: Arial, sans-serif;
            color: #0f172a;
        }

        .calendar-card {
            width: 100%;
            max-width: 420px;
            padding: 32px 24px;
            background: #ffffff;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.14);
        }

        .calendar-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 30px;
            font-weight: 700;
            background:
                {{ $success ? '#dcfce7' : '#fee2e2' }};
            color:
                {{ $success ? '#166534' : '#991b1b' }};
        }

        .calendar-card h1 {
            margin: 0 0 12px;
            font-size: 1.4rem;
            color:
                {{ $success ? '#166534' : '#991b1b' }};
        }

        .calendar-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.5;
        }

        .calendar-card small {
            display: block;
            margin-top: 18px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="calendar-card">
        <div class="calendar-icon">
            {{ $success ? '✓' : '!' }}
        </div>

        <h1>
            {{ $success
                ? 'Conexión completada'
                : 'No se completó la conexión' }}
        </h1>

        <p>{{ $message }}</p>

        <small>
            Esta ventana se cerrará automáticamente.
        </small>
    </div>

    <script>
        const result = {
            type: 'google-calendar-prerequisites-result',
            success: @json($success),
            message: @json($message),
        };

        if (window.opener && !window.opener.closed) {
            window.opener.postMessage(
                result,
                window.location.origin
            );

            setTimeout(() => {
                window.close();
            }, 700);
        }
    </script>
</body>
</html>