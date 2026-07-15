<div style="position: absolute; background:#fff;padding:2rem 1.5rem;border-radius:1rem;max-width:350px;width:90%; display:flex; justify-content:center; flex-flow: column wrap;">
    <button id="close-modal-share" style="position:absolute;top:10px;right:15px;background:none;border:none;font-size:1.5rem;cursor:pointer;">&times;</button>
    <img src="{{ asset('images/Tugo_With_Phone.png') }}" style="width: 300px; ">
    <h3 style="margin-bottom:1rem;" data-translate="share_modal_title">
        Compartir perfil
    </h3>

    <p style="margin-bottom:1.2rem;" data-translate="share_modal_description">
        Echa un vistazo a mi perfil en ClassGo!
    </p>
    <div style="display:flex;flex-direction:column;gap:1rem;">
        <button id="btn-share-whatsapp" style="background:#25D366;color:#fff;font-weight:600;padding:0.7rem 1rem;border:none;border-radius:0.7rem;display:flex;align-items:center;gap:0.7rem;cursor:pointer;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.832 4.58 2.236 6.364L4 29l7.818-2.236A12.94 12.94 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3Zm0 22c-1.77 0-3.484-.463-4.98-1.34l-.355-.21-4.646 1.33 1.33-4.646-.21-.355A9.956 9.956 0 0 1 6 15c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10Zm5.29-7.29c-.29-.145-1.71-.84-1.975-.935-.265-.095-.46-.145-.655.145-.195.29-.75.935-.92 1.13-.17.195-.34.22-.63.075-.29-.145-1.225-.45-2.335-1.435-.863-.77-1.445-1.72-1.615-2.01-.17-.29-.018-.447.127-.592.13-.13.29-.34.435-.51.145-.17.193-.29.29-.485.097-.195.048-.365-.024-.51-.073-.145-.655-1.58-.9-2.165-.237-.57-.48-.492-.655-.5-.17-.007-.365-.01-.56-.01-.195 0-.51.073-.78.365-.27.29-1.03 1.01-1.03 2.465 0 1.455 1.055 2.86 1.202 3.055.145.195 2.08 3.18 5.04 4.33.705.242 1.255.386 1.685.494.708.18 1.35.155 1.86.094.567-.067 1.71-.698 1.95-1.372.24-.673.24-1.25.17-1.372-.07-.122-.265-.195-.555-.34Z" fill="#fff"/></svg>
            <span data-translate="share_modal_whatsapp">Compartir en WhatsApp</span>
        </button>
        <button id="btn-share-facebook" style="background:#1877F3;color:#fff;font-weight:600;padding:0.7rem 1rem;border:none;border-radius:0.7rem;display:flex;align-items:center;gap:0.7rem;cursor:pointer;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M29 16C29 8.82 23.18 3 16 3S3 8.82 3 16c0 6.29 4.61 11.48 10.63 12.79v-9.05h-3.2V16h3.2v-2.27c0-3.16 1.88-4.89 4.76-4.89 1.38 0 2.82.25 2.82.25v3.1h-1.59c-1.57 0-2.06.98-2.06 1.98V16h3.5l-.56 3.74h-2.94v9.05C24.39 27.48 29 22.29 29 16Z" fill="#fff"/></svg>
            <span data-translate="share_modal_facebook">Compartir en Facebook</span>
        </button>
    </div>
</div>