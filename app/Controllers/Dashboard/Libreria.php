<?php

// Define el espacio de nombres para la clase Libreria dentro del paquete App\Controllers\Dashboard
namespace App\Controllers\Dashboard;

// Importa clases necesarias para el controlador
use App\Controllers\BaseController;
use App\Models\{ComentarioModel, LibreriaModel, LibreriaEtiquetaModel, EtiquetaModel, CategoriaModel, UsuarioModel};
use CodeIgniter\I18n\Time;

/**
 * Controlador para manejar las operaciones de la biblioteca de libros.
 */
class Libreria extends BaseController
{
    /**
     * Muestra la lista de libros, con la posibilidad de filtrar por etiquetas.
     * @return string La vista generada.
     */
    public function index()
    {
        // Instancia los modelos necesarios para operar con la base de datos
        $libreriaModel = new LibreriaModel();
        $libroEtiquetaModel = new LibreriaEtiquetaModel();
        $etiquetaModel = new \App\Models\EtiquetaModel(); // Modelo para las etiquetas

           // Verifica si hay parámetros de filtro de etiquetas y aplica el filtro si es necesario
    $etiquetasSeleccionadas = $this->request->getGet('etiquetas') ?? [];
    if (!empty($etiquetasSeleccionadas)) {
        // Aplicar el filtrado de libros por las etiquetas seleccionadas
        
        $libros = $libreriaModel->filtrarPorEtiquetas($etiquetasSeleccionadas);
    } else {
        // Si no hay etiquetas seleccionadas, obtener todos los libros sin filtrar
        $libreriaModel->select('librerias.*, categorias.nombre AS categoria')
                      ->join('categorias', 'categorias.id = librerias.id_categoria');
        $libros = $libreriaModel->paginate(12);
    }

         // Calcular la valoración media para cada libro y obtener sus etiquetas
    foreach ($libros as $key => $libro) {
        $libros[$key]->valoracionMedia = $libreriaModel->valoracionMedia($libro->id);
        $etiquetas = $libroEtiquetaModel->where('id_libro', $libro->id)
                                        ->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta')
                                        ->findAll();
        $libros[$key]->etiquetas = $etiquetas;
    }

        // Obtener todas las etiquetas para mostrar en el filtro
        $todasLasEtiquetas = $etiquetaModel->findAll();

        // Pasar los datos a la vista
        $data = [
            'libros' => $libros,
            'pager' => $libreriaModel->pager,
            'todasLasEtiquetas' => $todasLasEtiquetas, // Añadir las etiquetas al array de datos
            'etiquetasSeleccionadas' => $etiquetasSeleccionadas,
        ];

        // Carga la vista con los datos de libros y etiquetas
        return view('Dashboard/Libreria/libreria', $data);
    }

    
    public function new()
{
    // Instancia los modelos para las etiquetas y categorías
    $etiquetaModel = new EtiquetaModel;
    $categoriaModel = new CategoriaModel;
    // Recupera todas las etiquetas disponibles
    $etiquetas = $etiquetaModel->find();

    // Pasa los datos necesarios a la vista 'crear'
    return view('Dashboard/Libreria/crear', [
        'libreria' => new LibreriaModel(), // Instancia un nuevo modelo Libreria
        'categoria' => $categoriaModel->find(), // Obtiene todas las categorías
        'etiqueta' => $etiquetas // Pasa las etiquetas recuperadas
    ]);
}

/**
 * Método para procesar la creación de un nuevo libro después de que se envía el formulario.
 * @return \CodeIgniter\HTTP\RedirectResponse Redirección según el resultado de la operación.
 */
public function create()
{
    // Comienza validando los datos del formulario usando el grupo de reglas 'librerias'
    if ($this->validate('librerias')) {
        // Instancia el modelo para la librería y para las etiquetas del libro
        $libreriaModel = new LibreriaModel();
        $libroEtiquetaModel = new LibreriaEtiquetaModel();
        // Recupera el archivo de imagen enviado
        $img = $this->request->getFile('imagen');

        // Verifica si la imagen es válida y no se ha movido aún
        if ($img->isValid() && !$img->hasMoved()) {
            // Genera un nuevo nombre aleatorio para la imagen y la mueve al directorio especificado
            $nuevoNombre = $img->getRandomName();
            $img->move(FCPATH . 'images/libreria', $nuevoNombre);

            // Guarda los datos del libro en la base de datos
            $idLibreria = $libreriaModel->insert([
                'titulo' => $this->request->getPost('titulo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'fecha_subida' => Time::now(),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'ruta_archivo' => $nuevoNombre,
            ]);

            // Verifica si se seleccionaron etiquetas y las asocia con el libro
            $etiquetasSeleccionadas = $this->request->getPost('etiquetas');
            if ($etiquetasSeleccionadas) {
                foreach ($etiquetasSeleccionadas as $idEtiqueta) {
                    $libroEtiquetaModel->insert([
                        'id_libro' => $idLibreria,
                        'id_etiqueta' => $idEtiqueta
                    ]);
                }
            }

            // Establece un mensaje de sesión para notificar que el proceso fue exitoso
            session()->setFlashdata('mensaje', 'Datos guardados exitosamente');
            // Redirecciona al usuario a la lista de libros
            return redirect()->to('/libreria');
        } else {
            // Si hay un error con la imagen, establece un mensaje de error
            session()->setFlashdata('errors', $img->getErrorString());
            // Redirige al usuario de vuelta al formulario con los datos previamente ingresados
            return redirect()->back()->withInput();
        }
    } else {
        // Si la validación del formulario falla, establece los mensajes de error
        session()->setFlashdata('errors', $this->validator->getErrors());
        // Redirige al usuario de vuelta al formulario con los datos previamente ingresados
        return redirect()->back()->withInput();
    }
}
public function filtrarPorEtiquetas()
{
    // Recupera las etiquetas seleccionadas del parámetro GET 'etiquetas' o asigna un array vacío si no hay ninguna
    $etiquetasSeleccionadas = $this->request->getGet('etiquetas') ?? [];
    // Instancia el modelo de libros
    $libroModel = new \App\Models\LibroModel();

    // Llama al método del modelo para obtener libros filtrados por las etiquetas seleccionadas
    $libros = $libroModel->filtrarPorEtiquetas($etiquetasSeleccionadas);
    
    // Devuelve la vista parcial '_libros' con los libros filtrados pasados como variable
    return view('libreria/partials/_libros', ['libros' => $libros]);
}

/**
 * Método para mostrar la vista detallada de un libro específico.
 * @param int|null $id El ID del libro a mostrar.
 * @return void Imprime directamente la vista generada con todos los datos relacionados al libro.
 */
public function show($id = null)
{
    // Instancia los modelos necesarios para obtener la información
    $libreriaModel = new LibreriaModel();
    $comentarioModel = new ComentarioModel();
    $usuarioModel = new UsuarioModel();
    $libroEtiquetaModel = new LibreriaEtiquetaModel(); // Este modelo interactúa con la tabla de relación libro_etiqueta

    // Obtiene el libro, comentarios y usuario utilizando los ID proporcionados
    $libro = $libreriaModel->find($id);
    $comentarios = $comentarioModel->getComentariosConUsuario($id);
    $usuarios = $usuarioModel->find($id);

    // Obtiene las etiquetas relacionadas al libro uniendo las tablas libro_etiqueta y etiquetas
    $etiquetas = $libroEtiquetaModel->where('id_libro', $id)
                                     ->join('etiquetas', 'etiquetas.id = libro_etiqueta.id_etiqueta')
                                     ->findAll();
    // Agrega las etiquetas al objeto del libro
    $libro->etiquetas = $etiquetas;

    // Imprime la vista 'ver' del dashboard de librería con todos los datos recolectados
    echo view('Dashboard/Libreria/ver', [
        'libro' => $libro,
        'comentarios' => $comentarios,
        'usuarios' => $usuarios,
        'etiquetas' => $etiquetas
    ]);
}
   
     // Método para editar los detalles de un libro por su ID.
     public function edit($id = null)
     {
         // Instanciar los modelos necesarios para obtener información del libro, categorías y etiquetas.
         $libreriaModel = new LibreriaModel;
         $categoriaModel = new CategoriaModel;
         $etiquetaModel = new EtiquetaModel; // Asumiendo que tienes un modelo para 'Etiquetas'.
         $libroEtiquetaModel = new LibreriaEtiquetaModel;
 
         // Buscar la información del libro a editar.
         $libro = $libreriaModel->find($id);
 
         // Obtener la categoría del libro para luego buscar etiquetas relacionadas.
         $categoria = $categoriaModel->find($libro->id_categoria);
 
         // Obtener todas las etiquetas que pertenecen a la misma categoría del libro.
         $etiquetasDeLaCategoria = $etiquetaModel->where('id_categoria', $categoria->id)->findAll();
 
         // Obtener todas las etiquetas que ya están asignadas al libro.
         $etiquetasAsignadas = $libroEtiquetaModel->where('id_libro', $id)->findAll();
 
         // Preparar los IDs de las etiquetas asignadas para la vista.
         $etiquetasAsignadasIds = array_column($etiquetasAsignadas, 'id_etiqueta');
 
         // Pasar los datos obtenidos a la vista de edición.
         echo view('Dashboard/Libreria/editar', [
             'libro' => $libro,
             'categorias' => $categoriaModel->findAll(),
             'etiquetasDeLaCategoria' => $etiquetasDeLaCategoria,
             'etiquetasAsignadasIds' => $etiquetasAsignadasIds
         ]);
     }
 
     // Método para actualizar los detalles de un libro, incluyendo imagen y etiquetas.
     public function update($id = null)
     {
         // Verificar que los datos enviados cumplen con las reglas de validación definidas.
         if ($this->validate('librerias')) {
             // Instanciar los modelos necesarios.
             $libreriaModel = new LibreriaModel;
             $libroEtiquetaModel = new LibreriaEtiquetaModel();
 
             // Procesar la imagen enviada en el formulario si es que se ha subido una nueva.
             $img = $this->request->getFile('imagen');
             $ruta_archivo = $this->request->getPost('ruta_archivo_actual'); // Conservar la ruta actual si no se sube una nueva imagen.
 
             // Verificar si se ha subido una imagen y si es válida para moverla al directorio correspondiente.
             if ($img->isValid() && !$img->hasMoved()) {
                 $nuevoNombre = $img->getRandomName();
                 $img->move(FCPATH . 'images/libreria', $nuevoNombre);
                 $ruta_archivo = $nuevoNombre; // Actualizar la ruta de archivo si se sube una nueva imagen.
             }
 
             // Actualizar los datos del libro con la nueva información proporcionada.
             $libreriaModel->update($id, [
                 'titulo' => $this->request->getPost('titulo'),
                 'descripcion' => $this->request->getPost('descripcion'),
                 'id_categoria' => $this->request->getPost('id_categoria'),
                 'ruta_archivo' => $ruta_archivo
             ]);
 
             // Actualizar las etiquetas del libro, primero eliminando las existentes y luego insertando las nuevas.
             $etiquetas = $this->request->getPost('etiquetas');
             if ($etiquetas) {
                 $libroEtiquetaModel->where('id_libro', $id)->delete();
                 foreach ($etiquetas as $id_etiqueta) {
                     $libroEtiquetaModel->insert([
                         'id_libro' => $id,
                         'id_etiqueta' => $id_etiqueta
                     ]);
                 }
             }
         } else {
             // Si la validación falla, redirigir al usuario al formulario con los errores de validación.
             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
         }
         // Configurar un mensaje de sesión para indicar que la actualización fue exitosa y redirigir al usuario.
         session()->setFlashdata('mensaje', 'Datos cambiados exitosamente');
         return redirect()->to('/libreria');
     }
 
     // Método para obtener las etiquetas asociadas a una categoría específica, devolviendo los datos en formato JSON.
     public function etiquetasPorCategoria($idCategoria)
     {
         $etiquetaModel = new EtiquetaModel(); // Utilizar el modelo de Etiquetas para obtener los datos.
         $etiquetas = $etiquetaModel->where('id_categoria', $idCategoria)->findAll();
     
         // Devolver las etiquetas como respuesta JSON.
         return $this->response->setJSON($etiquetas);
     }
 
     // Método para eliminar un libro por su ID.
     public function delete($id = null)
     {
         $libreriaModel = new LibreriaModel;
         $libreriaModel->find($id);
         $libreriaModel->delete($id);
 
         // Configurar un mensaje de sesión para indicar que el libro fue eliminado y redirigir al usuario.
         session()->setFlashdata('mensaje', 'Datos borrados exitosamente');
         return redirect()->back();
     }
 
     // Método para mostrar las librerías filtradas por categoría.
     public function mostrarLibreriasPorCategoria($categoriaName) {
         $libreriaModel = new LibreriaModel;
         // Obtener las librerías que pertenecen a una categoría específica.
         $data['librerias'] = $this->LibreriaModel->getLibreriasByCategoria($categoriaName);
         // Pasar los datos a la vista correspondiente.
         return view('/categoria/ver/', $data);
     }
 
     // Método para asignar etiquetas a un libro.
     public function asignarEtiquetas($idLibro, $etiquetas) {
         $libroEtiquetaModel = new LibreriaEtiquetaModel();
         
         // Eliminar las etiquetas actuales.
         $libroEtiquetaModel->where('id_libro', $idLibro)->delete();
         
         // Asignar las nuevas etiquetas.
         foreach ($etiquetas as $id_etiqueta) {
             $libroEtiquetaModel->insert([
                 'id_libro' => $idLibro,
                 'id_etiqueta' => $id_etiqueta
             ]);
         }
         
         // Configurar un mensaje de sesión para indicar que las etiquetas fueron asignadas y redirigir al usuario.
         session()->setFlashdata('mensaje', 'Etiquetas asignadas correctamente');
         return redirect()->back();
     }
    }