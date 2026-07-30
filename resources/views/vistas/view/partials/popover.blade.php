<div class="tutorias-popover">
    <div class="tutorias-popover__inner">
        <h3 class="tutorias-popover__title" data-translate="upcoming_tutoring_title" >Mis Próximas Tutorías</h3>
        
        <div class="tutorias-popover__table-wrapper">
            <table class="tutorias-table">
                <thead class="tutorias-table__head">
                    <tr>
                        <th class="tutorias-table__header" data-translate="upcoming_tutoring_tutor">Tutor</th>
                        <th class="tutorias-table__header" data-translate="upcoming_tutoring_subject">Materia</th>
                        <th class="tutorias-table__header" data-translate="upcoming_tutoring_date_time">Fecha y Hora</th>
                        <th class="tutorias-table__header" data-translate="upcoming_tutoring_status">Estado</th>
                        <th class="tutorias-table__header" data-translate="upcoming_tutoring_link">Link</th>
                    </tr>
                </thead>
                <tbody class="tutorias-table__body">
                    <?php
                        use App\Services\SlotBookingService;
						$service = app(SlotBookingService::class);
						$tutorias = $service->getStudentUpcomingTutorias();
                    ?>

                    @forelse($tutorias as $tutoria)
                        <tr class="tutorias-table__row">
                            <td class="tutorias-table__data">
                                <a href="/tutores/{{ $tutoria->tutor->slug }}">
                                    {{$tutoria->tutor->first_name}}<br>{{ $tutoria->tutor->last_name }}
                                </a>
                            </td>
                            <td class="tutorias-table__data">
                                {{ $tutoria->subject->name ?? 'N/A' }}
                            </td>
                            <td class="tutorias-table__data">
                                <span class="translated-date"
                                    data-date="{{ \Carbon\Carbon::parse($tutoria->start_time)->format('Y-m-d H:i:s') }}">
                                    {{ \Carbon\Carbon::parse($tutoria->start_time)->format('d M, H:i') }}
                                </span>
                            </td>
                            <td class="tutorias-table__data">
                                @if($tutoria->status == "Aceptado")
                                    <span class="tutorias-status-badge tutorias-status-badge--confirmed" data-translate="upcoming_tutoring_status_accepted">
                                        Aceptado
                                    </span>
                                @elseif($tutoria->status == "Pendiente")
                                    <span class="tutorias-status-badge tutorias-status-badge--pending" data-translate="upcoming_tutoring_status_pending">
                                        Pendiente
                                    </span>
                                @else
                                    <span class="tutorias-status-badge tutorias-status-badge--cancelled">
                                        {{ $tutoria->status }}
                                    </span>
                                @endif
                            </td>

                            @if($tutoria->status == "Aceptado")

                                <td class="tutorias-table__data">
                                    <a href="{{ $tutoria->meeting_link }}" target="_blank">
                                        <button class="tutorias-popover__button" data-translate="upcoming_tutoring_go">
                                            Ir Tutoría
                                        </button>
                                    </a>
                                </td>
                            @else
                                <td class="tutorias-table__data" data-translate="upcoming_tutoring_not_available">
                                    No disponible
                                </td>
                            @endif
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 1rem; color: #6B7280;"
                                data-translate="upcoming_tutoring_empty">
                                No tienes tutorías próximas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tutorias-popover__footer">
            <span data-translate="upcoming_tutoring_view_all">
                    Ver todas mis reservas
            </span>
        </div>
    </div>
</div>

<style>
    /* ======================================================= */
    /* VARIABLES DE DISEÑO (Colores y Espaciado) */
    /* ======================================================= */
    :root {
        --color-white: #FFFFFF;
        --color-gray-50: #F9FAFB;
        --color-gray-200: #E5E7EB;
        --color-gray-500: #6B7280;
        --color-gray-600: #4B5563;
        --color-gray-900: #111827;
        --color-cyan-700: #0E7490;
        --color-cyan-900: #0F3A5D;
        
        /* Estados */
        --color-green-100: #D1FAE5;
        --color-green-800: #065F46;
        --color-yellow-100: #FEF3C7;
        --color-yellow-800: #92400E;
        --color-red-100: #FEE2E2;
        --color-red-800: #991B1B;
    }

    /* ======================================================= */
    /* I. CONTENEDOR Y TRANSICIÓN (POPOVER) */
    /* ======================================================= */

    .popover-parent {
        position: relative; /* Clave para el posicionamiento absoluto del popover */
    }

    .tutorias-popover {
   
        position: absolute;
        right: 0;
        margin-top: 0.5rem;
        width: 45rem;
        max-width: 60rem; 
        border-radius: 0.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        background-color: var(--color-white);
        overflow: hidden;
        z-index: 20;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-0.5rem); /* -translate-y-2 */
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .popover-parent:hover .tutorias-popover {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .tutorias-popover__inner {
        padding: 1.25rem; /* p-5 */
        color: var(--color-gray-900);
    }

    /* ======================================================= */
    /* II. TÍTULO Y TABLA */
    /* ======================================================= */

    .tutorias-popover__title {
        /* text-lg font-semibold mb-4 */
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
        margin-top: 0;
    }

    .tutorias-popover__table-wrapper {
        overflow-x: auto;
    }

    .tutorias-table {
        width: 100%;
        min-width: 100%;
        border-collapse: collapse; /* Para evitar doble línea en las divisiones */
        border-spacing: 0;
    }

    .tutorias-table__head {
        background-color: var(--color-gray-50);
    }

    .tutorias-table__header {
        padding: 0.5rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--color-gray-500);
        text-transform: uppercase;
        border-bottom: 1px solid var(--color-gray-200); /* Simula divide-y */
    }

    .tutorias-table__body {
        background-color: var(--color-white);
    }

    .tutorias-table__data {
        padding: 0.75rem 1rem;
        white-space: nowrap;
        font-size: 0.875rem;
        color: var(--color-gray-600);
        border-bottom: 1px solid var(--color-gray-200); /* Simula divide-y */
    }

    .tutorias-table__data a{
        font-weight: 500;
        color: var(--color-gray-900);
    }

    /* ======================================================= */
    /* III. BADGES (ESTADOS) */
    /* ======================================================= */

    .tutorias-status-badge {
        padding: 0.125rem 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        line-height: 1.25rem; /* leading-5 */
        font-weight: 600;
        border-radius: 9999px; /* rounded-full */
    }

    .tutorias-status-badge--confirmed {
        background-color: var(--color-green-100);
        color: var(--color-green-800);
    }

    .tutorias-status-badge--pending {
        background-color: var(--color-yellow-100);
        color: var(--color-yellow-800);
    }

    .tutorias-status-badge--cancelled {
        background-color: var(--color-red-100);
        color: var(--color-red-800);
    }

    /* ======================================================= */
    /* IV. FOOTER */
    /* ======================================================= */

    .tutorias-popover__footer {
        margin-top: 1rem; /* mt-4 */
        padding-top: 1rem; /* pt-4 */
        text-align: center;
    }

    .tutorias-popover__footer a{
        color: var(--color-gray-500);
    }

    .tutorias-popover__link {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--color-cyan-700);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .tutorias-popover__link:hover {
        color: var(--color-cyan-900);
    }

    @media (max-width: 1100px) {

    .tutorias-popover {
        width: 370px; /* ancho controlado */
        left: auto !important;
        transform: translateY(0) !important;
    }
    
}
    .tutorias-popover__button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .tutorias-popover__button:hover {
        background-color: #0056b3;
    }
</style>
<script>
    function translateUpcomingTutoringDates() {
        const lang = localStorage.getItem("selectedLanguage") || "es";

        const locales = {
            es: "es-ES",
            en: "en-US",
            pt: "pt-BR",
        };

        document.querySelectorAll(".translated-date").forEach(function (element) {
            const dateValue = element.dataset.date;

            if (!dateValue) {
                return;
            }

            const date = new Date(dateValue.replace(" ", "T"));

            if (isNaN(date.getTime())) {
                return;
            }

            const day = String(date.getDate()).padStart(2, "0");

            const month = date.toLocaleDateString(locales[lang] || "es-ES", {
                month: "short",
            });

            const hours = String(date.getHours()).padStart(2, "0");
            const minutes = String(date.getMinutes()).padStart(2, "0");

            element.textContent = `${day} ${month}, ${hours}:${minutes}`;
        });
    }

    document.addEventListener("DOMContentLoaded", translateUpcomingTutoringDates);
    document.addEventListener("languageChanged", translateUpcomingTutoringDates);
    document.addEventListener("livewire:navigated", translateUpcomingTutoringDates);
    document.addEventListener("livewire:update", translateUpcomingTutoringDates);
</script>