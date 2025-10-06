@extends('vistas.view.layouts.app')
@section('content')
<section class="terminos">
    <div class="terminos-container">
        <div class="terminos-header">
            <div class="terminos-header-content">
                <div class="terminos-header-text">
                    <h1 data-translate="terminos_y_condiciones">TÉRMINOS Y CONDICIONES DE USO DE CLASSGO</h1>
                    <h2 class="terminos-subtitulos" data-translate="fecha_actualizacion">Fecha de última actualización: 02/07/2025</h2>
                </div>
                <div>
                    <img src="{{ asset('images/home/TuGoconMegafono.webp') }}"
                        alt="Misión ClassGo" class="tugo-image">
                </div>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="introduccion">1. Introducion</h1>
            <h2 class="terminos-subtitulos" data-translate="bienvenida">Bienvenido a ClassGo "la Plataforma", un servicio administrado por ClassGO S.R.L. Al
                registrarte o utilizar nuestros servicios, aceptas cumplir legalmente con los presentes Términos
                y Condiciones "T & C". Si no estás de acuerdo, por favor abstente de utilizar la plataforma.
            </h2>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="cuentas_usuario">2. CUENTAS DE USUARIO</h1>
            <div class="terminos-mont-text">
                <h2 class="terminos-subtitulos" data-translate="registro_verificacion">2.1 Registro y Verificación</h2>
                <h2 class="terminos-subtitulos" data-translate="info_personal">Todos los usuarios que deseen acceder a los servicios de ClassGo deben completar el proceso
                    de registro proporcionando información personal precisa y actualizada.
                </h2>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="subapartado_estudiantes">Subapartado Estudiantes</h2>
                    <ul>
                        <li data-translate="nombre_correo_fecha_pais">Nombre completo, correo electrónico, fecha de nacimiento y país de residencia.</li>
                        <li data-translate="aceptar_politica">Se debe aceptar expresamente la Política de Privacidad y los presentes Términos.</li>
                    </ul>
                </div>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="subapartado_tutores">Subapartado Tutores</h2>
                    <ul>
                        <li data-translate="doc_academica">Además de los datos mencionados, deberán presentar documentación académica que
                            acredite su idoneidad (título universitario, certificados, especializaciones, etc.).</li>
                        <li data-translate="entrevistas_referencias">ClassGo podrá solicitar entrevistas, validaciones adicionales o referencias para la
                            verificación del perfil.</li>
                    </ul>
                </div>
            </div>
            <div class="terminos-mont-text">
                <h2 class="terminos-subtitulos" data-translate="veracidad_actualizacion">2.2 Vereacidad y Actualizacion de Datos</h2>
                <ul class="terminos-ul">
                    <li data-translate="usuario_responsable_mantener">El usuario es responsable de mantener sus datos personales y académicos actualizados
                        en todo momento.</li>
                    <li data-translate="classgo_derecho_suspender">ClassGo se reserva el derecho de suspender cuentas con información incorrecta,
                        desactualizada o fraudulenta.</li>
                </ul>
            </div>
            <div class="terminos-mont-text">
                <h2 class="terminos-subtitulos" data-translate="seguridad_responsabilidad_cuenta">2.3 Seguridad y Responsabilidad de la Cuenta</h2>
                <ul class="terminos-ul">
                    <li data-translate="confidencialidad_credenciales">Es responsabilidad del usuario mantener la confidencialidad de sus credenciales
                        (correo y contraseña).</li>
                    <li data-translate="no_compartir_cuentas">No se permite compartir cuentas entre personas.</li>
                    <li data-translate="notificar_actividades_sospechosas">El usuario deberá notificar de inmediato cualquier actividad sospechosa o uso no
                        autorizado al correo de soporte.</li>
                </ul>
                <P data-translate="classgo_no_responsable">ClassGo no será responsable de accesos no autorizados causados por negligencia del usuario.</P><!--sugiero ponerlo en negrita para que se resalte mas-->
            </div>
            <div class="terminos-mont-text">
                <h2 class="terminos-subtitulos" data-translate="edad_minima">2.4 Edad Mínima</h2>
                <ul class="terminos-ul">
                    <li data-translate="usuarios_mayores_18">Pueden registrarse usuarios mayores de 18 años.</li>
                    <li data-translate="menores_con_autorizacion">Menores de edad pueden hacerlo con consentimiento escrito de un padre o tutor,
                        enviado al correo <a href="#" class="email-link">classgobol@gmail.com</a> <span data-translate="menores_con_autorizacion_2">y con supervisión permanente del adulto
                            responsable.</span></li>
                </ul>
            </div>
            <div class="terminos-mont-text">
                <h2 class="terminos-subtitulos" data-translate="suspensiones">2.5 Suspensión y Terminación de Cuentas</h2>
                <p data-translate="classgo_derecho_suspender_temporal">ClassGo se reserva el derecho de suspender temporal o permanentemente una cuenta en caso
                    de:</p>
                <ul class="terminos-ul">
                    <li data-translate="incumplimiento_tyc">Incumplimiento de los presentes Términos y Condiciones.</li>
                    <li data-translate="actividades_sospechosas">Actividades sospechosas, abusivas o ilegales.</li>
                    <li data-translate="reportes_mala_conducta">Reportes reiterados de mala conducta por parte de otros usuarios.</li>
                </ul>
                <p data-translate="decision_notificada_correo">La decisión será notificada por correo electrónico y podrá incluir restricciones de acceso,
                    eliminación de contenido o terminación definitiva del perfil.</p>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="politicas_uso">3. POLÍTICAS DE USO</h1>
            <div class="defect">
                <h2 class="terminos-subtitulos" data-translate="uso_aceptable">3.1 Uso Aceptable de la Plataforma</h2>
                <p data-translate="uso_clasgo_estricto">El uso de ClassGo debe estar estrictamente orientado a fines educativos.
                    Queda terminantemente prohibido:</p>
                <ul class="terminos-ul">
                    <li data-translate="actividades_ilicitas">Utilizar la plataforma para actividades ilícitas, engañosas o contrarias al orden público.</li>
                    <li data-translate="spam_phishing">Realizar spam, phishing, fraudes, envío masivo de mensajes o actividades similares.</li>
                    <li data-translate="uso_cuenta_beneficios_economicos">Usar la cuenta para obtener beneficios económicos externos a ClassGo sin autorización.</li>
                    <li data-translate="manipular_sistema">Manipular el sistema con software malicioso, bots, técnicas de scraping o ingeniería inversa.</li>
                    <li data-translate="suplantar_identidad">Suplantar identidades de personas o instituciones.</li>
                </ul>
                <p data-translate="classgo_reserva_derecho">ClassGo se reserva el derecho de investigar, bloquear o eliminar cualquier cuenta que infrinja
                    esta política.</p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="interaccion_usuarios">3.2 Interacción entre Usuarios</h2>
                <p data-translate="conducta_respetuosa">Todos los usuarios deben mantener una conducta respetuosa, cordial y profesional.
                    Se prohíbe:</p>
                <ul class="terminos-ul">
                    <li data-translate="lenguaje_ofensivo">El uso de lenguaje ofensivo, discriminatorio, difamatorio o violento.</li>
                    <li data-translate="acoso_intimidacion">El acoso, intimidación o manipulación psicológica hacia cualquier otro usuario.</li>
                    <li data-translate="contacto_no_deseado">El contacto no deseado fuera de la plataforma con fines personales o comerciales.</li>
                </ul>
                <p data-translate="reportes_de_comportamiento">Los reportes de comportamiento inapropiado serán investigados y pueden derivar en
                    sanciones, suspensión o eliminación de la cuenta</p>
            </div>
            <div class="defect">
                <h2 class="terminos-subtitulos" data-translate="uso_contenido_propiedad_intelectual">3.3 Uso de Contenido y Propiedad Intelectual</h2>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="imagenes_perfil">Imágenes de perfil:</h2>
                    <ul>
                        <li data-translate="aceptar_jpg_png">Solo se aceptan archivos JPG o PNG de máximo 5 MB.</li>
                        <li data-translate="prohibido_armas_sexual">Se prohíben imágenes con armas, contenido sexualizado o protegidas por derechos sin
                            permiso.</li>
                    </ul>
                </div>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="material_educativo_tutores">Material educativo (de tutores):</h2>
                    <ul>
                        <li data-translate="contenido_original">Los tutores deben subir solo contenido original o bajo licencia de uso
                            (por ejemplo, Creative Commons).</li>
                        <li data-translate="citar_fuentes">Si se utilizan recursos externos, deben citarse correctamente las fuentes.</li>
                    </ul>
                </div>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="derechos_classgo">Derechos de ClassGo:</h2>
                    <ul>
                        <li data-translate="propiedad_exclusiva">El diseño, marca, logotipos, software y estructura de la plataforma son propiedad
                            exclusiva de ClassGo.</li>
                    </ul>
                </div>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="licencia_uso_contenido">3.4 Licencia de Uso del Contenido Subido por el Usuario</h2>
                <p data-translate="licencia_explica">Al subir contenido a la plataforma, el usuario (ya sea tutor o estudiante) conserva la titularidad
                    y derechos de autor sobre dicho material, pero otorga a ClassGo una licencia no exclusiva,
                    mundial, libre de regalías, transferible y sublicenciable para utilizar dicho contenido con los
                    siguientes fines:</p>
                <ul class="terminos-ul">
                    <li data-translate="almacenamiento_seguro">Almacenamiento seguro en los servidores y bases de datos de ClassGo.</li>
                    <li data-translate="visualizacion_reproduccion">Visualización y reproducción del contenido dentro del entorno educativo digital de la
                        plataforma (incluyendo aplicaciones móviles, sitio web, materiales promocionales
                        internos y recursos para estudiantes).</li>
                    <li data-translate="distribucion_limitada">Distribución limitada del contenido a otros usuarios registrados (por ejemplo,
                        estudiantes en una sesión, tutores asignados, etc.) en función del propósito educativo
                        del servicio.</li>
                    <li data-translate="adaptacion_tecnica">Adaptación técnica del contenido, en caso de que sea necesario modificar el formato
                        para asegurar su compatibilidad técnica con los sistemas de la plataforma (por
                        ejemplo, convertir archivos a otros formatos, optimizar resolución, etc.).</li>
                </ul>
                <h2 class="terminos-subtitulos" data-translate="condiciones_revocacion">Condiciones de revocación:</h2>
                <p data-translate="revocar_contenido">El usuario puede revocar esta licencia eliminando su contenido de la plataforma, excepto
                    cuando:</p>
                <ul class="terminos-ul">
                    <li data-translate="contenido_compartido">Ya haya sido compartido con otros usuarios durante el uso legítimo del servicio.</li>
                    <li data-translate="obligacion_legal">Existe una obligación legal o administrativa que impida la eliminación inmediata del
                        contenido (por ejemplo, en casos de auditoría o disputas).</li>
                </ul>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos " data-translate="pagos_reembolsos_reprogramaciones">4. PAGOS, REEMBOLSOS Y REPROGRAMACIONES</h1>
            <div>
                <h2 class="terminos-subtitulos" data-translate="metodos_pago">4.1 Métodos de Pago</h2>
                <p data-translate="aceptamos_metodos">Aceptamos:</p>
                <ul class="terminos-ul">
                    <li data-translate="tarjetas_debito_credito">Tarjetas de débito/crédito (Visa, Mastercard)</li>
                    <li>PayPal</li>
                    <!--[otros especificar: Stripe, Razor Pay, etc.] ??-->
                </ul>
                <p data-translate="recibo_transaccion">Cada transacción generará un recibo electrónico.</p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="politica_reembolsos">4.2 Política de Reembolsos</h2>
                <div class="terminos-ul">
                    <h2 data-translate="casos_reembolso">Casos en los que aplica el reembolso:</h2>
                    <ul>
                        <li data-translate="cancelacion_tutor">Cancelación por parte del tutor</li>
                        <li data-translate="fallos_tecnicos">Fallos técnicos atribuibles a ClassGo (ejemplo: caída del sistema superior a 15 minutos)</li>
                    </ul>
                </div>
                <div class="terminos-ul">
                    <h2 class="terminos-subtitulos" data-translate="condiciones_solicitar_reembolso">Condiciones para solicitar reembolso:</h2>
                    <ul>
                        <li data-translate="solicitud_48h">La solicitud debe realizarse dentro de las 48 horas naturales posteriores al incidente.</li>
                        <li data-translate="procesamiento_48h">El procesamiento del reembolso se realizará en un plazo de 48 horas hábiles.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="cancelaciones_reprogramaciones">5. CANCELACIONES Y REPROGRAMACIONES</h1>
            <h2 class="terminos-subtitulos" data-translate="politicas_cancelacion_reprogramacion">ClassGo establece políticas claras de cancelación y reprogramación que aplican tanto para
                usuarios como para tutores, con el objetivo de garantizar el respeto por el tiempo de ambas
                partes, mantener la calidad del servicio y preservar la operatividad de la plataforma.</h2>
            <div>
                <h2 class="terminos-subtitulos" data-translate="cancelaciones_usuario">5.1 Cancelaciones por parte del Usuario</h2>
                <p data-translate="condiciones_cancelacion_usuario">Condiciones:</p>
                <ul class="terminos-ul">
                    <li data-translate="usuario_24h_anticipacion">Con más de 24 horas de anticipación:
                        El usuario podrá cancelar o reprogramar sin penalización. Si corresponde, se podrá
                        solicitar el reembolso total del valor de la sesión o reprogramar sin costo adicional.
                    </li>
                    <li data-translate="usuario_menos_24h">Con menos de 24 horas de anticipación:
                        La cancelación podrá estar sujeta a una penalización del 50% del valor de la sesión, la
                        cual se aplicará como compensación al tutor por el tiempo reservado.
                    </li>
                    <li data-translate="usuario_no_show">Ausencia injustificada del usuario (no show):
                        Si el usuario no asiste a la sesión sin aviso previo, se considerará como sesión realizada
                        y no se otorgará reembolso. El tutor recibirá el pago correspondiente.
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="cancelaciones_tutor">5.2 Cancelaciones por parte del Tutor</h2>
                <p data-translate="condiciones_cancelacion_tutor">Condiciones:</p>
                <ul class="terminos-ul">
                    <li data-translate="tutor_12h_aviso">Cancelación con aviso previo (mínimo 12 horas):
                        El tutor deberá ofrecer al usuario opciones para reprogramar. No se aplicarán
                        sanciones si es un evento ocasional y debidamente justificado.
                    </li>
                    <li data-translate="tutor_frecuentes_injustificadas">Cancelaciones frecuentes o injustificadas:
                        Si un tutor realiza más de tres cancelaciones injustificadas en un mes, podrá recibir
                        sanciones progresivas como advertencias, suspensión temporal o eliminación del
                        perfil.
                    </li>
                    <li data-translate="tutor_no_show">Ausencia del tutor sin aviso (no show):
                        Se considerará una falta grave. El estudiante recibirá un reembolso total, y el tutor
                        podrá ser sancionado con suspensión inmediata de la cuenta o expulsión de la
                        plataforma.
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="reprogramaciones">5.3 Reprogramaciones</h2>
                <p data-translate="condiciones_reprogramacion">Tanto estudiantes como tutores pueden programar una sesión siempre que:</p>
                <ul class="terminos-ul">
                    <li data-translate="reprogramacion_24h">La solicitud se realice con al menos 24 horas de anticipación.</li>
                    <li data-translate="acuerdo_nuevo_horario">Ambas partes hayan llegado a un acuerdo sobre el nuevo horario.</li>
                    <li data-translate="no_acuerdo_cancelacion">En caso de no llegar a un acuerdo, la sesión podrá ser cancelada aplicando la política
                        correspondiente.</li>
                </ul>

            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="resolucion_disputas">5.4 Resolución de Disputas</h2>
                <p data-translate="desacuerdo_tutor_usuario">En caso de desacuerdo entre un tutor y un usuario respecto a una cancelación o
                    reprogramación:</p>
                <ul class="terminos-ul">
                    <li data-translate="presentar_argumentos_soporte">Las partes podrán presentar sus argumentos al equipo de soporte de ClassGo.</li>
                    <li data-translate="classgo_mediador">ClassGo actuará como mediador e implementará la solución más equitativa para
                        ambas partes.</li>
                    <li data-translate="decision_final">La decisión tomada será final, salvo disposición legal en contrario.</li>
                </ul>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="responsabilidades">6. RESPONSABILIDADES</h1>
            <h2 class="terminos-subtitulos" data-translate="uso_responsable_plataforma">
                El uso adecuado de la plataforma ClassGo implica un compromiso por parte de todos los
                usuarios para actuar con responsabilidad, ética y profesionalismo. Las siguientes disposiciones
                detallan las obligaciones específicas de tutores y estudiantes.
            </h2>
            <div>
                <h2 class="terminos-subtitulos" data-translate="responsabilidades_tutor">6.1 Responsabilidades del Tutor</h2>
                <ol type="a" class="terminos-ul">
                    <li data-translate="veracidad_perfil">Veracidad del perfil profesional</li>
                    <ul class="terminos-ul">
                        <li data-translate="informacion_academica_actualizada">Ingresar y mantener actualizada la información académica y profesional.</li>
                        <li data-translate="documentacion_veridica">Proveer documentación verídica que acredite su formación y experiencia.</li>
                        <li data-translate="no_suplantar_identidad">No suplantar identidades ni presentar credenciales falsificadas.</li>
                    </ul>
                    <li data-translate="calidad_servicio">Calidad del servicio educativo</li>
                    <ul class="terminos-ul">
                        <li data-translate="preparar_brindar_tutorias">Preparar y brindar tutorías con puntualidad, claridad y estructura.</li>
                        <li data-translate="usar_recursos_adecuados">Utilizar recursos pedagógicos adecuados y actualizados.</li>
                        <li data-translate="evitar_contenido_erroneo">Evitar contenido erróneo, obsoleto o no relevante para el aprendizaje del estudiante.</li>
                    </ul>
                    <li data-translate="etica_profesional_trato">Ética profesional y trato respetuoso</li>
                    <ul class="terminos-ul">
                        <li data-translate="mantener_conducta_profesional">Mantener una conducta profesional durante todas las interacciones.</li>
                        <li data-translate="evitar_comentarios_ofensivos">Evitar comentarios ofensivos, discriminatorios, sexistas, racistas o de índole personal.</li>
                        <li data-translate="no_relaciones_inapropiadas">No establecer relaciones personales inapropiadas con los estudiantes.</li>
                    </ul>
                    <li data-translate="uso_contenido">Uso del contenido</li>
                    <ul class="terminos-ul">
                        <li data-translate="material_autoria_propia">Garantizar que el material compartido es de autoría propia o cuenta con licencia de uso.</li>
                        <li data-translate="no_usar_contenido_otro">No utilizar recursos de otros tutores sin autorización explícita.</li>
                        <li data-translate="autorizar_classgo">Autorizar a ClassGo para mostrar y almacenar el contenido dentro del entorno educativo de la plataforma.</li>
                    </ul>
                    <li data-translate="confidencialidad">Confidencialidad</li>
                    <ul class="terminos-ul">
                        <li data-translate="respetar_privacidad_estudiantes">Respetar la privacidad y datos personales de los estudiantes.</li>
                        <li data-translate="no_divulgar_informacion">No divulgar conversaciones, grabaciones ni información obtenida durante las sesiones sin consentimiento.</li>
                    </ul>
                    <li data-translate="cumplimiento_legal">Cumplimiento legal</li>
                    <ul class="terminos-ul">
                        <li data-translate="actividad_cumple_normativa">Asegurarse de que su actividad como tutor cumple con la normativa educativa y laboral vigente en su país de residencia.</li>
                    </ul>
                    <li data-translate="responsabilidad_ausencias">Responsabilidad ante ausencias o cancelaciones</li>
                    <ul class="terminos-ul">
                        <li data-translate="notificar_cancelaciones">Notificar cancelaciones con la mayor antelación posible.</li>
                        <li data-translate="evitar_cancelaciones_reiteradas">Evitar cancelaciones reiteradas o ausencias injustificadas, las cuales pueden derivar en sanciones por parte de la plataforma.</li>
                    </ul>
                </ol>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="responsabilidades_estudiante">6.2 Responsabilidades del Estudiante</h2>
                <h2 class="terminos-subtitulos" data-translate="estudiantes_compromiso">Los estudiantes que utilizan ClassGo deben comprometerse a:</h2>
                <ol type="a" class="terminos-ul">
                    <li data-translate="participacion_puntualidad">Participación activa y puntualidad</li>
                    <ul class="terminos-ul">
                        <li data-translate="asistir_sesiones">Asistir a las sesiones en el horario acordado.</li>
                        <li data-translate="actitud_participativa">Mantener una actitud participativa, receptiva y orientada al aprendizaje.</li>
                    </ul>
                    <li data-translate="respeto_tutor_entorno">Respeto hacia el tutor y el entorno virtual</li>
                    <ul class="terminos-ul">
                        <li data-translate="respetar_tutores">Tratar con respeto a los tutores, evitando cualquier conducta abusiva, ofensiva o disruptiva.</li>
                        <li data-translate="no_grabar_sin_autorizacion">No grabar ni compartir sesiones sin autorización previa.</li>
                    </ul>
                    <li data-translate="uso_responsable_plataforma_estudiante">Uso responsable de la plataforma</li>
                    <ul class="terminos-ul">
                        <li data-translate="no_fines_personales">No utilizar ClassGo para fines distintos al aprendizaje (por ejemplo, fines comerciales o personales).</li>
                        <li data-translate="no_compartir_terceros">No compartir acceso con terceros ni hacer uso indebido de las funcionalidades del sistema.</li>
                    </ul>
                    <li data-translate="pago_sesiones">Pago oportuno de las sesiones</li>
                    <ul class="terminos-ul">
                        <li data-translate="pago_autorizado_plazo">Asegurarse de que los pagos se realicen a través de los métodos autorizados y en los plazos establecidos.</li>
                        <li data-translate="no_reclamaciones_indebidas">No realizar reclamaciones indebidas por sesiones recibidas correctamente.</li>
                    </ul>
                    <li data-translate="evaluacion_tutor">Evaluación objetiva del tutor</li>
                    <ul class="terminos-ul">
                        <li data-translate="calificar_desempeno_72h">Calificar de manera justa y constructiva el desempeño de los tutores al finalizar las sesiones, dentro del plazo de 72 horas.</li>
                    </ul>
                    <li data-translate="proteccion_datos_privacidad">Protección de datos y privacidad</li>
                    <ul class="terminos-ul">
                        <li data-translate="no_divulgar_datos">No divulgar datos personales de otros usuarios.</li>
                        <li data-translate="cumplir_politicas_privacidad">Cumplir con las políticas de privacidad establecidas por ClassGo.</li>
                    </ul>
                </ol>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="certificacion_tutores">6.3 Certificación de Tutores ClassGo</h2>
                <p data-translate="detalle_certificacion_tutores">Para obtener la certificación oficial como Tutor ClassGo, los usuarios registrados como tutores
                    deberán completar satisfactoriamente el Programa de Formación Pedagógica de ClassGo, que
                    consta de 18 cursos pedagógicos disponibles en la plataforma.
                    Esta certificación es un requisito indispensable para acceder a beneficios especiales, convenios
                    con instituciones y participar en programas de tutoría promocionados por ClassGo.
                </p>

            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="convenios_beneficios">6.4 Convenios Académicos y Beneficios</h2>
                <p data-translate="detalle_convenios_beneficios">ClassGo mantiene convenios con unidades de posgrado y otras instituciones educativas, los
                    cuales pueden otorgar descuentos, accesos preferenciales o beneficios especiales a usuarios
                    que cumplan con los requisitos establecidos en cada acuerdo.
                    El cumplimiento de estos beneficios está sujeto a la verificación de requisitos específicos,
                    como el avance en el plan formativo de la plataforma o la validación de identidad.
                </p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="gestion_quejas_validacion">6.5 Gestión de Quejas y Validación de Clases</h2>
                <p data-translate="detalle_gestion_quejas">En caso de que un usuario experimente inconveniente durante una tutoría (por ejemplo,
                    ausencia del tutor, fallos graves en la clase o incumplimientos de calidad), podrá presentar una
                    queja dentro de los primeros 2 a 3 minutos posteriores a la finalización de la sesión.
                    Si no se registra ninguna queja durante este periodo, elsistema procesará automáticamente el
                    pago correspondiente al tutor.
                    Todas las quejas recibidas serán evaluadas por el equipo de soporte de ClassGo, quien actuará
                    como mediador para resolver la situación de manera justa, pudiendo aplicar reembolsos,
                    retenciones o sanciones según corresponda.
                </p>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="limitacion_responsabilidad">7. LIMITACIÓN DE RESPONSABILIDAD</h1>
            <h2 class="terminos-subtitulos" data-translate="classgo_no_responsable_por">ClassGo no será responsable por:</h2>
            <div class="terminos-ul">
                <ul>
                    <li data-translate="danos_indirectos">Daños indirectos, incluyendo pérdida de oportunidades laborales.</li>
                    <li data-translate="conflictos_usuarios_tutores">Conflictos entre usuarios y tutores.</li>
                    <li data-translate="problemas_tecnicos_ajenos">Problemas técnicos ajenos a la plataforma (por ejemplo, fallos del proveedor de
                        internet del usuario).</li>
                </ul>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="modificaciones_terminos">8. MODIFICACIONES A LOS TÉRMINOS</h1>
            <div class="terminos-ul">
                <ul>
                    <li data-translate="modificacion_avisada">Cualquier modificación será comunicada con al menos 15 días de anticipación
                        mediante correo electrónico.</li>
                    <li data-translate="aceptacion_continuada">El uso continuado de la plataforma implica la aceptación de los nuevos términos.
                    </li>
                </ul>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="contacto_soporte">9. CONTACTO Y SOPORTE</h1>
            <div class="terminos-ul">
                <ul>
                    <li><span data-translate="soporte_tecnico">Soporte técnico: </span><a href="#" class="email-link">classgobol@gmail.com</a></li>
                    <li data-translate="reclamos_formales">Reclamos formales: enviar documentación física a:<br>
                        CALLE ANGOSTURA, NRO: 314<br>
                        BARRIO EL PARI, UV: 28 MZA 12<br>
                        ENTRE LA CALLE EMILIO FINOT Y LA AVENIDA ESCUADRON VELASCO<br>
                    </li>
                    <li data-translate="contactanos_whatsapp">
                        Contáctanos al: <br>
                        <button class="whatsapp-btn">
                            <img src="{{ asset('images/whatsapp.png') }}" alt="WhatsApp" class="whatsapp-icon">
                            Whatsapp
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="jurisdiccion_resolucion_conflictos">10. JURISDICCIÓN Y RESOLUCIÓN DE CONFLICTOS</h1>
            <p data-translate="acuerdo_legislacion_bolivia">Este acuerdo se rige por la legislación vigente en el Estado Plurinacional de Bolivia, incluyendo
                las disposiciones aplicables del Código Civil, la Ley de Protección al Consumidor y demás
                normas relacionadas con servicios digitales y relaciones contractuales electrónicas.</p>
            <div>
                <h2 class="terminos-subtitulos" data-translate="mecanismo_conciliacion_arbitraje">10.1 Mecanismo preferente: conciliación o arbitraje</h2>
                <p data-translate="resolucion_amistosa">Se intentará resolver la controversia de forma amistosa mediante conciliación voluntaria o
                    arbitraje institucional, de conformidad con lo establecido en la normativa boliviana y bajo los
                    reglamentos del Centro de Conciliación y Arbitraje de la Cámara de Comercio y Servicios de
                    Santa Cruz (CAINCO), u otra entidad reconocida acordada por ambas partes.</p>
                <div class="terminos-ul">
                    <ul>
                        <li data-translate="procedimiento_confidencial">El procedimiento será confidencial, rápido y con carácter vinculante.</li>
                        <li data-translate="inicio_proceso_solicitud">La parte interesada deberá iniciar el proceso enviando una solicitud formal al centro correspondiente.</li>
                        <li data-translate="acatar_decision_tribunal">Ambas partes se comprometen a acatar la decisión emitida por el tribunal arbitral o conciliador.</li>
                    </ul>
                </div>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="instancia_judicial_subsidiaria">10.2 Instancia judicial subsidiaria</h2>
                <p data-translate="jurisdiccion_ordinaria">Si no se logra acuerdo en conciliación o si el arbitraje no puede llevarse a cabo por causas
                    atribuibles a una de las partes o por disposición legal, las partes se someten a la jurisdicción
                    ordinaria de los tribunales competentes de la ciudad de Santa Cruz de la Sierra, renunciando
                    expresamente a cualquier otro fuero o jurisdicción que pudiera corresponderles.</p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="renuncia_accion_colectiva">10.3 Renuncia a acción colectiva</h2>
                <p data-translate="accion_individual">Los usuarios aceptan que cualquier acción legal deberá ser interpuesta de manera individual.
                    No se permite la acumulación de demandas en calidad de acción colectiva o grupal contra
                    ClassGo, salvo que lo exija expresamente una autoridad judicial competente.
                </p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="idioma_legislacion_aplicable">10.4 Idioma y legislación aplicable</h2>
                <p data-translate="procedimiento_idioma_espanol">Todo procedimiento, ya sea conciliatorio, arbitral o judicial, se desarrollará en idioma español
                    y conforme a las leyes sustantivas y procesales del Estado Plurinacional de Bolivia.
                    Nota final de la cláusula:
                    En caso de no lograrse una solución mediante estos medios, las partes se someten a la
                    jurisdicción de los tribunales competentes de la ciudad de Santa Cruz, Bolivia.
                </p>
            </div>
        </div>
        <div class="terminos-generic">
            <h1 class="terminos-titulos" data-translate="uso_internacional">11. USO INTERNACIONAL</h1>
            <p data-translate="descripcion_uso_internacional">ClassGo es una plataforma desarrollada y operada conforme a las leyes del Estado
                Plurinacional de Bolivia. No obstante, está disponible para usuarios en otros países, sujeto a
                las siguientes condiciones:</p>
            <div>
                <h2 class="terminos-subtitulos" data-translate="responsabilidad_usuario_internacional">11.1 Responsabilidad del usuario internacional</h2>
                <p data-translate="usuario_responsable_exterior">Si accedes o utilizas ClassGo desde fuera de Bolivia, lo haces bajo tu propia iniciativa y
                    responsabilidad.
                    Eres el único responsable de asegurar que el uso de los servicios, contenidos y funciones de la
                    plataforma cumpla con las leyes, normativas y regulaciones locales del país desde el cual
                    accedes. Esto incluye, pero no se limita a:
                </p>
                <div class="terminos-ul">
                    <ul>
                        <li data-translate="normativas_educacion_linea">Normativas sobre educación en línea</li>
                        <li data-translate="proteccion_datos">Protección de datos</li>
                        <li data-translate="comercio_electronico">Comercio electrónico</li>
                        <li data-translate="propiedad_intelectual">Propiedad intelectual</li>
                        <li data-translate="tributacion_digital">Tributación digital</li>
                    </ul>
                </div>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="limitaciones_disponibilidad_servicios">11.2 Limitaciones de disponibilidad de servicios</h2>
                <p data-translate="restricciones_servicios">Algunos servicios, características o métodos de pago pueden estar restringidos o no
                    disponibles en ciertos territorios debido a:</p>
                <div class="terminos-ul">
                    <ul>
                        <li data-translate="restricciones_legales_locales">Restricciones legales locales</li>
                        <li data-translate="normativas_exportacion">Normativas de exportación o control de servicios tecnológicos</li>
                        <li data-translate="incompatibilidad_tecnica">Incompatibilidad técnica con sistemas de pago o redes educativas externas</li>
                        <li data-translate="politicas_internas_classgo">Políticas internas de ClassGo para evitar incumplimientos regulatorios</li>
                    </ul>
                </div>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="en_tales_casos">11.3 En tales casos</h2>
                <p data-translate="responsabilidad_limitada">ClassGo no será responsable por la imposibilidad de acceso total o parcial a determinadas
                    funciones, siempre que estas restricciones estén justificadas por motivos legales o técnicos.</p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="idioma_soporte">11.4 Idioma y soporte</h2>
                <p data-translate="interfaz_documentacion_soporte">Toda la interfaz, documentación legal, soporte técnico y comunicaciones oficiales se
                    encuentran disponibles únicamente en idioma español.
                    Los usuarios que accedan desde otros países aceptan utilizar la plataforma bajo esta
                    modalidad lingüística.
                </p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="jurisdiccion_disputas_internacionales">11.5 Jurisdicción y disputas internacionales</h2>
                <p data-translate="disputas_internacionales">A pesar del uso internacional, cualquier disputa relacionada con la plataforma se regirá por la
                    legislación boliviana y se someterá a los mecanismos de resolución de conflictos establecidos
                    en la cláusula 10 de estos Términos y Condiciones.</p>
            </div>
            <div>
                <h2 class="terminos-subtitulos" data-translate="cumplimiento_normativo_global">11.6 Cumplimiento normativo global</h2>
                <p data-translate="derecho_restricciones_cuentas">ClassGo se reserva el derecho de restringir, suspender o cancelar cuentas de usuarios que,
                    residiendo en el extranjero:</p>
                <div class="terminos-ul">
                    <ul>
                        <li data-translate="infrinjan_leyes_locales">Infrinjan leyes locales</li>
                        <li data-translate="riesgo_cumplimiento_normativo">Pongan en riesgo el cumplimiento normativo de la plataforma</li>
                    </ul>
                </div>
                <p data-translate="reservarse_derecho_no_operar">Asimismo, nos reservamos el derecho de no operar en países con los que existan:</p>
                <div>
                    <ul>
                        <li data-translate="barreras_regulatorias_insalvables">Barreras regulatorias insalvables</li>
                        <li data-translate="conflictos_legales_viabilidad">Conflictos legales que afecten la viabilidad del servicio</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="terminos-generic">
            <div class="terminos-descarga">
                <p class="terminos-descarga-texto" data-translate="descarga_terminos_pdf">Descarga términos y condiciones en PDF</p>
                <a href="/terminos.pdf" download>
                    <button class="terminos-descarga-boton">
                        <span data-translate="boton_descargar_pdf">Descargar PDF</span>
                    </button>
                </a>
            </div>
        </div>
    </div>

</section>

<script>
    // Seleccionamos todos los elementos con la clase 'email-link'
    document.querySelectorAll(".email-link").forEach(function(link) {
        link.addEventListener("click", function(e) {
            e.preventDefault(); // Evita la acción por defecto
            const email = "classgobol@gmail.com"; // Siempre el mismo correo

            // URL para abrir Gmail
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}`;

            // Intentamos abrir Gmail en una nueva pestaña
            const newWindow = window.open(gmailUrl, "_blank");

            // Si la ventana no se abre (popup bloqueado), usamos mailto
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                window.location.href = `mailto:${email}`;
            }
        });
    });
</script>

<script>
    const btn = document.querySelector('.whatsapp-btn');
    btn.addEventListener('click', () => {
        const phone = '77573997';
        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        const url = isMobile ?
            `https://wa.me/${phone}` :
            `https://web.whatsapp.com/send?phone=${phone}`;

        window.open(url, '_blank');
    });
</script>

<script src="{{ asset('js/translations.js') }}"></script>
@endsection