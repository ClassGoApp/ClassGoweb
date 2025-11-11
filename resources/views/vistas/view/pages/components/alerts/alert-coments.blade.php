<div class="alert-success" role="alert">
    <div>
        <div class="alert-success__content">
            <h3 class="alert-success__title">¡Gracias por tu reseña!</h3>
            <p class="alert-success__message">Tu opinión ha sido registrada y ya es visible para otros estudiantes.</p>
        </div>
    </div>
</div>

<style>
    /* ======================================================= */
/* VARIABLES DE DISEÑO (Para consistencia en los tonos de verde) */
/* ======================================================= */
:root {
    --color-green-50: #ECFDF5;
    --color-green-500: #10B981;
    --color-green-600: #059669;
    --color-green-700: #047857;
    --color-green-800: #065F46;
}

/* ======================================================= */
/* I. BLOQUE PRINCIPAL (alert-success) */
/* ======================================================= */

.alert-success {
    /* p-4 my-6 bg-green-50 rounded-lg */
    padding: 1rem; /* p-4 */
    margin-top: 1.5rem; /* my-6 */
    margin-bottom: 1.5rem; /* my-6 */
    background-color: var(--color-green-50); 
    border-radius: 0.5rem; /* rounded-lg */

    /* Asegura que el rol de alerta no afecte el estilo */
    box-sizing: border-box; 
}

/* ======================================================= */
/* II. CUERPO INTERNO Y ALINEACIÓN */
/* ======================================================= */

.alert-success__body {
    /* flex */
    display: flex;
    text-align: start
}

.alert-success__icon-wrapper {
    /* flex-shrink-0 */
    flex-shrink: 0;
}

.alert-success__icon {
    /* w-6 h-6 text-green-600 */
    width: 1.5rem;
    height: 1.5rem;
    color: var(--color-green-600);
}

.alert-success__content {
    /* ml-3 */
    margin-left: 0.75rem; 
}

/* ======================================================= */
/* III. TIPOGRAFÍA */
/* ======================================================= */

.alert-success__title {
    /* font-semibold text-green-800 */
    font-weight: 600;
    color: var(--color-green-800);
    margin: 0;
    text-align: starts
}

.alert-success__message {
    /* text-sm text-green-700 mt-1 */
    font-size: 0.875rem;
    color: var(--color-green-700);
    margin-top: 0.25rem; /* mt-1 */
    margin-bottom: 0;
}
</style>