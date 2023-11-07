<?php

namespace App\Database\Seeds;
use App\Models\CategoriaModel;
use App\Models\LibreriaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class LibreriaSeeder extends Seeder
{
    public function run()
    { 

        {
            $categorias = $this->db->table('categorias')->get()->getResultArray();
            $categoriasMap = [];
        
            foreach ($categorias as $categoria) {
                $categoriasMap[$categoria['nombre']] = $categoria['id'];
            }
    
        
        

            $data = [
                ['titulo' => 'Galaxias en Guerra: Orígenes', 'descripcion' => 'Embárcate en una odisea interestelar, formando alianzas y enfrentándote a enemigos en este juego de estrategia espacial en tiempo real.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos']],
                ['titulo' => 'Ruinas de Arkania: El Despertar', 'descripcion' => 'Descubre un mundo de magia y misterio mientras buscas artefactos antiguos y enfrentas fuerzas oscuras en este RPG de acción.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Carreras de Neon: Furia Nocturna', 'descripcion' => 'Siente la adrenalina en las calles futuristas iluminadas de neon. Personaliza tu vehículo y domina el arte del drift en este vertiginoso juego de carreras.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'El Último Samurai: Sombra de Honor', 'descripcion' => 'Viaja en el tiempo al Japón feudal y vive la vida de un samurai, enfrentándote a dilemas morales y enemigos mortales en este juego de acción y aventura.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Invasión Cibernética: Protocolo Zeta', 'descripcion' => 'Defiende el ciberespacio como un hacker de élite, usando habilidades de programación y tácticas de combate en este emocionante shooter en primera persona.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Reinos Flotantes: La Caida de Etheria', 'descripcion' => 'Explora islas flotantes, lucha contra criaturas míticas y descifra el misterio detrás de la caída de Etheria en este RPG de mundo abierto.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Oasis de Titan: Supervivencia en Marte', 'descripcion' => 'Después de un aterrizaje forzoso en Marte, lucha por sobrevivir, recolecta recursos y construye un nuevo hogar en este juego de supervivencia y construcción.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Leyendas del Mar Profundo: Krakens Wrath', 'descripcion' => 'Navega por océanos desconocidos, enfrenta monstruos marinos y busca tesoros ocultos en este juego de aventuras y estrategia naval.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Cazadores de Dragones: Ascensión', 'descripcion' => 'Entrena, lucha y vuela junto a dragones míticos en un mundo lleno de misterio y peligro en este juego RPG de acción.','fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Simulador de Ciudad Futurista: Neo-Utopia', 'descripcion' => 'Diseña, construye y gestiona una metrópolis del futuro, enfrentándote a desafíos tecnológicos y éticos en este simulador de construcción de ciudades.','fecha_subida' => Time::now(),'id_categoria'=> $categoriasMap['Juegos'] ],
                ['titulo' => 'Fútbol Mundial 0: Campeones en Ascenso', 'descripcion' => 'Experimenta la pasión del fútbol en los estadios más emblemáticos del mundo. Lidera a tu equipo hacia la victoria en la máxima competición.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Grand Slam Tennis Pro: Desafío Final', 'descripcion' => 'Domina la cancha y enfrenta a los profesionales en los torneos más prestigiosos. ¿Tienes lo que se necesita para ser el número uno?', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'NBA Superstars: El Duelo de Titanes', 'descripcion' => 'Desafía la gravedad, realiza jugadas espectaculares y lleva a tu equipo a ganar el campeonato en la mejor liga de baloncesto.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'MMA Fight Night: Desafío Supremo', 'descripcion' => 'Entra al octágono y demuestra tus habilidades de combate. Enfrenta a los peleadores más feroces y conviértete en una leyenda de las artes marciales mixtas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Rally de Montañas: Carrera Contra el Tiempo', 'descripcion' => 'Domina terrenos difíciles y velocidades vertiginosas mientras compites contra los mejores pilotos en paisajes impresionantes.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Súper Liga de Béisbol: Home Run Heroes', 'descripcion' => 'Juega en los estadios más icónicos, forma tu equipo soñado y lidera las ligas en este simulador de béisbol de primer nivel.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Soccer Manager Elite: Tácticas Maestras', 'descripcion' => 'Gestiona tu club, realiza fichajes estratégicos y guía a tu equipo hacia la gloria en esta simulación detallada de gestión de fútbol.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Aventura Acuática: Surf Pro Tour', 'descripcion' => 'Enfrenta las olas más grandes y muestra tus habilidades de surf en los destinos más exóticos del planeta.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Golf Grand Masters: El Green Desafío', 'descripcion' => 'Juega en campos diseñados con precisión, perfecciona tu swing y compite en torneos de alto nivel en este simulador de golf realista.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Hockey sobre Hielo: Duelo en la Pista', 'descripcion' => 'Siente la adrenalina de las jugadas rápidas y los choques intensos en la pista de hielo. Lidera tu equipo en emocionantes partidos y campeonatos.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Deportes'] ],
                ['titulo' => 'Sombras del Pasado', 'descripcion' => 'Un thriller psicológico que sigue a una periodista mientras desentraña un misterio oscuro de su infancia.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Galaxia en Llamas', 'descripcion' => 'Una epopeya espacial donde un grupo de rebeldes se enfrenta a un imperio intergaláctico para salvar la humanidad.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'El Último Acuerdo', 'descripcion' => 'Un drama histórico que retrata la vida de dos líderes mundiales en tiempos de guerra y sus esfuerzos por la paz.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Risas Bajo la Lluvia', 'descripcion' => 'Una comedia romántica que narra la historia de dos desconocidos que se encuentran en un día lluvioso y cómo sus vidas cambian a partir de ese momento.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Ecos del Silencio', 'descripcion' => 'Un documental impactante que explora la vida y lucha de las comunidades indígenas en regiones remotas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Cazadores de Sueños', 'descripcion' => 'Un grupo de amigos embarca en una aventura mágica en busca de un reino perdido en este épico film de fantasía.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Rebelión en la Oscuridad', 'descripcion' => 'Un drama de acción sobre un agente secreto que debe enfrentarse a traiciones y conspiraciones dentro de su propia organización.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Melodías del Corazón', 'descripcion' => 'Una inspiradora historia musical sobre una joven con talento luchando contra adversidades para alcanzar sus sueños.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Misterios del Abismo', 'descripcion' => 'Una aventura submarina que sigue a un grupo de exploradores mientras descubren secretos ocultos en las profundidades del océano.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Almas Entrelazadas', 'descripcion' => 'Un drama sobrenatural sobre dos almas reencarnadas que se encuentran a lo largo de diferentes eras y culturas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Cine'] ],
                ['titulo' => 'Tendencias Retro', 'descripcion' => 'Un vistazo a las modas del pasado que están regresando con fuerza esta temporada.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Alta Costura en París', 'descripcion' => 'Descubre las últimas creaciones de los diseñadores más prestigiosos del mundo en la Semana de la Moda de París.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Estilo Urbano', 'descripcion' => 'Las calles se convierten en pasarelas con las tendencias más atrevidas y contemporáneas del mundo de la moda.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Sostenibilidad en Moda', 'descripcion' => 'Un análisis de cómo la industria de la moda está adoptando prácticas más ecológicas y sostenibles.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'La Magia del Accesorio', 'descripcion' => 'Cómo los accesorios adecuados pueden transformar por completo tu look.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Destinos Fashion', 'descripcion' => 'Los lugares más chic del mundo para hacer compras, desde boutiques escondidas hasta grandes almacenes de lujo.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Moda Masculina Hoy', 'descripcion' => 'Un vistazo a las tendencias actuales en moda masculina y cómo han evolucionado con el tiempo.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'El Arte del Calzado', 'descripcion' => 'Explorando la artesanía y el diseño detrás de los zapatos más icónicos de la moda.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Pasarela Digital', 'descripcion' => 'Cómo la tecnología está cambiando la forma en que vemos y consumimos moda en la era digital.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Iconos de Estilo', 'descripcion' => 'Un tributo a las personalidades que han definido el mundo de la moda a lo largo de las décadas.', 'fecha_subida' => Time::now(),'id_categoria'=> $categoriasMap['Moda'] ],
                ['titulo' => 'Historia del Shonen', 'descripcion' => 'Una exploración profunda de cómo los animes shonen han capturado el corazón de múltiples generaciones.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Mundos Isekai', 'descripcion' => 'Descubre los universos paralelos más icónicos del género isekai y su creciente popularidad.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Directores Legendarios', 'descripcion' => 'Un homenaje a los directores que han dejado su marca en el mundo del anime.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Romance en el Anime', 'descripcion' => 'Las historias de amor más emocionantes y memorables en la animación japonesa.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Diseño de Personajes', 'descripcion' => 'El arte y la evolución del diseño de personajes en el anime a lo largo de las décadas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Anime y Cultura Pop', 'descripcion' => 'Cómo el anime ha influido y ha sido influenciado por la cultura pop mundial.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'El Auge del Seinen', 'descripcion' => 'Una mirada a la creciente popularidad de los animes seinen dirigidos a un público más maduro.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Magia y Fantasía', 'descripcion' => 'Los universos mágicos más impresionantes y las historias de fantasía que han cautivado a fans de todo el mundo.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Anime en el Cine', 'descripcion' => 'Desde Studio Ghibli hasta recientes éxitos de taquilla, descubre cómo el anime ha conquistado la pantalla grande.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Adaptaciones de Manga', 'descripcion' => 'Las transiciones más exitosas y polémicas de manga a anime y los desafíos detrás de ellas.', 'fecha_subida' => Time::now(),'id_categoria'=> $categoriasMap['Anime'] ],
                ['titulo' => 'Introducción a la Ética', 'descripcion' => 'Una exploración de los principios fundamentales de la ética y su impacto en nuestra vida diaria.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Filósofos de la Antigüedad', 'descripcion' => 'Descubre las enseñanzas de los grandes pensadores de la antigüedad y su relevancia en la actualidad.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Existencialismo Moderno', 'descripcion' => 'Una mirada profunda al movimiento filosófico del existencialismo y sus principales exponentes.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'La Naturaleza del Bien y del Mal', 'descripcion' => 'Debates y teorías sobre la naturaleza inherente del bien y el mal en la sociedad humana.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'La Ética en la Inteligencia Artificial', 'descripcion' => 'Explora los dilemas éticos que surgen con el avance de la tecnología y la inteligencia artificial.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Platón y la Idea de la Perfección', 'descripcion' => 'Una inmersión en la filosofía platónica y su búsqueda de la verdad y la perfección.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'El Nihilismo y la Sociedad Moderna', 'descripcion' => 'Una reflexión sobre el nihilismo y su influencia en la cultura y sociedad contemporáneas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Filosofía del Derecho', 'descripcion' => 'Un estudio de cómo la filosofía influye en nuestras leyes y sistemas judiciales.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Kant y la Moral Universal', 'descripcion' => 'Dive into Kantian ethics and the concept of universal moral principles.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Estoicismo: Enfrentando la Adversidad', 'descripcion' => 'Descubre cómo los principios estoicos pueden ayudarnos a enfrentar desafíos y adversidades en nuestra vida.', 'fecha_subida' => Time::now(),'id_categoria'=> $categoriasMap['Ética y Filosofía'] ],
                ['titulo' => 'Fundamentos de Python', 'descripcion' => 'Una introducción detallada al lenguaje de programación Python y sus aplicaciones prácticas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Desarrollo Web con JavaScript', 'descripcion' => 'Descubre cómo utilizar JavaScript para crear sitios web interactivos y dinámicos.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Introducción a Machine Learning', 'descripcion' => 'Explora los conceptos básicos del aprendizaje automático y cómo aplicarlos en proyectos reales.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Patrones de Diseño en Java', 'descripcion' => 'Una guía sobre patrones de diseño comunes en Java y cómo implementarlos en tu código.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Bases de Datos con SQL', 'descripcion' => 'Aprende a diseñar, crear y consultar bases de datos relacionales usando SQL.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Desarrollo de Apps Móviles con Flutter', 'descripcion' => 'Dive into mobile app development using Flutter and Dart for cross-platform applications.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Programación Funcional con Haskell', 'descripcion' => 'Descubre los principios de la programación funcional y cómo aplicarlos en Haskell.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Microservicios en la Nube', 'descripcion' => 'Entiende cómo diseñar y desplegar microservicios eficientes utilizando plataformas de nube.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Seguridad en Desarrollo Web', 'descripcion' => 'Aprende las mejores prácticas para mantener tus aplicaciones web seguras de amenazas y vulnerabilidades.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']],
                ['titulo' => 'Algoritmos y Estructuras de Datos', 'descripcion' => 'Profundiza en algoritmos esenciales y estructuras de datos para optimizar la eficiencia de tus programas.', 'fecha_subida' => Time::now(), 'id_categoria'=> $categoriasMap['Programación']]
        

        
            ];
        
        $this->db->table('librerias')->insertBatch($data);
        }
    }

    
}