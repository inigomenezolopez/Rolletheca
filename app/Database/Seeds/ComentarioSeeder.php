<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ComentarioSeeder extends Seeder
{
    public function run()
    {
        // Carga el helper de texto para generar contenido ficticio
        helper('text');

        // Suponiendo que ya tienes datos en tus tablas libros y usuarios
        // Obtener el rango de IDs existentes en esas tablas
        $db      = \Config\Database::connect();
        $builder = $db->table('librerias');
        $libros = $builder->select('id')->get()->getResultArray();

        $builder = $db->table('usuarios');
        $usuarios = $builder->select('id')->get()->getResultArray();

        for ($i = 0; $i < 100; $i++) {
            $data = [
                'id_libro'          => $libros[array_rand($libros)]['id'], // ID aleatorio de libro
                'id_usuario'        => $usuarios[array_rand($usuarios)]['id'], // ID aleatorio de usuario
                'contenido'         => random_string('sentence', 25), // Genera una oración ficticia
                'fecha_publicacion' => Time::now()->toDateTimeString(), // Fecha y hora actual
                'valoracion'        => rand(1, 5), // Valoración aleatoria entre 1 y 5
            ];

            // Insertar el comentario en la base de datos
            $builder = $db->table('comentarios');
            $builder->insert($data);
        }
    }
}