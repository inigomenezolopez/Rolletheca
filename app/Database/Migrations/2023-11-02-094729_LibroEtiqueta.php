<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLibroEtiquetaTable extends Migration
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
            'id_etiqueta' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_libro','librerias','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_etiqueta','etiquetas','id','CASCADE','CASCADE');
        $this->forge->createTable('libro_etiqueta');
    }

    public function down()
    {
        $this->forge->dropTable('libro_etiqueta');
    }
}
