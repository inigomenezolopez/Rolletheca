<?php

namespace App\Models;

use CodeIgniter\Model;

class LibreriaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'librerias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','id_categoria','titulo','descripcion','ruta_archivo','formato','tamano','fecha_subida','valoracion'];

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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getLibreriasByCategoria($categoriaName) {
        $this->db->select('*');
        $this->db->from('librerias');
        $this->db->join('categorias', 'categorias.id = librerias.id_categoria'); // Corregido aquí
        $this->db->where('categorias.nombre', $categoriaName);
        $query = $this->db->get();
        return $query->result();
    }

public function valoracionMedia($id) {
    $query = $this->db->query('SELECT AVG(valoracion) as media FROM comentarios WHERE id_libro = ?', $id);
    return $query->getRow()->media;
}

public function filtrarPorEtiquetasCategoria($etiquetasSeleccionadas, $idCategoria)
{
    // Inicia la consulta con la tabla de libros y su categoría correspondiente
    $builder = $this->table('librerias');
    $builder->select('librerias.*, categorias.nombre AS categoria');
    $builder->join('categorias', 'categorias.id = librerias.id_categoria');
    $builder->where('librerias.id_categoria', $idCategoria);

    // Si hay etiquetas seleccionadas, añade las condiciones necesarias para el filtrado
    if (!empty($etiquetasSeleccionadas)) {
        $countEtiquetas = count($etiquetasSeleccionadas);
        $builder->join('libro_etiqueta', 'libro_etiqueta.id_libro = librerias.id');
        $builder->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta');
        $builder->whereIn('etiquetas.id', $etiquetasSeleccionadas);
        $builder->groupBy('librerias.id');
        $builder->having('COUNT(DISTINCT etiquetas.id) =', $countEtiquetas);
    }

    return $this->paginate(12);

    
}
    
    
}


