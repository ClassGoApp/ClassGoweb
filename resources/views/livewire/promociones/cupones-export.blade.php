<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="utf-8">
<style>
    body { font-family: Arial, sans-serif; }
    .title { font-size: 16pt; font-weight: bold; }
    .filters { font-size: 10pt; font-style: italic; margin-bottom: 20px; }
    .code { font-family: "Courier New", Courier, monospace; font-size: 12pt; margin-bottom: 5px; }
</style>
</head>
<body>
    <div class="title">Codigos de Cupones Generados</div>

    @if(!empty($filtros['nombre']) || !empty($filtros['fecha']))
        <div class="filters">
            Filtros aplicados:hola soy oscar 
            @if(!empty($filtros['nombre'])) Nombre: {{ $filtros['nombre'] }} | @endif
            @if(!empty($filtros['fecha'])) Fecha: {{ $filtros['fecha'] }} @endif
        </div>
    @endif

    <br>

    @php
        $contador = 1;
    @endphp
    @foreach ($cupones as $c)
        <div class="code">{{ $contador }} - {{ $c->codigo }}</div>
        @php
            $contador++;
        @endphp
    @endforeach
</body>
</html>
