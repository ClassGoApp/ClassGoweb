<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubjectGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Columnas que queremos actualizar si el registro ya existe
        $columnsToUpdate = ['name', 'description', 'status', 'deleted_at', 'id_padre'];

        // =====================================================
        // NIVEL 1: CATEGORÍAS PRINCIPALES
        // =====================================================
        DB::table('subject_groups')->upsert([
            ['id' => 1000, 'name' => 'Colegio', 'description' => 'Nivel educativo escolar que abarca la formación básica, primaria y secundaria.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => null],
            ['id' => 2000, 'name' => 'Universidad', 'description' => 'Nivel académico superior orientado a la formación profesional e investigación científica.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => null],
            ['id' => 3000, 'name' => 'Instituto', 'description' => 'Formación técnica y profesional enfocada en la práctica, especialización y empleabilidad.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => null],
        ], ['id'], $columnsToUpdate);


        // =====================================================
        // NIVEL 2: SUBCATEGORÍAS PRINCIPALES
        // =====================================================
        DB::table('subject_groups')->upsert([
            // Universidad
            ['id' => 2100, 'name' => 'Ciencias Exactas', 'description' => 'Área universitaria dedicada a las matemáticas, física, química y estadística.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2000],
            ['id' => 2101, 'name' => 'Ingeniería Avanzada', 'description' => 'Campo aplicado con enfoque en innovación tecnológica y simulación de sistemas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2000],
            ['id' => 2102, 'name' => 'Ciencias Sociales y Económicas', 'description' => 'Estudios orientados a la gestión empresarial, finanzas y análisis económico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2000],
            
            // Instituto
            ['id' => 3100, 'name' => 'Idiomas', 'description' => 'Formación en lenguas extranjeras y nativas con fines comunicativos y profesionales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3101, 'name' => 'Marketing y Comunicación Digital', 'description' => 'Área dedicada al estudio de estrategias digitales y publicidad online.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3102, 'name' => 'Arte y Diseño', 'description' => 'Formación creativa en diseño visual, colorimetría y artes aplicadas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3103, 'name' => 'Gastronomía y Repostería', 'description' => 'Área técnica orientada a la formación en repostería, panadería y gestión de negocios gastronómicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3104, 'name' => 'Ingeniería y Tecnología', 'description' => 'Especialidades técnicas relacionadas con programación, redes y automatización.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3105, 'name' => 'Psicología y Desarrollo Personal', 'description' => 'Área enfocada en el bienestar emocional y el crecimiento humano integral.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
            ['id' => 3106, 'name' => 'Deporte y Bienestar', 'description' => 'Área dedicada a la salud física, el entrenamiento y el turismo activo.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3000],
        ], ['id'], $columnsToUpdate);


        // =====================================================
        // NIVEL 3: CATEGORÍAS DETALLADAS
        // =====================================================
        // Cada bloque está organizado por su subcategoría y con descripciones técnico-institucionales.
        
        
        // -----------------------------------------------------
        // COLEGIO → NIVELES EDUCATIVOS
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 1, 'name' => 'Básico', 'description' => 'Nivel educativo inicial orientado al desarrollo de competencias básicas en lectura, escritura y razonamiento lógico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 1000],
            ['id' => 2, 'name' => 'Primaria', 'description' => 'Etapa educativa centrada en la adquisición de conocimientos fundamentales y valores formativos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 1000],
            ['id' => 3, 'name' => 'Secundaria', 'description' => 'Nivel escolar enfocado en la formación crítica, científica y preparación para estudios superiores.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 1000],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // UNIVERSIDAD → CIENCIAS EXACTAS
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 4,  'name' => 'Ciencias Exactas', 'description' => 'Área académica que abarca disciplinas como matemáticas, física, química y estadística aplicada a la ingeniería y la investigación científica.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 5,  'name' => 'Química', 'description' => 'Curso orientado al estudio de la composición, propiedades y transformaciones de la materia, con aplicación en entornos industriales y de laboratorio.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 28, 'name' => 'Matemática Aplicada a la Ingeniería Ambiental', 'description' => 'Asignatura que aplica modelos matemáticos para la resolución de problemas medioambientales y de ingeniería sostenible.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 29, 'name' => 'Estadística', 'description' => 'Curso sobre análisis de datos, inferencia estadística y toma de decisiones basadas en evidencia.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 30, 'name' => 'Cálculo', 'description' => 'Asignatura fundamental sobre límites, derivadas e integrales con aplicación en problemas de ingeniería y ciencias exactas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 31, 'name' => 'Ecuaciones Diferenciales', 'description' => 'Curso técnico que aborda la resolución de ecuaciones diferenciales ordinarias y parciales aplicadas a sistemas dinámicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
            ['id' => 33, 'name' => 'Métodos Numéricos', 'description' => 'Asignatura centrada en algoritmos de aproximación numérica para resolver problemas científicos e ingenieriles.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2100],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // UNIVERSIDAD → INGENIERÍA AVANZADA
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 34, 'name' => 'Programación', 'description' => 'Curso técnico orientado al desarrollo de algoritmos, estructuras de datos y fundamentos de programación aplicados a la ingeniería.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 35, 'name' => 'Modelado y Simulación de Sistemas', 'description' => 'Asignatura centrada en la creación de modelos matemáticos y simulaciones computacionales de procesos complejos de ingeniería.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 43, 'name' => 'Sistemas y Tecnologías de la Información', 'description' => 'Curso sobre infraestructura tecnológica, gestión de sistemas de información y aplicaciones en entornos empresariales e industriales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 44, 'name' => 'Bases de Datos', 'description' => 'Asignatura técnica sobre diseño lógico, modelado relacional y administración de bases de datos aplicadas a proyectos de ingeniería.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 46, 'name' => 'Tecnologías Web', 'description' => 'Curso sobre desarrollo y despliegue de aplicaciones web con fines académicos, científicos y empresariales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 47, 'name' => 'Tecnologías Web y Multimedia', 'description' => 'Asignatura enfocada en la integración de herramientas web con entornos multimedia para la comunicación y el diseño digital.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 48, 'name' => 'Computación y Automatización', 'description' => 'Curso práctico sobre sistemas automatizados, control computarizado y robótica aplicada a procesos industriales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 49, 'name' => 'Diseño Electrónico y Circuitos', 'description' => 'Asignatura que aborda el diseño, simulación y análisis de circuitos eléctricos y electrónicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
            ['id' => 104, 'name' => 'Ingeniería y Medio Ambiente', 'description' => 'Curso técnico interdisciplinario que aplica principios de ingeniería en el diseño de soluciones sostenibles para el medio ambiente.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2101],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // UNIVERSIDAD → Ciencias Sociales y Económicas
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 6,  'name' => 'Econometría', 'description' => 'Asignatura que combina la estadística, las matemáticas y la economía para el análisis y modelado de fenómenos económicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 7,  'name' => 'Finanzas', 'description' => 'Curso orientado al estudio de la gestión financiera, análisis de inversiones y planificación económica empresarial.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 8,  'name' => 'Economía Cuantitativa', 'description' => 'Asignatura que aplica métodos matemáticos y estadísticos para el análisis riguroso de la economía y los mercados.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 9,  'name' => 'Contabilidad', 'description' => 'Curso sobre principios contables, registro de operaciones y elaboración de estados financieros.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 10, 'name' => 'Presupuesto y Criptoactivos', 'description' => 'Asignatura moderna que aborda la planificación financiera institucional y la gestión de activos digitales y criptomonedas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 11, 'name' => 'Métodos Cuantitativos', 'description' => 'Curso centrado en técnicas numéricas y herramientas analíticas aplicadas a la toma de decisiones empresariales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 45, 'name' => 'Auditoría', 'description' => 'Asignatura técnica que desarrolla competencias en control interno, revisión de estados financieros y auditorías externas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 51, 'name' => 'Diseño de Sistemas Financieros', 'description' => 'Curso sobre la estructura, diseño e implementación de modelos financieros y bancarios modernos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
            ['id' => 95, 'name' => 'Emprendimiento y Gestión de Negocios', 'description' => 'Asignatura enfocada en la creación, desarrollo y sostenibilidad de proyectos empresariales innovadores.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 2102],
        ], ['id'], $columnsToUpdate);


        // -----------------------------------------------------
        // INSTITUTO → IDIOMAS
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 52, 'name' => 'Interpretación y Traducción de Idiomas', 'description' => 'Curso orientado a desarrollar competencias lingüísticas y técnicas para la interpretación y traducción profesional.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 53, 'name' => 'Traducción', 'description' => 'Asignatura enfocada en la traducción escrita de textos especializados, literarios y técnicos con precisión terminológica.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 54, 'name' => 'Inglés Profesional Jurídico', 'description' => 'Curso técnico sobre terminología y redacción jurídica en inglés aplicada a contextos legales y corporativos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 55, 'name' => 'Inglés Avanzado (CBA y Otros Institutos)', 'description' => 'Asignatura práctica para el perfeccionamiento de las competencias orales y escritas del idioma inglés a nivel avanzado.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 56, 'name' => 'Francés Avanzado', 'description' => 'Curso orientado al dominio del idioma francés con énfasis en comprensión auditiva, conversación y escritura formal.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 57, 'name' => 'Alemán Avanzado', 'description' => 'Asignatura dedicada a la comunicación avanzada en alemán, aplicada a entornos laborales y académicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 58, 'name' => 'Español', 'description' => 'Curso técnico sobre gramática, redacción y oratoria en lengua española, dirigido a hablantes nativos y extranjeros.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 59, 'name' => 'Italiano', 'description' => 'Asignatura centrada en la comunicación oral y escrita del idioma italiano con enfoque cultural y profesional.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 60, 'name' => 'Portugués', 'description' => 'Curso práctico sobre comprensión, expresión y gramática del idioma portugués aplicado al ámbito comercial y turístico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 61, 'name' => 'Ruso', 'description' => 'Asignatura de introducción al idioma ruso, su estructura gramatical y expresiones básicas de comunicación.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 62, 'name' => 'Quechua', 'description' => 'Curso técnico-cultural sobre el idioma quechua, su pronunciación, escritura y aplicación en contextos sociales y turísticos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 63, 'name' => 'Aymara', 'description' => 'Asignatura práctica sobre el idioma aymara, con énfasis en comunicación básica y rescate lingüístico andino.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 64, 'name' => 'Guaraní', 'description' => 'Curso sobre el idioma guaraní y su relevancia cultural, con prácticas de expresión oral y escrita.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
            ['id' => 103, 'name' => 'Traducción e Interpretación Profesional', 'description' => 'Asignatura avanzada que integra técnicas de interpretación simultánea y traducción especializada en contextos multilingües.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3100],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // INSTITUTO → MARKETING Y COMUNICACIÓN DIGITAL
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 12, 'name' => 'Gestión de Contenidos Digitales', 'description' => 'Curso orientado a la planificación, creación y administración de contenidos en plataformas digitales y redes sociales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 13, 'name' => 'Gestión de Redes Sociales', 'description' => 'Asignatura técnica sobre estrategias de gestión y análisis de redes sociales para marcas y empresas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 14, 'name' => 'Community Management', 'description' => 'Curso práctico que forma especialistas en la administración de comunidades digitales y gestión de la reputación online.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 15, 'name' => 'Estrategias de Monetización', 'description' => 'Asignatura enfocada en métodos de generación de ingresos a través de plataformas digitales y redes sociales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 16, 'name' => 'Edición Multimedia', 'description' => 'Curso técnico sobre herramientas de edición de video, audio e imagen aplicadas al marketing digital.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 17, 'name' => 'Diseño y Herramientas Visuales', 'description' => 'Asignatura sobre el uso de software y técnicas de diseño para la creación de contenido publicitario digital.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 18, 'name' => 'Creación de Contenidos', 'description' => 'Curso práctico para la producción de material audiovisual, textual y gráfico enfocado en marketing digital.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 19, 'name' => 'Producción Audiovisual', 'description' => 'Asignatura técnica centrada en la planificación, filmación y edición de material audiovisual para campañas digitales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 20, 'name' => 'Publicidad en Facebook Ads', 'description' => 'Curso orientado a la creación, gestión y optimización de campañas publicitarias en Facebook e Instagram.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 21, 'name' => 'Publicidad en Instagram', 'description' => 'Asignatura especializada en estrategias de marketing visual y campañas de interacción en Instagram.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 22, 'name' => 'Publicidad en TikTok', 'description' => 'Curso que enseña la planificación de contenido y anuncios en TikTok para potenciar la visibilidad de marcas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 23, 'name' => 'Marketing y Publicidad en YouTube', 'description' => 'Asignatura orientada a estrategias de promoción audiovisual y posicionamiento de marcas en YouTube.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 24, 'name' => 'Publicidad en LinkedIn para Negocios', 'description' => 'Curso técnico que aborda el marketing B2B y la publicidad profesional en la red LinkedIn.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 25, 'name' => 'Publicidad en Snapchat Ads', 'description' => 'Asignatura enfocada en estrategias de comunicación visual y anuncios en plataformas emergentes como Snapchat.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 26, 'name' => 'Optimización de Campañas Publicitarias', 'description' => 'Curso técnico sobre análisis de métricas, A/B testing y mejora de campañas digitales en múltiples plataformas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 27, 'name' => 'Multiplataformas en Redes Sociales', 'description' => 'Asignatura sobre estrategias de comunicación integradas en diversas redes sociales y entornos digitales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 93, 'name' => 'Publicidad y Branding', 'description' => 'Curso técnico sobre gestión de marca, posicionamiento y desarrollo de identidad visual corporativa.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 94, 'name' => 'Marketing en Redes Sociales', 'description' => 'Asignatura orientada a la creación de estrategias de marketing digital enfocadas en redes sociales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
            ['id' => 98, 'name' => 'Creación de Contenido Digital', 'description' => 'Curso práctico para desarrollar estrategias de storytelling y producción multimedia para entornos digitales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3101],
        ], ['id'], $columnsToUpdate);


        // -----------------------------------------------------
        // INSTITUTO → ARTE Y DISEÑO
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 82,  'name' => 'Dibujo y Técnicas Básicas', 'description' => 'Curso introductorio que desarrolla habilidades de observación, bocetado y uso de materiales de dibujo artístico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 83,  'name' => 'Pintura y Color', 'description' => 'Asignatura enfocada en la teoría y práctica del color, aplicación de técnicas pictóricas y composición visual.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 84,  'name' => 'Escultura y Modelado', 'description' => 'Curso práctico sobre técnicas tridimensionales de escultura, tallado y modelado con diversos materiales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 85,  'name' => 'Arte y Diseño Gráfico', 'description' => 'Asignatura sobre fundamentos del diseño visual, composición, tipografía y procesos creativos aplicados al arte digital.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 86,  'name' => 'Historia del Arte', 'description' => 'Curso teórico que analiza los principales movimientos artísticos y su influencia cultural a lo largo de la historia.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 87,  'name' => 'Técnicas Experimentales y Nuevas Tendencias', 'description' => 'Asignatura enfocada en la exploración de materiales no convencionales y corrientes artísticas contemporáneas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 88,  'name' => 'Fundamentos de la Colorimetría', 'description' => 'Curso que estudia la teoría del color y su aplicación en diseño, estética e imagen profesional.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 89,  'name' => 'Colorimetría Aplicada', 'description' => 'Asignatura que aplica principios del color en ámbitos estéticos, textiles y de diseño visual.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 90,  'name' => 'Técnicas y Herramientas de Colorimetría', 'description' => 'Curso técnico sobre uso de herramientas digitales y analógicas para el control y combinación cromática.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 91,  'name' => 'Colorimetría en la Industria', 'description' => 'Asignatura que aborda la aplicación del color en procesos industriales, diseño de productos y control de calidad visual.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 92,  'name' => 'Color y Combinación Cromática', 'description' => 'Curso práctico sobre armonías, contrastes y teoría de la luz aplicada al diseño estético y artístico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 96,  'name' => 'Diseño y Comunicación Visual', 'description' => 'Asignatura sobre fundamentos de comunicación visual, branding y desarrollo de piezas gráficas publicitarias.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 97,  'name' => 'Fotografía Digital y Edición', 'description' => 'Curso técnico que enseña técnicas de captura, composición y edición de imágenes digitales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 99,  'name' => 'Artes Visuales y Diseño', 'description' => 'Asignatura interdisciplinaria que combina arte visual, diseño conceptual y desarrollo creativo.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 100, 'name' => 'Expresión Artística y Cultura', 'description' => 'Curso sobre manifestaciones artísticas, apreciación estética y su relación con la identidad cultural.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 113, 'name' => 'Artes Escénicas y Actuación', 'description' => 'Curso práctico sobre técnicas de expresión corporal, teatro y puesta en escena artística.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
            ['id' => 114, 'name' => 'Diseño y Producción de Videojuegos', 'description' => 'Asignatura técnica orientada al desarrollo conceptual, visual y funcional de videojuegos y entornos interactivos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3102],
        ], ['id'], $columnsToUpdate);


        // -----------------------------------------------------
        // Gastronomía y Repostería
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 67, 'name' => 'Fundamentos de Repostería', 'description' => 'Curso introductorio orientado a los principios básicos de la repostería profesional y la gestión de microemprendimientos gastronómicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 68, 'name' => 'Ingredientes y Química de Alimentos', 'description' => 'Asignatura que estudia la composición química de los alimentos y su aplicación en la industria gastronómica y alimentaria.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 69, 'name' => 'Técnicas de Repostería', 'description' => 'Curso práctico sobre técnicas, procedimientos y control de calidad en la elaboración de productos de repostería.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 70, 'name' => 'Pastelería Creativa', 'description' => 'Asignatura que desarrolla la creatividad aplicada a la decoración y presentación de postres y tortas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 71, 'name' => 'Postres Internacionales', 'description' => 'Curso sobre elaboración de postres típicos de distintas culturas con enfoque en técnicas de presentación y sabor.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 72, 'name' => 'Dietas Especiales y Saludables', 'description' => 'Asignatura orientada a la preparación de alimentos y postres adaptados a necesidades nutricionales específicas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 73, 'name' => 'Gestión de Negocios de Repostería', 'description' => 'Curso sobre administración, costos y estrategias comerciales en negocios de repostería y gastronomía.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
            ['id' => 74, 'name' => 'Seguridad e Higiene en Repostería', 'description' => 'Asignatura que desarrolla competencias en normas sanitarias, control de higiene y seguridad alimentaria en entornos productivos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3103],
        ], ['id'], $columnsToUpdate);


        // -----------------------------------------------------
        // INSTITUTO → INGENIERÍA Y TECNOLOGÍA
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 32, 'name' => 'Fundamentos', 'description' => 'Curso base que introduce los principios teóricos y metodológicos comunes a las áreas de ingeniería y tecnología.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 36, 'name' => 'Edición y Diseño', 'description' => 'Asignatura técnica orientada a la creación de interfaces visuales, material técnico y comunicación gráfica aplicada a proyectos tecnológicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 37, 'name' => 'Aplicaciones', 'description' => 'Curso práctico sobre el desarrollo e implementación de aplicaciones informáticas y móviles con fines profesionales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 38, 'name' => 'Técnicas Básicas', 'description' => 'Asignatura que enseña el uso de herramientas y procedimientos técnicos esenciales para el trabajo en laboratorios y talleres.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 39, 'name' => 'Operador de Maquinaria Pesada', 'description' => 'Curso técnico de certificación en manejo, mantenimiento y seguridad en operación de maquinaria pesada.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 40, 'name' => 'Redes y Conectividad', 'description' => 'Asignatura enfocada en el diseño, instalación y mantenimiento de redes informáticas y sistemas de comunicación.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 41, 'name' => 'Redes y Comunicaciones', 'description' => 'Curso técnico sobre transmisión de datos, configuración de equipos de red y gestión de conectividad avanzada.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 42, 'name' => 'Comunicación', 'description' => 'Asignatura sobre fundamentos de comunicación técnica y efectiva en entornos de ingeniería y tecnología.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 50, 'name' => 'Herramientas Ofimáticas', 'description' => 'Curso técnico que enseña el uso profesional de herramientas ofimáticas aplicadas a entornos empresariales y tecnológicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 65, 'name' => 'Oficios Técnicos', 'description' => 'Curso técnico que brinda conocimientos prácticos en diversas áreas laborales y de servicios especializados.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 66, 'name' => 'Instalación de Redes y Conectividad', 'description' => 'Curso práctico sobre cableado estructurado, configuración de routers y mantenimiento de infraestructura de red.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 105, 'name' => 'Análisis de Datos y Estadística', 'description' => 'Asignatura que introduce técnicas de procesamiento, visualización y análisis de datos aplicadas a proyectos tecnológicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 106, 'name' => 'Construcción y Mantenimiento', 'description' => 'Curso técnico sobre gestión de proyectos constructivos, mantenimiento preventivo y seguridad industrial.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
            ['id' => 107, 'name' => 'Mecánica y Reparaciones', 'description' => 'Asignatura centrada en fundamentos de mecánica aplicada, diagnóstico y reparación de sistemas electromecánicos.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3104],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // INSTITUTO → PSICOLOGÍA Y DESARROLLO PERSONAL
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 75, 'name' => 'Psicología General', 'description' => 'Curso introductorio que aborda los fundamentos teóricos de la conducta humana, los procesos mentales y las bases de la psicología moderna.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 76, 'name' => 'Psicología del Desarrollo', 'description' => 'Asignatura que estudia las etapas del desarrollo humano desde la infancia hasta la adultez, considerando factores biológicos y sociales.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 77, 'name' => 'Psicología Clínica', 'description' => 'Curso orientado al estudio de los trastornos mentales, su diagnóstico y las principales corrientes terapéuticas utilizadas en la práctica clínica.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 78, 'name' => 'Psicología Educativa', 'description' => 'Asignatura que analiza los procesos psicológicos involucrados en el aprendizaje y la intervención educativa en diferentes niveles de formación.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 79, 'name' => 'Psicología Organizacional', 'description' => 'Curso enfocado en el comportamiento humano dentro de las organizaciones, la motivación laboral y el liderazgo efectivo.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 80, 'name' => 'Psicología Social y Comunitaria', 'description' => 'Asignatura que estudia la interacción social, la identidad grupal y las estrategias de intervención comunitaria.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 81, 'name' => 'Psicología Forense', 'description' => 'Curso especializado en la aplicación de principios psicológicos al ámbito legal, penal y judicial.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 101, 'name' => 'Filosofía y Desarrollo del Pensamiento', 'description' => 'Asignatura que promueve el pensamiento crítico y la reflexión ética a partir del estudio de corrientes filosóficas clásicas y contemporáneas.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 102, 'name' => 'Formación Pedagógica y Didáctica', 'description' => 'Curso que fortalece las competencias docentes y estrategias didácticas aplicadas a procesos educativos y de formación humana.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
            ['id' => 112, 'name' => 'Desarrollo Personal y Espiritualidad', 'description' => 'Asignatura orientada al crecimiento personal, autoconocimiento y equilibrio emocional mediante herramientas de psicología y espiritualidad aplicada.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3105],
        ], ['id'], $columnsToUpdate);

        // -----------------------------------------------------
        // INSTITUTO → DEPORTE Y BIENESTAR
        // -----------------------------------------------------
        DB::table('subject_groups')->upsert([
            ['id' => 108, 'name' => 'Gastronomía y Repostería', 'description' => 'Curso orientado a la preparación y presentación de alimentos saludables, integrando principios de nutrición y bienestar físico.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3106],
            ['id' => 109, 'name' => 'Estética y Moda', 'description' => 'Asignatura que combina el cuidado personal, la imagen estética y las tendencias de la moda con un enfoque en el bienestar integral.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3106],
            ['id' => 110, 'name' => 'Entrenamiento Físico y Bienestar', 'description' => 'Curso práctico enfocado en el desarrollo de rutinas de entrenamiento, nutrición deportiva y mantenimiento del bienestar corporal.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3106],
            ['id' => 111, 'name' => 'Turismo y Naturaleza', 'description' => 'Asignatura que promueve el turismo sostenible, la recreación al aire libre y la conexión entre actividad física y medio ambiente.', 'status' => 'active', 'deleted_at' => null, 'id_padre' => 3106],
        ], ['id'], $columnsToUpdate);
    }
}
