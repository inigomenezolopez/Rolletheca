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
        $libroEtiquetaModel = new LibreriaEtiquetaModel();
        // Obtener la categoría
        $categoria = $categoriaModel->find($id);
        if (!$categoria) {
            // Si la categoría no existe, puedes redireccionar o mostrar un error.
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }
    
        // Obtener las librerías por categoría con paginación
        $librerias = $libreriaModel->where('id_categoria', $id)->paginate(12); // Ejemplo, 12 items por página
    
        // Calcular la valoración media para cada libro
        foreach ($librerias as $key => $libreria) {
            // Aquí obtenemos la valoración media usando el método del modelo y el ID del libro
            $valoracionMedia = $libreriaModel->valoracionMedia($libreria->id);
            // Y aquí asignamos esa valoración media al objeto libro en su propiedad 'valoracionMedia'
            $librerias[$key]->valoracionMedia = $valoracionMedia;
        
            // Obtener las etiquetas para cada libro
            $etiquetas = $libroEtiquetaModel->where('id_libro', $libreria->id)
                                            ->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta')
                                            ->findAll();
            $librerias[$key]->etiquetas = $etiquetas; // Asignar etiquetas al libro actual en el bucle
        }
    
        // Pasar datos a la vista
        return view('Dashboard/categoria/ver', [
            'categoria' => $categoria,
            'libros' => $librerias, // Aquí 'libros' contendría la lista de 'librerias' con sus respectivas 'etiquetas'
            'pager' => $libreriaModel->pager // Pasamos también el pager para generar los enlaces en la vista.
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


