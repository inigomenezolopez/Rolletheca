<?php

// Define el espacio de nombres para el controlador, lo que ayuda a evitar conflictos de nombres con clases de otros espacios de nombres.
namespace App\Controllers\Dashboard;

// Importa la clase BaseController, que es probablemente la clase padre común para los controladores en esta aplicación.
use App\Controllers\BaseController;


 
class Acercade extends BaseController
{
    /**
     * Resumen de la función index
     * Este método maneja la solicitud a la página de inicio del área 'Acerca de'.
     * 
     * @return string La función devuelve una vista que se renderizará como HTML en el navegador.
     */
    public function index(): string
    {
        // Carga y devuelve la vista 'Acercade' ubicada en la carpeta 'Dashboard'.
        return view('Dashboard/Acercade');
    }

    /**
     * Este método maneja la solicitud a la página de políticas.
     * 
     * @return string La función devuelve una vista que se renderizará como HTML en el navegador.
     */
    public function politica(): string
    {
        // Carga y devuelve la vista 'politica' ubicada en la carpeta 'Dashboard'.
        return view('Dashboard/politica');
    }

    /**
     * Este método maneja la solicitud a la página de términos y condiciones.
     * 
     * @return string La función devuelve una vista que se renderizará como HTML en el navegador.
     */
    public function terminos(): string
    {
        // Carga y devuelve la vista 'terminos' ubicada en la carpeta 'Dashboard'.
        return view('Dashboard/terminos');
    }
}