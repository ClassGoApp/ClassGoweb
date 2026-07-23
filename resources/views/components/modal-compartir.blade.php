<div id="modalCompartir" class="modal-compartir">
    <div class="modal-box">
        <div class="modal-header">
            <img class="img-modal" src="{{ asset('images/Tugo_With_Phone.png')}}" alt="">

            <p data-translate="promotions_share_modal_description">
                {{ __('promotions.share_modal_description') }}
            </p>
        </div>

        <div class="modal-redes">
            <a href="#" class="red-btn whatsapp" id="whatsapp-link" target="_blank">
                <img src="{{ asset('images/whatsapp.png')}}" alt="">
                WhatsApp
            </a>

            <a href="#" class="red-btn facebook" id="facebook-link" target="_blank">
                <img src="{{ asset('images/facebook.png')}}" alt="">
                Facebook
            </a>
        </div>

        <div class="modal-footer">
            <button id="cerrarModal" class="btn-cerrar" data-translate="promotions_share_modal_close">
                {{ __('promotions.share_modal_close') }}
            </button>
        </div>
    </div>
</div>

<script>
    function getPromotionsShareMessage(lang, codigoInvitacion) {
        const messages = {
            es: `¡Instala nuestra app y obtén un descuento en tu próxima tutoría! Regístrate aquí 👉 https://classgoapp.com/register?ref=${codigoInvitacion} y utiliza el siguiente código: ${codigoInvitacion}`,
            en: `Install our app and get a discount on your next tutoring session! Register here 👉 https://classgoapp.com/register?ref=${codigoInvitacion} and use this code: ${codigoInvitacion}`,
            pt: `Instale nosso app e ganhe desconto na sua próxima tutoria! Cadastre-se aqui 👉 https://classgoapp.com/register?ref=${codigoInvitacion} e use este código: ${codigoInvitacion}`,
        };

        return messages[lang] || messages.es;
    }

    function updatePromotionShareLinks() {
        const invCodeElement = document.getElementById('inv-code');

        if (!invCodeElement) {
            return;
        }

        const codigoInvitacion = invCodeElement.innerText.trim();
        const lang = typeof getCurrentLanguage === 'function'
            ? getCurrentLanguage()
            : (localStorage.getItem('selectedLanguage') || 'es');

        const mensaje = getPromotionsShareMessage(lang, codigoInvitacion);
        const mensajeCodificado = encodeURIComponent(mensaje);
        const urlRegistro = `https://classgoapp.com/register?ref=${codigoInvitacion}`;

        const whatsappLink = document.getElementById('whatsapp-link');
        const facebookLink = document.getElementById('facebook-link');

        if (whatsappLink) {
            whatsappLink.href = `https://wa.me/?text=${mensajeCodificado}`;
        }

        if (facebookLink) {
            facebookLink.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(urlRegistro)}&quote=${mensajeCodificado}`;
        }
    }

    document.addEventListener('DOMContentLoaded', updatePromotionShareLinks);
    document.addEventListener('languageChanged', updatePromotionShareLinks);
    document.addEventListener('livewire:navigated', updatePromotionShareLinks);
</script>




