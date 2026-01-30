@extends('vistas.view.layouts.blank')

@section('content')
<div style="max-width:720px;margin:40px auto;padding:20px;font-family:Arial,sans-serif;">
  @if(($status ?? null) === 'expired')
    <h2>La solicitud ya expiró</h2>
    <p>El estudiante dejó de buscar tutor. Si vuelve a solicitar, te llegará otra invitación.</p>

    {{-- ✅ Limpia la bandera para futuros links --}}
    <script>
      sessionStorage.removeItem('waitlist_reloaded');
    </script>

  @else
    <h2>¡Listo! Ya estás en lista de espera</h2>
    <p>Quédate atento. Si el estudiante te elige, el sistema te notificará.</p>

    <div style="margin-top:12px;opacity:.8;font-size:14px;">
      Este link expira en: <span id="expiresAtText">{{ $expires_at ?? '-' }}</span><br>
      Tiempo restante: <b id="tutorCountdown">--:--</b>
      <span id="tutorWarn" style="display:none;margin-left:8px;font-weight:700;color:#f59e0b;">⚠️ Expira pronto</span>
    </div>

    {{-- ✅ Contador robusto (no se atrasa en background) --}}
    <script>
      const expiresAtMsRaw = @json($expires_at_ms ?? null);
      const secondsLeftRaw = @json($seconds_left ?? null);

      let expiresAtMs = (expiresAtMsRaw !== null) ? Number(expiresAtMsRaw) : null;
      if (!expiresAtMs && secondsLeftRaw !== null) {
        expiresAtMs = Date.now() + (Number(secondsLeftRaw) * 1000);
      }

      const el = document.getElementById('tutorCountdown');
      const warn = document.getElementById('tutorWarn');

      function fmtMMSS(s){
        s = Math.max(0, Math.floor(s));
        const m = String(Math.floor(s/60)).padStart(2,'0');
        const r = String(s%60).padStart(2,'0');
        return `${m}:${r}`;
      }

      function markExpiredUI(){
        if (el) el.textContent = '00:00';
        if (warn) {
          warn.style.display = 'inline';
          warn.style.color = '#ef4444';
          warn.textContent = '❌ Link expirado';
        }

        // ✅ recargar solo 1 vez para que el backend confirme expired
        if (!sessionStorage.getItem('waitlist_reloaded')) {
          sessionStorage.setItem('waitlist_reloaded', '1');
          setTimeout(() => location.reload(), 1200);
        }
      }

      function render(){
        if (!el) return;

        if (!expiresAtMs) {
          el.textContent = '--:--';
          if (warn) {
            warn.style.display = 'inline';
            warn.style.color = '#ef4444';
            warn.textContent = 'No se pudo calcular expiración';
          }
          return;
        }

        const diffSec = Math.ceil((expiresAtMs - Date.now()) / 1000);

        if (diffSec <= 0) {
          markExpiredUI();
          return;
        }

        el.textContent = fmtMMSS(diffSec);

        if (warn) {
          if (diffSec <= 30) {
            warn.style.display = 'inline';
            warn.style.color = '#f59e0b';
            warn.textContent = '⚠️ Expira pronto';
          } else {
            warn.style.display = 'none';
          }
        }
      }

      // ✅ render inmediato
      render();

      // ✅ tick
      const t = setInterval(render, 1000);

      // ✅ limpieza si se navega fuera
      window.addEventListener('beforeunload', () => clearInterval(t));
    </script>
  @endif
</div>
@endsection
