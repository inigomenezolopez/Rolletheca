<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'unsigned'=>TRUE,
                'auto_increment'=>TRUE
            ],
            'usuario'=>[
                'type'=>'VARCHAR',
                'constraint'=> 100,
                'unique'=>TRUE
                
            ],
            'imagen'=>[
                'type'=>'VARCHAR',
                'constraint'=> 255,
                'null'=>TRUE
                
            ],
            'rol' => [
                'type' => 'ENUM',
                'constraint' => ['admin','usuario'],
                'default' => 'usuario', // Define un valor predeterminado, si lo deseas.
            ],
                
                
            'correo'=>[
                'type'=>'VARCHAR',
                'constraint'=> 255,
                'unique'=>TRUE
                
            ],
            'contrasena'=>[
                'type'=>'VARCHAR',
                'constraint'=> 255,
                
                
            ],
            'fecha_creacion'=>[
                'type'=>'DATETIME',
               
                
            ]
           
        ]);
    
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
