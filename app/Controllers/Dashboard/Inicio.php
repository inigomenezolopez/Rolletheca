<?php

// Define el espacio de nombres para el controlador Inicio, lo cual ayuda a organizar y evitar colisiones de nombres de clases.
namespace App\Controllers\Dashboard;

// Importa la clase BaseController, de la cual todos los controladores deben heredar en CodeIgniter.
use App\Controllers\BaseController;

// Importa el modelo CategoriaModel, que probablemente interactúa con la tabla de categorías en la base de datos.
use App\Models\CategoriaModel;

/**
 * Resumen de HomeController
 * Este comentario indica que la clase Inicio es un controlador que probablemente sirve como punto de entrada para la sección de inicio del dashboard.
 */
class Inicio extends BaseController
{
    /**
     * Resumen del método index
     * Este método sirve como acción por defecto para el controlador Inicio y se encarga de cargar y mostrar la vista de inicio del dashboard.
     * @return string Retorna una cadena, que es el resultado de la función view() de CodeIgniter, la cual carga un archivo de vista.
     */
    public function index(): string
    {
        // Crea una instancia del modelo CategoriaModel para interactuar con la base de datos.
        $categoriaModel = new CategoriaModel();
        
        // Devuelve la vista 'Dashboard/Inicio' y pasa un array con las categorías obtenidas de la base de datos a través del método findAll() del modelo.
        return view('Dashboard/Inicio', ['categorias' => $categoriaModel->findAll()]);
    }
}