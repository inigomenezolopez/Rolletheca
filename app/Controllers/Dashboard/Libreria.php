<?php

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;
use App\Models\ComentarioModel;
use App\Models\LibreriaModel;
use App\Models\LibreriaEtiquetaModel;
use App\Models\EtiquetaModel;
use App\Models\CategoriaModel;
use App\Models\UsuarioModel;
use CodeIgniter\I18n\Time;

/**
 * Summary of LibreriaController
 */
class Libreria extends BaseController
{
    /**
     * Summary of index
     * @return string
     */
    public function index()
    {   
        $libreriaModel = new LibreriaModel;
        $libroEtiquetaModel = new LibreriaEtiquetaModel(); // Este modelo debería manejar las operaciones en la tabla libro_etiqueta
    
        // Obtener los libros con su categoría correspondiente
        $libreriaModel->select('librerias.*, categorias.nombre AS categoria')
                      ->join('categorias', 'categorias.id = librerias.id_categoria');
        $libros = $libreriaModel->paginate(12);
    
        // Calcular la valoración media para cada libro
        foreach ($libros as $key => $libro) {
            $libros[$key]->valoracionMedia = $libreriaModel->valoracionMedia($libro->id);
    
            // Obtener las etiquetas para cada libro
            $etiquetas = $libroEtiquetaModel->where('id_libro', $libro->id)
                                            ->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta')
                                            ->findAll();
            $libros[$key]->etiquetas = $etiquetas;
        }
    
        $data['libros'] = $libros;
        $data['pager'] = $libreriaModel->pager;
    
        return view('Dashboard/Libreria/libreria', $data);
    }

    
    public function new()
    {
        $etiquetaModel = new EtiquetaModel;
        $categoriaModel = new CategoriaModel;
        return view('Dashboard/Libreria/crear',[
            'libreria'=> new LibreriaModel(),
            'categoria'=> $categoriaModel->find(),
            'etiqueta'=> $etiquetaModel->find()

        ]);

    }

    public function create()
    {
        if ($this->validate('librerias')) {
            $libreriaModel = new LibreriaModel;
            $libroEtiquetaModel = new LibreriaEtiquetaModel(); // Asegúrate de que este modelo existe y está correctamente definido

            $img = $this->request->getFile('imagen');
        if ($img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move(FCPATH . 'images/libreria', $nuevoNombre);
            // Guardar los datos básicos de la librería
            $idLibreria = $libreriaModel->insert([
                'titulo' => $this->request->getPost('titulo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'fecha_subida' => Time::now(),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'ruta_archivo' => $nuevoNombre, // Asumiendo que también manejas una carga de archivos
            ]);
    
            // Verificar si se recibieron etiquetas
            $etiquetasSeleccionadas = $this->request->getPost('etiquetas');
            if ($etiquetasSeleccionadas) {
                // Guardar cada etiqueta seleccionada para la librería
                foreach ($etiquetasSeleccionadas as $idEtiqueta) {
                    $libroEtiquetaModel->insert([
                        'id_libro' => $idLibreria, // Asegúrate de que este campo coincida con el nombre en tu BD
                        'id_etiqueta' => $idEtiqueta
                    ]);
                }
            }
    
            session()->setFlashdata('mensaje', 'Datos guardados exitosamente');
            return redirect()->to('/libreria');
        } else {
            session()->setFlashdata([
                'validation' => $this->validator->listErrors()
            ]);
            return redirect()->back()->withInput();
        }
    }
    }
  
    public function show($id = null)
{
    // Modelos
    $libreriaModel = new LibreriaModel;
    $comentarioModel = new ComentarioModel;
    $usuarioModel = new UsuarioModel;
    $libroEtiquetaModel = new LibreriaEtiquetaModel(); // Este modelo maneja las operaciones en la tabla libro_etiqueta

    // Obteniendo datos
    $libro = $libreriaModel->find($id);
    $comentarios = $comentarioModel->getComentariosConUsuario($id);
    $usuarios = $usuarioModel->find($id);

    // Obtener las etiquetas para el libro
    $etiquetas = $libroEtiquetaModel->where('id_libro', $id)
                                     ->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta')
                                     ->findAll();
    $libro->etiquetas = $etiquetas; // Asegúrate de que la entidad 'libro' sea capaz de almacenar propiedades dinámicas

    // Pasando datos a la vista
   // Pasando datos a la vista
   echo view('Dashboard/Libreria/ver', [
    'libro' => $libro,
    'comentarios' => $comentarios,
    'usuarios' => $usuarios , 
    'etiquetas'=> $etiquetas
]);
}
    public function agregar()
    {
        $comentarioModel = new ComentarioModel();
    
        // Verificar si el usuario está en la sesión
        $usuario = session()->get('usuario');
        if ($usuario && isset($usuario->id)) {
            $data = [
                'id_libro' => $this->request->getPost('id_libro'),
                'id_usuario' => $usuario->id,
                'contenido' => $this->request->getPost('contenido'),
                'fecha_publicacion' => Time::now(),
                'valoracion'=> $this->request->getPost('valoracion')
            ];
    
            $comentarioModel->insert($data);
    
            return redirect()->to('/libreria/ver/'. $data['id_libro']);
        } else {
            session()->setFlashdata('mensaje', 'Debes estar logueado para comentar');
            return redirect()->to(route_to('usuario.login'));
        }
    }
    public function edit($id = null)
    {
        $libreriaModel = new LibreriaModel;
        $categoriaModel = new CategoriaModel;
       echo view('Dashboard/Libreria/editar',[
        'libros' => $libreriaModel->find($id),
        'categoria' => $categoriaModel->find()
       ]);
    }

    public function update($id = null)
{
    if ($this->validate('librerias')) {
        $libreriaModel = new LibreriaModel;
        $libroEtiquetaModel = new LibreriaEtiquetaModel(); // Suponiendo que tienes un modelo para la relación libro-etiqueta
        $img = $this->request->getFile('imagen');
        $ruta_archivo = $this->request->getPost('ruta_archivo_actual'); // Conservar la imagen actual si no hay una nueva

        if ($img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move(FCPATH . 'images/libreria', $nuevoNombre);
            $ruta_archivo = $nuevoNombre; // Actualizar con la nueva imagen
        }

        // Actualizar datos de la librería
        $libreriaModel->update($id, [
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'id_categoria' => $this->request->getPost('id_categoria'),
            'ruta_archivo' => $ruta_archivo
        ]);

        // Actualizar etiquetas
        $etiquetas = $this->request->getPost('etiquetas');
        if ($etiquetas) {
            $libroEtiquetaModel->where('id_libro', $id)->delete(); // Eliminar las etiquetas actuales
            foreach ($etiquetas as $id_etiqueta) {
                $libroEtiquetaModel->insert([
                    'id_libro' => $id,
                    'id_etiqueta' => $id_etiqueta
                ]);
            }
        }
    } else {
        session()->setFlashdata('validation', $this->validator->listErrors());
        return redirect()->back()->withInput();
    }
    session()->setFlashdata('mensaje', 'Datos cambiados exitosamente');
    return redirect()->to('/libreria');
}
    public function etiquetasPorCategoria($idCategoria)
    {
        $etiquetaModel = new EtiquetaModel(); // Usa el modelo correcto para la tabla de etiquetas
        $etiquetas = $etiquetaModel->where('id_categoria', $idCategoria)->findAll();
    
        return $this->response->setJSON($etiquetas);
    }

    public function delete($id = null)
    {
        
        $libreriaModel = new LibreriaModel;
        $libreriaModel->find($id);
       $libreriaModel->delete($id);

       session()->setFlashdata('mensaje', 'Datos borrados exitosamente');
        return redirect()->back();
    }


    public function mostrarLibreriasPorCategoria($categoriaName) {
        $libreriaModel = new LibreriaModel;
        $data['librerias'] = $this->LibreriaModel->getLibreriasByCategoria($categoriaName);
        return view('/categoria/ver/', $data);
    }

    public function asignarEtiquetas()
    {
        $idLibro = $this->request->getPost('id_libro');
        $etiquetas = $this->request->getPost('etiquetas');

        $modeloRelacion = new \App\Models\LibroEtiquetaModel();
        $modeloRelacion->asignarEtiquetas($idLibro, $etiquetas);
    }
}
