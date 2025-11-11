<div class="empty-state" role="status">
    <div class="empty-state__content">
        <svg class="empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
        </svg>
        
        <div class="empty-state__text-group">
            <h3 class="empty-state__title">Aún no hay reseñas</h3>
            <p class="empty-state__message">¡Sé el primero en compartir tu opinión sobre este tutor!</p>
        </div>
    </div>
</div>

<style>
    /* ======================================================= */
/* VARIABLES DE DISEÑO */
/* ======================================================= */
:root {
    --color-gray-50: #F9FAFB;
    --color-gray-400: #9CA3AF;
    --color-gray-700: #374151;
    --color-gray-800: #1F2937;
}

/* ======================================================= */
/* I. BLOQUE PRINCIPAL (empty-state) */
/* ======================================================= */

.empty-state {
    /* p-6 my-6 bg-gray-50 rounded-lg */
    padding: 1.5rem; /* p-6 */
    margin-top: 1.5rem; /* my-6 */
    margin-bottom: 1.5rem; /* my-6 */
    background-color: var(--color-gray-50);
    border-radius: 0.5rem; /* rounded-lg */
    
    /* Asegura que el rol de status no afecte el estilo */
    box-sizing: border-box; 
}

/* ======================================================= */
/* II. CONTENIDO Y CENTRADO */
/* ======================================================= */

.empty-state__content {
    /* flex flex-col items-center text-center */
    display: flex;
    flex-direction: column;
    align-items: center; /* items-center (centrado horizontal) */
    text-align: center; /* text-center */
}

/* ======================================================= */
/* III. ICONO */
/* ======================================================= */

.empty-state__icon {
    /* w-12 h-12 text-gray-400 mb-4 */
    width: 3rem; /* w-12 */
    height: 3rem; /* h-12 */
    color: var(--color-gray-400); 
    margin-bottom: 1rem; /* mb-4 */
}

/* ======================================================= */
/* IV. TIPOGRAFÍA */
/* ======================================================= */

.empty-state__text-group {
    /* Contenedor del título y mensaje */
}

.empty-state__title {
    /* font-semibold text-gray-800 */
    font-weight: 600;
    color: var(--color-gray-800);
    margin: 0;
}

.empty-state__message {
    /* text-sm text-gray-700 mt-1 */
    font-size: 0.875rem; /* text-sm */
    color: var(--color-gray-700);
    margin-top: 0.25rem; /* mt-1 */
    margin-bottom: 0;
}
</style>