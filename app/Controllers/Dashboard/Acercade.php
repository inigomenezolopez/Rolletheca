<?php

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;
/**
 * Summary of LibreriaController
 */
class Acercade extends BaseController
{
    /**
     * Summary of index
     * @return string
     */
    public function index(): string
    {
        return view('Dashboard/Acercade');
    }

    public function politica(): string
    {
        return view('Dashboard/politica');
    }
    public function terminos(): string
    {
        return view('Dashboard/terminos');
    }
}
