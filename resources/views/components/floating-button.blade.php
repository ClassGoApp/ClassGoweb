
<div class="fab-container">
    <button id="fab-option-whatsapp" class="fab-option fab-option--whatsapp">
        <i class="fab fa-whatsapp"></i>
        <span class="fab-option__label">Chat de WhatsApp</span>
    </button>
    
    <button id="fab-option-magic" class="fab-option fab-option--magic">
        <i class="fas fa-magic"></i>
        <span class="fab-option__label">Pregúntale a la IA</span>
    </button>
    
    <button id="fab-option-chat" class="fab-option fab-option--chat">
        <i class="far fa-comment-dots"></i>
        <span class="fab-option__label">Chat de Soporte</span>
    </button>
    
    <button id="fab-main-button" class="fab-main">
        {{-- <i id="fab-main-icon" class="fas fa-book"></i> --}}
        <img id="fab-main-icon" class="tutoria-disponible-boton" src="{{ asset('images/logoClassgo.png') }}" alt="">
        
        <span id="fab-tooltip-closed" class="fab-main__tooltip fab-main__tooltip--closed">
            Tutorías Pendientes
        </span>
        <span id="fab-tooltip-open" class="fab-main__tooltip fab-main__tooltip--open hidden">
            Cerrar
        </span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fabMainButton = document.getElementById('fab-main-button');
        const fabMainIcon = document.getElementById('fab-main-icon');
        const fabOptions = [
            document.getElementById('fab-option-whatsapp'),
            document.getElementById('fab-option-magic'),
            document.getElementById('fab-option-chat')
        ];
        const fabTooltipClosed = document.getElementById('fab-tooltip-closed');
        const fabTooltipOpen = document.getElementById('fab-tooltip-open');

        let isFabExpanded = false; // Estado del FAB

        /**
         * Alterna la expansión de los botones flotantes.
         */
        function toggleFab() {
            isFabExpanded = !isFabExpanded;

            if (isFabExpanded) {
                fabMainButton.classList.add('expanded');
                fabMainIcon.classList.remove('fa-book'); // Cambia el icono principal
                fabMainIcon.classList.add('fa-times'); // Icono de "X" al expandir

                // Ocultar tooltip "Pendientes" y mostrar "Cerrar"
                fabTooltipClosed.classList.add('hidden');
                fabTooltipOpen.classList.remove('hidden');

                fabOptions.forEach((button, index) => {
                    // Aplica un retraso para una animación escalonada (abajo hacia arriba)
                    setTimeout(() => {
                        button.classList.add('active'); // CSS aplica la transición de transform
                    }, index * 50); 
                });
            } else {
                fabMainButton.classList.remove('expanded');
                fabMainIcon.classList.remove('fa-times'); // Vuelve al icono original
                fabMainIcon.classList.add('fa-book'); // Icono de libro al colapsar

                // Ocultar tooltip "Cerrar" y mostrar "Pendientes"
                fabTooltipClosed.classList.remove('hidden');
                fabTooltipOpen.classList.add('hidden');

                // Invierte el orden para que se oculten de abajo hacia arriba
                fabOptions.slice().reverse().forEach((button, index) => {
                    setTimeout(() => {
                        button.classList.remove('active'); // CSS aplica la transición
                    }, index * 50);
                });
            }
        }

        // Event listener para el botón principal
        fabMainButton.addEventListener('click', toggleFab);

        // Event listeners para las opciones individuales
        fabOptions.forEach(option => {
            option.addEventListener('click', () => {
                alert(`Has hecho clic en: ${option.id}`);
                toggleFab(); // Cierra el menú después de una acción
            });
        });

        // Opcional: Cerrar el FAB al hacer clic fuera de él
        document.addEventListener('click', (event) => {
            const isClickInsideFab = fabMainButton.contains(event.target) || fabOptions.some(option => option.contains(event.target));
            
            if (isFabExpanded && !isClickInsideFab) {
                toggleFab();
            }
        });
    });
</script>