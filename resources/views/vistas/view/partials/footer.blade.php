<footer>
    <div class="footer-container">
        <div class="container-info">
            <div class="footer-info"><!--ClassGo Logo + info-->
                <img src="{{ asset('images/home/logoclassgo.png') }}" alt="logo">
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
                <a href=" {{ route('buscar')}}"><button class="btn-registrate"><span data-translate="buscar_tutor"></span></button></a>
                @endauth
                @guest
                <a href=" {{ route('login', ['mode' => 'register'])}}"><button class="btn-registrate"><span data-translate="registrate_gratis"></span></button></a>
                @endguest

            </div>
            <div class="footer-about"> <!--List about-->
                <div class="box">
                    <h1 data-translate="tutors"></h1>
                    <a href=" {{ route('buscar')}}">
                        <p data-translate="tutores_en_linea"></p>
                    </a>

                </div>
                <div class="box">
                    <h1 data-translate="inicia_hoy"></h1>

                    <a href=" {{ route('login', ['mode' => 'register'])}}">
                        <p data-translate="registrate"></p>
                    </a>
                    <a href="{{ route('buscar')}}">
                        <p data-translate="encontrar_tutor"></p>
                    </a>
                </div>
                <div class="box">
                    <h1 data-translate="lee_ma"></h1>
                    <a href=" {{ route('terminos') }}">
                        <p data-translate="terminos"></p>
                    </a>

                </div>
                <div class="box">
                    <h1 data-translate="get_app"></h1>
                    <p data-translate="edu_world"></p>
                    <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><img src="{{ asset('images/googleplay.png')}}" alt="" style=" width: 150px;"></a>
                </div>
                <div class="box">
                    <a href="{{ route('nosotros')}}">
                        <h1 data-translate="nosotros"></h1>
                    </a>
                    <a href=" {{ route('nosotros')}}#mision">
                        <p data-translate="mision"></p>
                    </a>
                    <a href=" {{ route('nosotros')}}#vision">
                        <p data-translate="vision"></p>
                    </a>
                    <a href="{{ route('nosotros')}}#team">
                        <p data-translate="desarrolladores"></p>
                    </a>
                </div>
                <div class="box">
                    <h1 data-translate="preguntas"></h1>
                    <a href=" {{ route('preguntas')}}">
                        <p data-translate="preguntas_frecuentes"></p>
                    </a>
                </div>
            </div>

        </div>
        <div class="container-redes">
            <a href="https://www.facebook.com/profile.php?id=61586980560794&mibextid=wwXIfr&rdid=OkA2uwwur1Hu9lOu&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F12MTC15CJAi%2F%3Fmibextid%3DwwXIfr#" target="_blank">
                <div class="circle-icon-f">
                    <img src="{{ asset('images/facebook.png')}}" alt="Facebook Link" class="icon-img">
                </div>
            </a>
            <a href="https://www.instagram.com/classgo_app/" target="_blank">
                <div class="circle-icon-i">
                    <img src="{{ asset('images/instagram.png')}}" alt="Instagram link" class="icon-img">
                </div>
            </a>
            <a href="https://www.tiktok.com/@classgoapp" target="_blank">
                <div class="circle-icon-t">
                    <img src="{{ asset('images/tik-tok.png')}}" alt="TikTok link" class="icon-img">
                </div>
            </a>
            <a href="http://www.youtube.com/@ClassGo-z4d" target="_blank">
                <div class="circle-icon-y">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube link" class="icon-img">
                </div>
            </a>
            <a href="https://www.linkedin.com/company/classgoapp/about/?viewAsMember=true" target="_blank">
                <div class="circle-icon-l">
                    <img src="{{ asset('images/linkedin.png') }}" alt="linkedind link" class="icon-img">
                </div>
            </a>
        </div>
        <hr>
        <p class="derechos-reservados">© 2025 classgobol. <span data-translate="todos_derechos"></span></p>

    </div>
</footer>