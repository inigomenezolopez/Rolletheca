<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','imagen','nombre','descripcion','slug'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setSlug'];
    protected $afterInsert    = ['setSlug'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

     /**
 * setSlug Función para establecer el slug a partir del nombre.
 *
 * @param array $data Array de datos que se van a insertar o actualizar.
 * @return array Array modificado con el slug.
 */
protected function setSlug(array $data)
{
    if (isset($data['data']['nombre'])) {
        // TRUE convierte el slug a minúsculas
        $slug = url_title($data['data']['nombre'], '-', true); 
        $data['data']['slug'] = $this->ensureUniqueSlug($slug);
    }

    return $data;
}

protected function ensureUniqueSlug($slug)
{
    // Asumiendo que tienes $this->db inicializado con la conexión a la base de datos
    $builder = $this->db->table('categorias'); 

    $originalSlug = $slug;
    $counter = 1;

    // Mientras que haya resultados en la base de datos para ese slug, sigue intentando.
    while ($builder->where('slug', $slug)->countAllResults() > 0) {
        // Añade un contador al slug original para hacerlo único
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }

    return $slug;
}
public function getLibreriasByCategoria($categoriaName) {
    $this->db->select('*');  // Selecciona todos los campos
    $this->db->from('librerias');  // Desde la tabla "librerias"
    $this->db->join('categorias', 'categorias.id = librerias.id_categoria');  // Realiza un JOIN con la tabla "categorias" basado en el campo id_categoria
    $this->db->where('categorias.nombre', $categoriaName);  // Filtra los resultados por el nombre de la categoría
    $query = $this->db->get();  // Ejecuta la consulta
    return $query->result();  // Devuelve los resultados

}
}