<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comentarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_libro' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'contenido' => [
                'type' => 'TEXT',
            ],
            'fecha_publicacion' => [
                'type'=>'DATETIME',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_libro', 'librerias', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id', 'CASCADE', 'CASCADE'); // Asume que tu tabla de usuarios se llama "usuarios"
        $this->forge->createTable('comentarios');
    }

    public function down()
    {
        $this->forge->dropTable('comentarios');
    }
}