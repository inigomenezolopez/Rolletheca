<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Librerias extends Migration
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
        'titulo'=>[
            'type'=>'VARCHAR',
            'constraint'=> 255,
            
        ],
        'descripcion'=>[
            'type'=>'TEXT'
            
        ],
        'ruta_archivo'=>[
            'type'=>'VARCHAR',
            'constraint'=> 500,
            
        ],
        
        'fecha_subida'=>[
            'type'=>'DATETIME',
            
            
        ],
        'valoracion' => [
            'type' => 'FLOAT',
        ],
        
        'id_categoria'=>[
            'type'=>'INT',
            'constraint'=> 5,
            'unsigned'=>TRUE,
           
        ],
        
    
       
    ]);

    $this->forge->addKey('id', TRUE);
    $this->forge->addForeignKey('id_categoria', 'categorias', 'id', 'CASCADE', 'CASCADE');
    
    $this->forge->createTable('librerias');
        }



        

    public function down()
    {
        $this->forge->dropForeignKey('librerias', 'librerias_id_categoria_foreign');
        
        $this->forge->dropTable('librerias');
    }
}