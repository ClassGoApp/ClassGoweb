<div class="tutorias-popover">
    
    <div class="tutorias-popover__inner">
        <h3 class="tutorias-popover__title">Mis Próximas Tutorías</h3>
        
        <div class="tutorias-popover__table-wrapper">
            <table class="tutorias-table">
                <thead class="tutorias-table__head">
                    <tr>
                        <th class="tutorias-table__header">Tutor</th>
                        <th class="tutorias-table__header">Materia</th>
                        <th class="tutorias-table__header">Fecha y Hora</th>
                        <th class="tutorias-table__header">Estado</th>
                    </tr>
                </thead>
                <tbody class="tutorias-table__body">
                    <tr class="tutorias-table__row">
                        <td class="tutorias-table__data tutorias-table__data--name">Ernesto Pérez M.</td>
                        <td class="tutorias-table__data">Matemáticas 101</td>
                        <td class="tutorias-table__data">Hoy, 16:00</td>
                        <td class="tutorias-table__data">
                            <span class="tutorias-status-badge tutorias-status-badge--confirmed">Confirmada</span>
                        </td>
                    </tr>
                    <tr class="tutorias-table__row">
                        <td class="tutorias-table__data tutorias-table__data--name">Ana Gómez</td>
                        <td class="tutorias-table__data">Física Básica</td>
                        <td class="tutorias-table__data">Mañana, 10:30</td>
                        <td class="tutorias-table__data">
                            <span class="tutorias-status-badge tutorias-status-badge--pending">Pendiente</span>
                        </td>
                    </tr>
                    <tr class="tutorias-table__row">
                        <td class="tutorias-table__data tutorias-table__data--name">Luis Fernandez</td>
                        <td class="tutorias-table__data">Química Orgánica</td>
                        <td class="tutorias-table__data">20 Nov, 14:00</td>
                        <td class="tutorias-table__data">
                            <span class="tutorias-status-badge tutorias-status-badge--cancelled">Cancelada</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tutorias-popover__footer">
            <a href="#" class="tutorias-popover__link">
                Ver todas mis reservas &rarr;
            </a>
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

    /*
    * Estructura de transición:
    * El Popover debe estar anidado dentro de un elemento con la clase .popover-parent.
    * * HTML de ejemplo para que funcione:
    * <div class="popover-parent"> 
    * <button>Abrir Popover</button>
    * <div class="tutorias-popover">...</div> 
    * </div>
    */
    .popover-parent {
        position: relative; /* Clave para el posicionamiento absoluto del popover */
    }

    .tutorias-popover {
        /* absolute right-0 mt-2 */
        position: absolute;
        right: 0;
        margin-top: 0.5rem; /* mt-2 */
        
        /* w-auto min-w-[30rem] */
        width: auto;
        min-width: 30rem;
        
        /* rounded-lg shadow-2xl bg-white overflow-hidden z-20 */
        border-radius: 0.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        background-color: var(--color-white);
        overflow: hidden;
        z-index: 20;
        
        /* Estado inicial: oculto y transformado */
        opacity: 0;
        visibility: hidden;
        transform: translateY(-0.5rem); /* -translate-y-2 */
        
        /* transition-all duration-300 ease-in-out */
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Estado al hacer hover en el contenedor padre (.popover-parent) */
    .popover-parent:hover .tutorias-popover {
        /* group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 */
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Contenido interno */
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
        /* overflow-x-auto */
        overflow-x: auto;
    }

    .tutorias-table {
        /* min-w-full divide-y divide-gray-200 */
        width: 100%;
        min-width: 100%;
        border-collapse: collapse; /* Para evitar doble línea en las divisiones */
        border-spacing: 0;
    }

    .tutorias-table__head {
        background-color: var(--color-gray-50);
    }

    .tutorias-table__header {
        /* px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase */
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
        /* px-4 py-3 whitespace-nowrap text-sm text-gray-600 */
        padding: 0.75rem 1rem;
        white-space: nowrap;
        font-size: 0.875rem;
        color: var(--color-gray-600);
        border-bottom: 1px solid var(--color-gray-200); /* Simula divide-y */
    }

    .tutorias-table__data--name {
        /* font-medium text-gray-900 */
        font-weight: 500;
        color: var(--color-gray-900);
    }

    /* ======================================================= */
    /* III. BADGES (ESTADOS) */
    /* ======================================================= */

    .tutorias-status-badge {
        /* px-2 inline-flex text-xs leading-5 font-semibold rounded-full */
        padding: 0.125rem 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        line-height: 1.25rem; /* leading-5 */
        font-weight: 600;
        border-radius: 9999px; /* rounded-full */
    }

    /* Modificadores de Estado */
    .tutorias-status-badge--confirmed {
        /* bg-green-100 text-green-800 */
        background-color: var(--color-green-100);
        color: var(--color-green-800);
    }

    .tutorias-status-badge--pending {
        /* bg-yellow-100 text-yellow-800 */
        background-color: var(--color-yellow-100);
        color: var(--color-yellow-800);
    }

    .tutorias-status-badge--cancelled {
        /* bg-red-100 text-red-800 */
        background-color: var(--color-red-100);
        color: var(--color-red-800);
    }

    /* ======================================================= */
    /* IV. FOOTER */
    /* ======================================================= */

    .tutorias-popover__footer {
        /* border-t border-gray-200 mt-4 pt-4 text-center */
        border-top: 1px solid var(--color-gray-200);
        margin-top: 1rem; /* mt-4 */
        padding-top: 1rem; /* pt-4 */
        text-align: center;
    }

    .tutorias-popover__link {
        /* text-sm font-medium text-cyan-700 hover:text-cyan-900 */
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
</style>