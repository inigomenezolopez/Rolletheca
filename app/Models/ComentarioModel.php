<?php

namespace App\Models;

use CodeIgniter\Model;

class ComentarioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'comentarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_libro', 'id_usuario', 'contenido', 'fecha_publicacion', 'valoracion'];

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
    

    public function getComentariosConUsuario($id_libro)  {
        return $this->select('comentarios.*, usuarios.usuario, usuarios.imagen')
                    ->join('usuarios', 'comentarios.id_usuario = usuarios.id')
                    ->where('comentarios.id_libro', $id_libro)
                    ->orderBy('comentarios.fecha_publicacion', 'DESC')
                    ->findAll();
    }
    public function buscarComentariosDelLibro($termino, $libroId)
    {
        return $this->where('id_libro', $libroId)
                    ->like('contenido', $termino)
                    ->findAll();
    }
}