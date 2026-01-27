@extends('vistas.view.layouts.blank')

@section('content')
<div style="max-width:720px;margin:40px auto;padding:20px;font-family:Arial,sans-serif;">
  @if(($status ?? null) === 'expired')
    <h2>La solicitud ya expiró</h2>
    <p>El estudiante dejó de buscar tutor. Si vuelve a solicitar, te llegará otra invitación.</p>
  @else
    <h2>¡Listo! Ya estás en lista de espera</h2>
    <p>Quédate atento. Si el estudiante te elige, el sistema te notificará.</p>
  @endif
</div>
@endsection
