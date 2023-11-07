<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        
        helper('text');

        $categorias = [
            ['nombre' => 'Juegos', 'descripcion' => 'Explora el mundo de los videojuegos, desde los clásicos hasta las últimas novedades. '],
            ['nombre' => 'Deportes', 'descripcion' => 'Noticias, análisis y discusiones sobre los deportes más populares del mundo. '],
            ['nombre' => 'Cine', 'descripcion' => 'Descubre las últimas películas, reseñas y debates sobre el mundo del cine. '],
            ['nombre' => 'Moda', 'descripcion' => 'Tendencias, estilos y consejos sobre el fascinante mundo de la moda. '],
            ['nombre' => 'Anime', 'descripcion' => 'Sumérgete en el mundo del anime, con reseñas, discusiones y recomendaciones. '],
            ['nombre' => 'Ética y Filosofía', 'descripcion' => 'Debates profundos y discusiones sobre ética, moral y filosofía. '],
            ['nombre' => 'Programación', 'descripcion' => 'Aprende, discute y comparte sobre el vasto mundo de la programación y el desarrollo. ']
        ];

        // Agregamos el slug para cada categoría
        foreach ($categorias as &$categoria) {
            $categoria['slug'] = url_title($categoria['nombre'], '-', TRUE);
        }

        // Asumiendo que tienes una tabla llamada "categorias"
        $this->db->table('categorias')->insertBatch($categorias);
}
}