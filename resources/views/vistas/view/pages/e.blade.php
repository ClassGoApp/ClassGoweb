<div class="parent">
    <div class="div1">
        <img src="{{ asset('images/home/Tugo-skin/contabilidad.webp') }}" class="filtro-img" alt="Matemáticas">
        <div class="filtro-content">
            <h3>Contabilidad</h3>
            <p>Contabilidad Intermedia, de Sociedades, Agropecuaria, Fiscal, Gubernamental, Tributaria, de Costos.</p>
        </div>
    </div>
    <div class="div2">
        <img src="{{ asset('images/home/Tugo-skin/matematicas.webp') }}" class="filtro-img" alt="Programación">
        <div class="filtro-content">
            <h3>Ciencias Exactas</h3>
            <p>Cálculo, Física, Mecánica Aplicada, Física de Materiales, Estática</p>
        </div>
    </div>
    <div class="div3">
        <img src="{{ asset('images/home/Tugo-skin/quimica.webp') }}" class="filtro-img" alt="Inglés">
        <div class="filtro-content">
            <h3>Química</h3>
            <p>Química de Soluciones, Cromatografía, Eletroquímica, Química de Alimentos, Reacciones Químicas.</p>
        </div>
    </div>
    <div class="div4">
        <img src="{{ asset('images/home/Tugo-skin/programacion.webp') }}" class="filtro-img" alt="Ciencias Naturales">
        <div class="filtro-content">
            <h3>Programación</h3>
            <p>Teoría de la Computación, Python, Php, Java, Flutter, Estructura de Datos, Iteracción Hombre-Computador.
            </p>
        </div>
    </div>
    <div class="div5">
        <img src="{{ asset('images/home/Tugo-skin/ingles.webp') }}" class="filtro-img" alt="Historia">
        <div class="filtro-content">
            <h3>Inglés</h3>
            <p>Ezpresiones Idiomáticas, Pronunciación, Escritura, Análisi de Textos, Perfeccionamiento Gramatical.</p>
        </div>
    </div>
    <div class="div6">
        <img src="{{ asset('images/home/Tugo-skin/musica.webp') }}" class="filtro-img" alt="Literatura">
        <div class="filtro-content">
            <h3>Música</h3>
            <p>Composición, Lectura Musical, Acordes, Rítmica.</p>
        </div>
    </div>
</div>

<style>
    .parent {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        /* filas con altura base para que los spans (1, 2, 3) se reflejen en la altura */
        grid-template-rows: repeat(3, clamp(96px, 18vw, 200px));
        gap: 12px;
        padding: 2rem 4rem;
        /* margen interno general */
        box-sizing: border-box;
    }

    /* Cada celda funciona como contenedor de imagen recortada */
    .parent>div {
        position: relative;
        overflow: hidden;
        padding: 0.6rem;
        /* similar a profile-card__image-container2 */
        border-radius: 2rem;
        box-sizing: border-box;
        background: transparent;
    }

    .filtro-img {
        position: absolute;
        background: var(--bg-gradient3);
        /* background: var(--panel-background); */
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 2rem;
        /* mismo radio que la card destacada */
        display: block;
        transform: scale(1);
        transition: transform .5s cubic-bezier(.4, 0, .2, 1);
    }

    /* Overlay degradado oscuro desde mitad hacia abajo */
    .parent>div::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 45%;
        /* punto donde comienza a oscurecer (aprox mitad) */
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.55) 60%, rgba(0, 0, 0, 0.85) 100%);
        border-radius: 0 0 2rem 2rem;
        pointer-events: none;
    }

    /* Contenido textual sobre la imagen */
    .filtro-content {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 1rem 1.25rem 1.1rem 1.25rem;
        color: #fff;
        z-index: 2;
        pointer-events: none;
    }

    .filtro-content h3 {
        margin: 0 0 .25rem 0;
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.2;
        text-shadow: 0 2px 6px rgba(0, 0, 0, .4);
        transform: translateY(4px);
        transition: transform .35s ease, opacity .35s ease;
        opacity: .95;
    }

    .filtro-content p {
        margin: 0;
        font-size: .85rem;
        line-height: 1.3;
        color: rgba(255, 255, 255, .92);
        text-shadow: 0 1px 3px rgba(0, 0, 0, .4);
        transform: translateY(6px);
        transition: transform .35s ease, opacity .35s ease;
        opacity: .9;
    }

    /* Hover sencillo */
    .parent>div:hover .filtro-img {
        transform: scale(1.05);
    }

    .parent>div:hover .filtro-content h3,
    .parent>div:hover .filtro-content p {
        transform: translateY(0);
        opacity: 1;
    }

    .parent>div:hover {
        box-shadow: 0 10px 24px rgba(0, 0, 0, .12);
    }
    @media (max-width: 576px) {
        
    }

    @media (max-width: 768px) {
        .parent>div::after {
            top: 50%;
            /* un poco más abajo en móviles si se ve muy oscuro */
        }
    }

    .div1 {
        grid-row: span 3 / span 3;
    }


    .div3 {
        grid-row: span 2 / span 2;
        grid-column-start: 2;
        grid-row-start: 2;
    }

    .div4 {
        grid-row: span 3 / span 3;
        grid-column-start: 3;
        grid-row-start: 1;
    }

    .div5 {
        grid-row: span 2 / span 2;
        grid-column-start: 4;
        grid-row-start: 1;
    }

    .div6 {
        grid-column-start: 4;
        grid-row-start: 3;
    }
</style>