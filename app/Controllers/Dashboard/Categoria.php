<?php

// Definición del espacio de nombres para este controlador, situado en la carpeta de 'Dashboard' de 'Controllers'.
namespace App\Controllers\Dashboard;

// Importaciones de modelos que interactúan con la base de datos y la clase 'BaseController'.
use App\Models\CategoriaModel;
use App\Models\LibreriaModel;
use App\Controllers\BaseController;

// La clase 'Categoria' hereda de 'BaseController' y gestiona todas las acciones relacionadas con las categorías.
class Categoria extends BaseController
{
    // Método que se ejecuta al acceder a la lista de categorías. Por ejemplo: '/categoria'.
    public function index()
    {   
        // Instancia el modelo 'CategoriaModel'.
        $categoriaModel = new CategoriaModel;
        
        // Devuelve la vista de categorías junto con todas las categorías obtenidas de la base de datos.
        return view('Dashboard/categoria/categoria', ['categorias'=> $categoriaModel->findAll()]);
    }

    // Método para mostrar el formulario de creación de una nueva categoría.
    public function new()
    {
        // Devuelve la vista que contiene el formulario para crear una nueva categoría.
        return view('Dashboard/categoria/crear');
    }

    // Método que procesa la creación de una nueva categoría.
    public function create() {
        // Carga los helpers 'form' y 'url' que son funciones de ayuda para formularios y URLs.
        helper(['form', 'url']);
        
        // Verifica si la validación del formulario de categorías es correcta.
        if ($this->validate('categorias')) {
            // Si la validación es exitosa, crea una nueva instancia de 'CategoriaModel'.
            $categoriaModel = new CategoriaModel;
    
            // Recupera el archivo de imagen del formulario.
            $imagen = $this->request->getFile('imagen');
            // Verifica si el archivo es válido y no se ha movido aún.
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                // Genera un nuevo nombre aleatorio para la imagen y la mueve al directorio especificado.
                $nombreImagenNuevo = $imagen->getRandomName();
                $imagen->move(FCPATH . 'images/categoria', $nombreImagenNuevo);
            } else {
                // Si no se puede cargar la imagen, redirecciona al formulario con un mensaje de error.
                return redirect()->back()->with('mensaje', 'No se pudo cargar la imagen')->withInput();
            }
    
            // Inserta la nueva categoría en la base de datos con los datos recibidos del formulario y la imagen.
            $categoriaModel->insert([
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
                'imagen' => $nombreImagenNuevo,
            ]);
    
            // Establece un mensaje de sesión para notificar que la operación fue exitosa y redirige al listado de categorías.
            session()->setFlashdata('mensaje', 'Datos guardados exitosamente');
            return redirect()->to('/categoria');
        } else {
            // Si la validación falla, establece los errores de validación en la sesión y redirige al formulario.
        session()->setFlashdata('errors', $this->validator->getErrors());
       return redirect()->back()->withInput();
        }
    }

    // Método para mostrar una categoría específica junto con sus libros asociados.
    public function show($id = null)
    {
        // Instancia los modelos necesarios.
        $categoriaModel = new CategoriaModel();
        $libreriaModel = new LibreriaModel();
        $etiquetaModel = new \App\Models\EtiquetaModel(); // Modelo para las etiquetas

        // Encuentra la categoría por su ID y devuelve error si no existe.
        $categoria = $categoriaModel->find($id);
        if (!$categoria) {
             session()->setFlashdata('mensaje', 'Categoría no encontrada.');
            return redirect()->back()->withInput();
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


        // Devuelve la vista con los datos de la categoría, libros y paginación.
        return view('Dashboard/categoria/ver', [
            'categoria' => $categoria,
            'libros' => $librerias,
            'pager' => $libreriaModel->pager,
            'todasLasEtiquetas' => $todasLasEtiquetas,
            'etiquetasSeleccionadas' => $etiquetasSeleccionadas
        ]);
    }
    
    

// Método para mostrar la vista de edición de una categoría específica.
public function edit($id = null)
{
    // Crea una instancia del modelo de categorías.
    $categoriaModel = new categoriaModel;
    
    // Devuelve la vista de edición y pasa los datos de la categoría solicitada a la vista.
    echo view('Dashboard/categoria/editar',[
        'categorias' => $categoriaModel->find($id)
    ]);
}

// Método para procesar la actualización de una categoría.
public function update($id = null)
{
    // Valida los datos del formulario según las reglas definidas en el archivo de configuración de validación.
    if ($this->validate('categorias')) {

        // Crea una instancia del modelo de categorías.
        $categoriaModel = new CategoriaModel;

        // Maneja la carga de archivos de imagen.
        $img = $this->request->getFile('imagen');
        // Si la imagen es válida y no se ha movido aún, genera un nuevo nombre y la mueve a la carpeta de imágenes.
        if ($img->isValid() && !$img->hasMoved()) {
            $nuevoNombre = $img->getRandomName();
            $img->move(FCPATH . 'images/categoria', $nuevoNombre);
        }

        // Prepara los datos para la actualización con la información recibida del formulario.
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];
        // Si se subió una nueva imagen, incluye la referencia de la imagen en el arreglo de datos.
        if (isset($nuevoNombre)) {
            $data['imagen'] = $nuevoNombre;
        }

        // Actualiza los datos de la categoría en la base de datos.
        $categoriaModel->update($id, $data);

    } else {
        // Si la validación falla, establece los errores de validación en la sesión.
       // Gestiona el error si la validación del formulario falla.
       session()->setFlashdata('errors', $this->validator->getErrors());
       return redirect()->back()->withInput();
    }

    // Establece un mensaje de éxito en la sesión.
    session()->setFlashdata('mensaje', 'Datos cambiados exitosamente');
    // Redirige al usuario a la lista de categorías.
    return redirect()->to('/categoria');
}

// Método para eliminar una categoría.
public function delete($id = null)
{
    // Crea una instancia del modelo de categorías.
    $categoriaModel = new categoriaModel;
    // Busca la categoría por su ID y luego la elimina de la base de datos.
    $categoriaModel->find($id);
    $categoriaModel->delete($id);

    // Establece un mensaje de éxito en la sesión.
    session()->setFlashdata('mensaje', 'Datos borrados exitosamente');
    // Redirige al usuario a la vista anterior.
    return redirect()->back();
}
}


