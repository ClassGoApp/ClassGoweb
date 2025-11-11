<div class="profile-card">
    
    <div class="profile-card__image-container">
        <img 
            class="profile-card__image" 
            src="https://placehold.co/600x720/e9e8e7/000000?text=Sophie+Bennett" 
            alt="Sophie Bennett"
            onerror="this.src='https://placehold.co/600x720/d1d1d1/000000?text=Error';"
        >
    </div>

    <div class="profile-card__content">
        
        <div class="profile-card__header">
            <h2 class="profile-card__name">Sophie Bennett</h2>
            <svg class="profile-card__verified-icon" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>

        <p class="profile-card__description">
            Product Designer who focuses on simplicity & usability.
        </p>

        <div class="profile-card__footer">
            
            <div class="profile-card__stats-group">
                
                <span class="profile-card__stat">
                    <svg class="profile-card__stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    312
                </span>
                
                <span class="profile-card__stat">
                    <svg class="profile-card__stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    48
                </span>
            </div>

            <button class="profile-card__button">
                Follow +
            </button>
        </div>
    </div>
</div>

<style>
    /* ======================================================= */
/* VARIABLES DE COLOR */
/* ======================================================= */
:root {
    --color-white: #FFFFFF;
    --color-gray-800: #1F2937;
    --color-gray-500: #6B7280;
    --color-gray-300: #D1D5DB;
    --color-gray-100: #F3F4F6;
    --color-gray-200: #E5E7EB;
    --color-green-500: #10B981;
}

/* ======================================================= */
/* I. TARJETA PRINCIPAL */
/* ======================================================= */

.profile-card {
    /* Fondo y estructura */
    background-color: var(--color-white);
    border-radius: 1rem; /* rounded-xl (asumo 1rem) */
    overflow: hidden; /* Importante para que la imagen respete el redondeo */
    width: 100%;
    max-width: 300px; /* Ancho típico de una tarjeta */
    
    /* shadow-xl shadow-gray-300/60 */
    box-shadow: 0 20px 25px -5px rgba(209, 213, 219, 0.6), 
                0 8px 10px -6px rgba(209, 213, 219, 0.6);
}

/* ======================================================= */
/* II. IMAGEN */
/* ======================================================= */

.profile-card__image-container {
    /* Contenedor para manejar el aspecto ratio si es necesario */
    width: 100%;
    /* Altura basada en la imagen placeholder (600x720) */
    aspect-ratio: 600 / 720; 
    overflow: hidden;
}

.profile-card__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ======================================================= */
/* III. CONTENIDO Y HEADER */
/* ======================================================= */

.profile-card__content {
    /* p-6 pt-5 */
    padding: 1.5rem;
    padding-top: 1.25rem; 
}

.profile-card__header {
    /* flex items-center justify-between */
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.profile-card__name {
    /* text-xl font-semibold text-gray-800 */
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--color-gray-800);
    margin: 0;
}

.profile-card__verified-icon {
    /* w-5 h-5 text-green-500 */
    width: 1.25rem;
    height: 1.25rem;
    color: var(--color-green-500);
    flex-shrink: 0;
}

.profile-card__description {
    /* mt-1 text-sm text-gray-500 leading-snug */
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--color-gray-500);
    line-height: 1.375; /* leading-snug */
    margin-bottom: 0;
}

/* ======================================================= */
/* IV. FOOTER (Estadísticas y Botón) */
/* ======================================================= */

.profile-card__footer {
    /* mt-4 flex items-center justify-between */
    margin-top: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.profile-card__stats-group {
    /* flex items-center space-x-4 text-sm text-gray-500 */
    display: flex;
    align-items: center;
    gap: 1rem; /* space-x-4 */
    font-size: 0.875rem;
    color: var(--color-gray-500);
}

.profile-card__stat {
    /* flex items-center */
    display: flex;
    align-items: center;
}

.profile-card__stat-icon {
    /* w-4 h-4 mr-1 */
    width: 1rem;
    height: 1rem;
    margin-right: 0.25rem;
}

/* ======================================================= */
/* V. BOTÓN */
/* ======================================================= */

.profile-card__button {
    /* px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-xl */
    padding: 0.5rem 1rem; /* px-4 py-2 */
    background-color: var(--color-gray-100);
    color: var(--color-gray-800);
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0.75rem; /* rounded-xl */
    border: none;
    cursor: pointer;
    
    /* hover:bg-gray-200 transition duration-150 shadow-sm */
    transition: background-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
}

.profile-card__button:hover {
    background-color: var(--color-gray-200);
}
</style>