<!-- resources/views/conferences/index.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conferencias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
@if (session('status'))
    <div>{{ session('status') }}</div>
@endif

<div>
    @forelse ($conferencias as $item)
        <article style="border:1px solid #ddd;padding:12px;margin-bottom:12px;border-radius:8px;">
            <h2 style="margin:0 0 4px 0;">{{ $item->name }}</h2>

            <div style="font-size:14px;color:#666;margin-bottom:8px;">
                {{ $item->description }}
            </div>

            <div style="font-size:14px;margin-bottom:6px;">
                <strong>Fecha:</strong>
                {{ $item->start_datetime->format('d/m/Y H:i') }}
                —
                {{ $item->end_datetime->format('d/m/Y H:i') }}
            </div>

            <div style="font-size:14px;margin-bottom:6px;">
                <strong>Tutor:</strong> {{ $item->tutor()->profiles->first_name ?? '—' }}
            </div>

            <div style="font-size:14px;margin-bottom:6px;">
                <strong>Cupo:</strong>
                {{ $item->students_count }}/{{ $item->ability }}
                ({{ max($item->ability - $item->students_count, 0) }} disponibles)
            </div>

            <div style="font-size:14px;margin-bottom:8px;">
                <strong>Tipo:</strong> {{ $item->is_free ? 'Gratuita' : 'De pago' }}
            </div>

            @auth
                @if (auth()->user()->role === 'student')
                    @php
                        $yaInscrito = in_array($item->id, $enrolledIds ?? []);
                        $sinCupo    = $item->students_count >= $item->ability;
                    @endphp

                @endif
            @endauth
        </article>
    @empty
        <p>No hay conferencias.</p>
    @endforelse
</div>

<div>
    {{ $conferencias->links() }}
</div>
</body>
</html>
