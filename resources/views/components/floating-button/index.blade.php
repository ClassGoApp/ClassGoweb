@auth
    @if(auth()->user()->hasRole('tutor')) <!--Si es tutor-->
        @include('components.floating-button.tutor')
    @elseif(auth()->user()->hasRole('student')) <!--Si es estudiante-->
        {{-- @include('components.floating-button.student') --}}
        @include('components.floating-button.guest') <!--NO autenticado-->

    @else
        @include('components.floating-button.guest') <!--NO autenticado-->
    @endif
@else
    @include('components.floating-button.guest') <!--NO autenticado-->
@endauth


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