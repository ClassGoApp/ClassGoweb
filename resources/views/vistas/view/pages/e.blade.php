<img src="{{ asset('images/tutors/default.png') }}" alt="Foto de " class="tutor-profile-img" style="background-color: white">


<div id="imageModal" class="image-modal">
    <span id="closeModal">&times;</span>
    <img class="image-modal-content" id="modalImage">
</div>


<style>
    .modal-trigger {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .modal-trigger:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
        justify-content: center;
        align-items: center;
    }

    .image-modal-content {
        max-width: 80%;
        max-height: 80%;
        border-radius: 10px;
    }

    #closeModal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    #closeModal:hover {
        color: #ddd;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const images = document.querySelectorAll('.modal-trigger');
        const closeBtn = document.getElementById('closeModal');

        images.forEach(img => {
            img.onclick = function() {
                modal.style.display = "flex";
                modalImg.src = this.src;
            }
        });

        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        modal.onclick = function(e) {
            if (e.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>