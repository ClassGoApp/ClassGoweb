<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupón e Invitación</title>
    <!-- Incluyendo Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Usando una fuente similar a la del diseño */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Estilo para la pestaña activa */
        .tab-active {
            border-bottom-color: #f97316; /* Naranja de Tailwind */
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <!-- Contenedor principal de la tarjeta -->
    <div class="w-full max-w-sm mx-auto bg-[#0f3443] text-white rounded-xl shadow-2xl overflow-hidden">
        
        <!-- Pestañas para alternar vistas -->
        <div class="flex">
            <button id="tabRedeem" class="w-1/2 py-3 font-semibold border-b-2 border-transparent text-gray-400 transition-colors duration-300 tab-active">Canjear Cupón</button>
            <button id="tabInvite" class="w-1/2 py-3 font-semibold border-b-2 border-transparent text-gray-400 transition-colors duration-300">Invitar</button>
        </div>

        <div class="p-8 text-center">
            <!-- Vista para Canjear Cupón (visible por defecto) -->
            <div id="redeemView">
                <h2 class="text-3xl font-bold mb-2">¿Tienes un Cupón?</h2>
                <p class="text-gray-300 mb-8">¡Ingrésalo y obtén descuentos!</p>
                <div class="space-y-4">
                    <input 
                        type="text" 
                        id="couponInput"
                        placeholder="Ingresa tu código aquí" 
                        class="w-full px-4 py-3 bg-gray-800/50 border-2 border-dashed border-gray-500 rounded-lg text-white text-center placeholder-gray-400 focus:outline-none focus:border-solid focus:border-orange-500 transition-all duration-300"
                    >
                    <button id="redeemButton" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                        Canjear
                    </button>
                </div>
                <p id="redeemMessage" class="mt-4 h-5"></p>
            </div>

            <!-- Vista para Código de Invitación (oculta por defecto) -->
            <div id="inviteView" class="hidden">
                <h2 class="text-3xl font-bold mb-2">Tu Código de Invitación</h2>
                <p class="text-gray-300 mb-8">¡Comparte y obtén descuentos!</p>
                <!-- Contenedor del código de invitación -->
                <div id="invitationCode" class="w-full px-4 py-6 mb-4 bg-gray-800/50 border-2 border-dashed border-gray-500 rounded-lg text-white text-center text-2xl font-mono tracking-widest">
                    INVITE-2024
                </div>
                <div class="space-y-4">
                    <button id="copyButton" class="w-full bg-white/90 hover:bg-white text-[#0f3443] font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                        Copiar Código
                    </button>
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                        Compartir
                    </button>
                </div>
                 <p id="copyMessage" class="mt-4 h-5"></p>
            </div>
        </div>
    </div>

    <script>
        // Elementos de las pestañas y vistas
        const tabRedeem = document.getElementById('tabRedeem');
        const tabInvite = document.getElementById('tabInvite');
        const redeemView = document.getElementById('redeemView');
        const inviteView = document.getElementById('inviteView');

        // Elementos de la vista de canje
        const redeemButton = document.getElementById('redeemButton');
        const couponInput = document.getElementById('couponInput');
        const redeemMessage = document.getElementById('redeemMessage');

        // Elementos de la vista de invitación
        const copyButton = document.getElementById('copyButton');
        const invitationCode = document.getElementById('invitationCode');
        const copyMessage = document.getElementById('copyMessage');

        // --- Lógica para alternar pestañas ---
        tabRedeem.addEventListener('click', () => {
            redeemView.classList.remove('hidden');
            inviteView.classList.add('hidden');
            tabRedeem.classList.add('tab-active');
            tabInvite.classList.remove('tab-active');
        });

        tabInvite.addEventListener('click', () => {
            inviteView.classList.remove('hidden');
            redeemView.classList.add('hidden');
            tabInvite.classList.add('tab-active');
            tabRedeem.classList.remove('tab-active');
        });

        // --- Lógica para canjear cupón ---
        redeemButton.addEventListener('click', () => {
            const couponCode = couponInput.value.trim();
            redeemMessage.textContent = '';
            redeemMessage.classList.remove('text-red-400', 'text-green-400');

            if (couponCode) {
                redeemMessage.textContent = `¡Código "${couponCode}" canjeado!`;
                redeemMessage.classList.add('text-green-400');
                couponInput.value = '';
            } else {
                redeemMessage.textContent = 'Por favor, ingresa un código.';
                redeemMessage.classList.add('text-red-400');
            }
            setTimeout(() => { redeemMessage.textContent = ''; }, 3000);
        });

        // --- Lógica para copiar código ---
        copyButton.addEventListener('click', () => {
            const codeToCopy = invitationCode.textContent.trim();
            
            // Usamos un textarea temporal para copiar el texto
            const textArea = document.createElement("textarea");
            textArea.value = codeToCopy;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                // Usamos document.execCommand para compatibilidad en iframes
                document.execCommand('copy');
                copyMessage.textContent = '¡Código copiado!';
                copyMessage.classList.add('text-green-400');
            } catch (err) {
                copyMessage.textContent = 'Error al copiar.';
                copyMessage.classList.add('text-red-400');
                console.error('Error al copiar el código: ', err);
            }
            document.body.removeChild(textArea);
            setTimeout(() => { copyMessage.textContent = ''; }, 3000);
        });
    </script>

</body>
</html>
