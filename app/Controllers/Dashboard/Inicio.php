<?php

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;
use App\Models\CategoriaModel;
/**
 * Summary of HomeController
 */
class Inicio extends BaseController
{
    /**
     * Summary of index
     * @return string
     */
    public function index(): string
    {
        $categoriaModel = new CategoriaModel();
        
        return view('Dashboard/Inicio', ['categorias'=> $categoriaModel->findAll()
    ]);
    }
}
