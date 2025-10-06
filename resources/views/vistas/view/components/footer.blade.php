<footer>
    <div class="footer-container">
        <div class="container-info">
            <div class="footer-info"><!--ClassGo Logo + info-->
                <img src="{{ asset('images/logoclassgo.png') }}" alt="logo">
                <div class="info-text">
                    <i class="fa-solid fa-envelope icon"></i>
                    <p>classgobol@gmail.com</p>
                </div>
                <div class="info-text">
                    <i class="fa-brands fa-whatsapp icon"></i>
                    <a href="https://wa.link/yiegi5">
                        <p>77573997</p>
                    </a>
                </div>
                @auth
                <a href=" {{ route('buscar.tutor')}}"><button class="btn-registrate"><span data-translate="buscar_tutor">Buscar Tutor</span></button></a>
                @endauth
                @guest
                <a href=" {{ route('register')}}"><button class="btn-registrate"><span data-translate="registrate_gratis">Registrate Gratis</span></button></a>
                @endguest

            </div>
            <div class="footer-about"> <!--List about-->
                <div class="box">
                    <h1>Tutores</h1>
                    <a href=" {{ route('buscar.tutor')}}">
                        <p data-translate="tutores_en_linea">Tutores en linea</p>
                    </a>

                </div>
                <div class="box">
                    <h1 data-translate="inicia_hoy">Inicia Hoy</h1>

                    <a href=" {{ route('register')}}">
                        <p data-translate="registrate">Registrate</p>
                    </a>
                    <a href="{{ route('buscar.tutor')}}">
                        <p data-translate="encontrar_tutor">Encontrar Tutor</p>
                    </a>
                </div>
                <div class="box">
                    <h1>Leer Más</h1>
                    <a href=" {{ route('terminos') }}"> <p>Términos y Condiciones</p> </a>
                    
                </div>
                <div class="box">
                    <h1>Opten la App</h1>
                    <p>¡Lleva tu educación a todas partes!</p>
                    <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><img src="{{ asset('images/googleplay.png')}}" alt="" style=" width: 150px;"></a>
                </div>
                <div class="box">
                    <a href="{{ route('nosotros')}}"><h1>Nosotros</h1></a>
                    <a href=" {{ route('nosotros')}}#mision"><p>Mision</p></a>
                    <a href=" {{ route('nosotros')}}#vision"><p>Vision</p></a>
                    <a href="{{ route('nosotros')}}#team"><p>Desarrolladores</p></a>
                </div>
                <div class="box">
                    <h1 data-translate="preguntas">Preguntas</h1>
                    <a href="preguntas">
                        <p data-translate="preguntas_frecuentes">Preguntas frecuentes</p>
                    </a>
                </div>
            </div>

        </div>
        <div class="container-redes">
            <a href="https://www.tiktok.com/@classgoapp" target="_blank">
                <div class="circle-icon"><i class="fa-brands fa-tiktok fa-2x"></i></div>
            </a>
            <a href="https://www.facebook.com/profile.php?id=61578383078347" target="_blank">
                <div class="circle-icon"><i class="fa-brands fa-facebook-f"></i></div>
            </a>
            <a href="https://www.instagram.com/classgo_app/" target="_blank">
                <div class="circle-icon"><i class="fa-brands fa-instagram"></i></div>
            </a>
            <a href="https://wa.link/yiegi5" target="_blank">
                <div class="circle-icon"><i class="fa-brands fa-whatsapp"></i></div>
            </a>
        </div>
        <hr>
        <p class="derechos-reservados">© 2025 classgobol. <span data-translate="todos_derechos">Todos los derechos reservados.</span></p>

    </div>
</footer>