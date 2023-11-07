<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categorias extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=> 5,
                'unsigned'=>TRUE,
                'auto_increment'=>TRUE
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'imagen'=>[
                'type'=>'VARCHAR',
                'constraint'=> 255,
                
            ],
            'descripcion' => [
                'type' => 'TEXT'
            ],

            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true
            ],
            
        ]);
    
        $this->forge->addKey('id', true);
        $this->forge->createTable('categorias');
    }

    public function down()
    {
        $this->forge->dropTable('categorias');
    }
}
