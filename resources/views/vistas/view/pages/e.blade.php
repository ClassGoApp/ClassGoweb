<!-- Imagen -->
<img src="{{ asset('images/tutors/default.png') }}"
    alt="Foto de"
    class="tutor-profile-img"
    id="profileImage">

<!-- Modal -->
<!-- Modal Imagen -->
<div id="imageModal" class="image-modal">
    <div class="image-modal-inner">
        <div class="image-modal-wrapper">
            <img class="image-modal-content" id="modalImage">
            <button id="closeModal" class="close-modal-btn">&times;</button>
        </div>
    </div>
</div>

<style>
    .tutor-profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    /* --- Efecto al pasar el mouse --- */
    .tutor-profile-img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.4);
        filter: brightness(0.9);
    }

    .image-modal {
        display: none;
        /* 🔑 Inicialmente oculto */
        position: fixed;
        inset: 0;
        z-index: 1000;
        backdrop-filter: blur(5px) brightness(0.6);
        background-color: rgba(0, 0, 0, 0.4);
        overflow: hidden;
        justify-content: center;
        align-items: center;
    }

    .image-modal-inner {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .image-modal-wrapper {
        position: relative;
        display: inline-block;
    }

    .image-modal-content {
        max-width: 80%;
        max-height: 75%;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        display: block;
        animation: fadeIn 0.4s ease;
    }

    .close-modal-btn {
        position: absolute;
        bottom: 0;
        /* justo sobre la parte inferior de la imagen */
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        background: rgba(0, 0, 0, 0.6);
        border: none;
        color: white;
        font-size: 32px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
    }

    .close-modal-btn:hover {
        background: rgba(0, 0, 0, 0.9);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    body.modal-open {
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const profileImg = document.getElementById("profileImage");
        const closeModal = document.getElementById("closeModal");

        // 🔑 Modal SOLO abre al hacer clic en la imagen
        profileImg.addEventListener('click', function() {
            modal.style.display = "flex";
            modalImg.src = this.src;
            document.body.classList.add("modal-open");
        });

        // Cerrar con botón
        closeModal.addEventListener('click', function() {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        });

        // Cerrar al hacer clic fuera de la imagen
        modal.addEventListener('click', function(e) {
            if (!modalImg.contains(e.target) && !closeModal.contains(e.target)) {
                modal.style.display = "none";
                document.body.classList.remove("modal-open");
            }
        });
    });
</script>