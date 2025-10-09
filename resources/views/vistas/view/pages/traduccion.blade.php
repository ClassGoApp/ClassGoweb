<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traducción Persistente</title>
</head>

<body>
    <section class="hero">
        <div class="hero-container">
            <!-- 1.1 Hero Titular -->
            <div class="hero-text">
                <h1 class="hero-title-arriba" id="titulo-arriba">Aprende y Progresa con</h1>
                <h1 class="hero-title-abajo" id="titulo-abajo">Tutorías en Línea</h1>
                <p class="hero-subtext" id="subtext">
                    Alcanza tus metas con tutorías personalizadas de los mejores expertos.<br>
                    Conéctate con tutores dedicados para asegurar tu éxito.
                </p>
                <p class="hero-subtext mobile" id="subtext-mobile">
                    Conéctate con tutores dedicados para asegurar tu éxito.
                </p>
            </div>
        </div>

        <div>
            <label for="idioma">Selecciona idioma:</label>
            <select id="idioma" onchange="cambiarIdioma(this.value)">
                <option value="es">Español</option>
                <option value="en">Inglés</option>
                <option value="pt">Português</option>
            </select>
        </div>
    </section>

    <script>
        const textos = {
            es: {
                arriba: "Aprende y Progresa con",
                abajo: "Tutorías en Línea",
                sub: "Alcanza tus metas con tutorías personalizadas de los mejores expertos.<br>Conéctate con tutores dedicados para asegurar tu éxito.",
                mobile: "Conéctate con tutores dedicados para asegurar tu éxito."
            },
            en: {
                arriba: "Learn and Progress with",
                abajo: "Online Tutoring",
                sub: "Achieve your goals with personalized tutoring from top experts.<br>Connect with dedicated tutors to ensure your success.",
                mobile: "Connect with dedicated tutors to ensure your success."
            },
            pt: {
                arriba: "Aprenda e Progrida com",
                abajo: "Aulas Online",
                sub: "Alcance seus objetivos com aulas personalizadas dos melhores especialistas.<br>Conecte-se com tutores dedicados para garantir seu sucesso.",
                mobile: "Conecte-se com tutores dedicados para garantir seu sucesso."
            }
        };

        function traducir(idioma) {
            document.getElementById("titulo-arriba").innerHTML = textos[idioma].arriba;
            document.getElementById("titulo-abajo").innerHTML = textos[idioma].abajo;
            document.getElementById("subtext").innerHTML = textos[idioma].sub;
            document.getElementById("subtext-mobile").innerHTML = textos[idioma].mobile;
        }

        function cambiarIdioma(idioma) {
            localStorage.setItem("idiomaSeleccionado", idioma); // 🔹 Guardar idioma
            traducir(idioma);
        }

        window.onload = function() {
            let idiomaGuardado = localStorage.getItem("idiomaSeleccionado");

            if (!idiomaGuardado) {
                // Si no hay idioma guardado, usa el del navegador
                idiomaGuardado = (navigator.language || navigator.userLanguage).substring(0, 2);
                if (!["es", "en", "pt"].includes(idiomaGuardado)) idiomaGuardado = "es";
            }

            document.getElementById("idioma").value = idiomaGuardado;
            traducir(idiomaGuardado);
        };
    </script>
</body>

</html>