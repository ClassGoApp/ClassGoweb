<h1 class="over-text ">
    <div class="linea"></div>
    <span data-translate="guide"></span>
    <div class="linea"></div>
</h1>
<h1 class="unlock-potencial" data-translate="unlock_potential"></h1>
<p data-translate="improve_skills"></p>
<div class="steps">
    <!--CARD-->
    <div class="steps-card">
        <div class="numero-paso" data-translate="step_1"></div>
        <img src="{{ asset('images/home/models/img1.webp') }}" alt="Pasos">
        <h1 data-translate="sign_up"></h1>
        <p data-translate="create_account"></p>
        <a href=" {{ route('login')}}"><button><span data-translate="begin"></span></button></a>
    </div> <!--FIN CARD-->
    <!--CARD-->
    <div class="steps-card">
        <div class="numero-paso" data-translate="step_2"></div>
        <img src="{{ asset('images/home/models/img2.webp') }}" alt="Pasos">
        <h1 data-translate="find_tutor"></h1>
        <p data-translate="tutores_calificados"></p>
        <a href=" {{ route('buscar')}}"><button><span data-translate="buscar_ahora"></span></button></a>
    </div> <!--FIN CARD-->
    <!--CARD-->
    <div class="steps-card">
        <div class="numero-paso" data-translate="step_3"></div>
        <img src="{{ asset('images/home/models/img3.webp') }}" alt="Pasos">
        <h1 data-translate="reservar_ahora"></h1>
        <p data-translate="encuentra_mejor"></p>
        <a href=" {{ route('login')}}"><button><span data-translate="empecemos"></span></button></a>
    </div> <!--FIN CARD-->

    <!--COMIENZA TU JORNADA CARD-->
    <div class="go">
        <div class="numero-paso">
            <i class="fa-solid fa-person-running"></i>
        </div>
        <h1 data-translate="comenzar_jornada"></h1>
        <p data-translate="comenzar_viaje"></p>
        <a href="{{ route('buscar')}}"><button class="button-go"><span data-translate="empezar_ahora"></span></button></a>
    </div>
</div>