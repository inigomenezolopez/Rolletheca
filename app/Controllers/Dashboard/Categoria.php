<?php

namespace App\Controllers\Dashboard;
use App\Models\CategoriaModel;
use App\Models\LibreriaEtiquetaModel;
use App\Controllers\BaseController;
use App\Models\LibreriaModel;

class Categoria extends BaseController
{
    public function index()

    {   
        $categoriaModel = new CategoriaModel;
        return view('Dashboard/categoria/categoria', ['categorias'=> $categoriaModel->findAll()]);
    }


    public function new()
    {
        return view('Dashboard/categoria/crear');
    }

    public function create() {
        helper(['form', 'url']);
        
        if ($this->validate('categorias')) {
            $categoriaModel = new CategoriaModel;
    
            $imagen = $this->request->getFile('imagen');
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                $nombreImagenNuevo = $imagen->getRandomName();
                $imagen->move(FCPATH . 'images/categoria', $nombreImagenNuevo);
            } else {
                return redirect()->back()->with('mensaje', 'No se pudo cargar la imagen')->withInput();
            }
    
            $categoriaModel->insert([
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
                'imagen' => $nombreImagenNuevo,
            ]);
    
            session()->setFlashdata('mensaje', 'Datos guardados exitosamente');
            return redirect()->to('/categoria');
        } else {
            session()->setFlashdata([
                'validation' => $this->validator->listErrors()
            ]);
            return redirect()->back()->withInput();
        }
    }

    public function show($id = null)
{
    // Instanciar modelos
    $categoriaModel = new CategoriaModel();
    $libreriaModel = new LibreriaModel();
    $etiquetaModel = new \App\Models\EtiquetaModel(); // Modelo para las etiquetas

    // Obtener la categoría
    $categoria = $categoriaModel->find($id);
    if (!$categoria) {
        return redirect()->back()->with('error', 'Categoría no encontrada.');
    }

    // Verificar si hay parámetros de filtro de etiquetas
    $etiquetasSeleccionadas = $this->request->getGet('etiquetas') ?? [];

    // Obtener todas las etiquetas disponibles para el filtro dentro de la categoría seleccionada
    $todasLasEtiquetas = $etiquetaModel->where('id_categoria', $id)->findAll();

    // Aplicar el filtrado si hay etiquetas seleccionadas
    if ($etiquetasSeleccionadas) {
        $librerias = $libreriaModel->filtrarPorEtiquetasCategoria($etiquetasSeleccionadas, $id);
    } else {
        // Obtener las librerías por categoría sin filtrar por etiquetas
        $librerias = $libreriaModel->where('id_categoria', $id)->paginate(12); // Ejemplo, 12 items por página
    }

    foreach ($librerias as $key => $libreria) {
        $librerias[$key]->valoracionMedia = $libreriaModel->valoracionMedia($libreria->id);
        $librerias[$key]->etiquetas = $etiquetaModel
            ->select('etiquetas.*')
            ->join('libro_etiqueta', 'libro_etiqueta.id_etiqueta = etiquetas.id')
            ->where('libro_etiqueta.id_libro', $libreria->id)
            ->findAll();
    }

    // Pasar datos a la vista
    return view('Dashboard/categoria/ver', [
        'categoria' => $categoria,
        'libros' => $librerias,
        'pager' => $libreriaModel->pager,
        'todasLasEtiquetas' => $todasLasEtiquetas,
        'etiquetasSeleccionadas' => $etiquetasSeleccionadas
    ]);
}
    
    


    public function edit($id = null)
    {
        $categoriaModel = new categoriaModel;
        
       echo view('Dashboard/categoria/editar',[
        'categorias' => $categoriaModel->find($id)
       ]);
    }

    public function update($id = null)
    {
        if ($this->validate('categorias')) {
    
            $categoriaModel = new CategoriaModel;
    
            // Manejar la carga de archivos
            $img = $this->request->getFile('imagen');
            if ($img->isValid() && !$img->hasMoved()) {
                $nuevoNombre = $img->getRandomName();
                $img->move(FCPATH . 'images/categoria', $nuevoNombre);
            }
    
            // Preparar datos para la actualización
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
            ];
            if (isset($nuevoNombre)) {
                $data['imagen'] = $nuevoNombre;
            }
    
            // Actualizar la categoría
            $categoriaModel->update($id, $data);
    
        } else {
            session()->setFlashdata('validation', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    
        session()->setFlashdata('mensaje', 'Datos cambiados exitosamente');
        return redirect()->to('/categoria');
    }
    public function delete($id = null)
    {
        
        $categoriaModel = new categoriaModel;
        $categoriaModel->find($id);
       $categoriaModel->delete($id);

       session()->setFlashdata('mensaje', 'Datos borrados exitosamente');
        return redirect()->back();
    }
}


