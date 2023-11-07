<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    public function run()
    {
    $categorias = $this->db->table('categorias')->get()->getResultArray();
    $categoriasMap = [];

    foreach ($categorias as $categoria) {
        $categoriasMap[$categoria['nombre']] = $categoria['id'];
    }

    $data = [
        // Etiquetas para Juegos
        ['nombre' => 'RPG', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'FPS', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Aventuras', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Estrategia', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Simulación', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Deportes', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Arcade', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'VR', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Multijugador', 'id_categoria' => $categoriasMap['Juegos']],
        ['nombre' => 'Indie', 'id_categoria' => $categoriasMap['Juegos']],

        // Etiquetas para Deportes
        ['nombre' => 'Fútbol', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Baloncesto', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Tenis', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Golf', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Ciclismo', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Atletismo', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Natación', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Boxeo', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Fórmula 1', 'id_categoria' => $categoriasMap['Deportes']],
        ['nombre' => 'Balonmano', 'id_categoria' => $categoriasMap['Deportes']],

        // Etiquetas para Cine
        ['nombre' => 'Acción', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Comedia', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Drama', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Ciencia Ficción', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Terror', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Romance', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Aventuras', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Animación', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Documental', 'id_categoria' => $categoriasMap['Cine']],
        ['nombre' => 'Musical', 'id_categoria' => $categoriasMap['Cine']],

        // Etiquetas para Moda
        ['nombre' => 'Alta costura', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Prêt-à-porter', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Vintage', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Casual', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Boho chic', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Streetwear', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Grunge', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Minimalista', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Sporty chic', 'id_categoria' => $categoriasMap['Moda']],
        ['nombre' => 'Hippie chic', 'id_categoria' => $categoriasMap['Moda']],

        // Etiquetas para Anime
        ['nombre' => 'Shonen', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Shojo', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Seinen', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Josei', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Mecha', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Isekai', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Fantasía', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Romance', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Acción', 'id_categoria' => $categoriasMap['Anime']],
        ['nombre' => 'Aventuras', 'id_categoria' => $categoriasMap['Anime']],

        // Etiquetas para Ética y Filosofía
        ['nombre' => 'Ética', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Metafísica', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Epistemología', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Estética', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Lógica', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Filosofía política', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Filosofía de la mente', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Ética aplicada', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Filosofía antigua', 'id_categoria' => $categoriasMap['Ética y Filosofía']],
        ['nombre' => 'Filosofía contemporánea', 'id_categoria' => $categoriasMap['Ética y Filosofía']],

        // Etiquetas para Programación
        ['nombre' => 'Python', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'JavaScript', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'Java', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'C++', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'C#', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'PHP', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'Ruby', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'Swift', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'Kotlin', 'id_categoria' => $categoriasMap['Programación']],
        ['nombre' => 'TypeScript', 'id_categoria' => $categoriasMap['Programación']],
    ];

    $this->db->table('etiquetas')->insertBatch($data);
}

}