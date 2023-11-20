<?php

// Definir el espacio de nombres para el controlador, lo que ayuda a organizar el código y evitar conflictos de nombres.
namespace App\Controllers\Dashboard;

// Importar las clases necesarias que se utilizarán en este controlador.
use App\Models\UsuarioModel;
use App\Models\ComentarioModel;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

// Crear la clase Comentario que extiende de BaseController, la clase base para todos los controladores en CodeIgniter.
class Comentario extends BaseController
{
    // Método para agregar un nuevo comentario.
    public function agregar()
    {
        // Instanciar el modelo de comentarios para interactuar con la base de datos.
        $comentarioModel = new ComentarioModel();
    
        // Verificar si hay un usuario en la sesión actual.
        $usuario = session()->get('usuario');
        // Si hay un usuario y tiene un ID, proceder con la creación del comentario.
        if ($usuario && isset($usuario->id)) {
            // Recoger los datos del formulario y la fecha actual para crear un nuevo comentario.
            $data = [
                'id_libro' => $this->request->getPost('id_libro'),
                'id_usuario' => $usuario->id,
                'contenido' => $this->request->getPost('contenido'),
                'fecha_publicacion' => Time::now(),
                'valoracion'=> $this->request->getPost('valoracion')
            ];
            // Validar los datos del formulario con un conjunto de reglas predefinidas.
            if (!$this->validate('comentarioReglas')) {
                // Si la validación falla, redirigir al usuario a la página anterior con errores y datos de entrada.
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }else{
                // Si la validación es exitosa, insertar el nuevo comentario en la base de datos.
                $comentarioModel->insert($data);
            }
            // Redirigir al usuario a la página del libro con un mensaje de éxito.
            return redirect()->to('/libreria/ver/'. $data['id_libro'])->with('mensaje', 'Comentario añadido con exito');
        } 
        
    }

    // Método para mostrar la vista de edición de un comentario específico.
    public function editar($id)
    {
        // Instanciar el modelo de comentarios.
        $comentarioModel = new ComentarioModel();
        // Buscar el comentario por su ID.
        $comentario = $comentarioModel->find($id);
        // Obtener el usuario actual de la sesión.
        $usuarioSesion = session()->get('usuario');
        
        // Verificar si el comentario existe y si el usuario tiene permiso para editarlo.
        // Solo el autor del comentario o un administrador pueden editar.
        if (!$comentario || ($comentario->id_usuario !== $usuarioSesion->id && $usuarioSesion->rol !== 'admin')) {
            // Si no tiene permiso, redirigir al usuario a la página anterior con un mensaje de error.
            return redirect()->back()->with('mensaje', 'No tienes permiso para editar este comentario.');
        }

        // Si tiene permiso, mostrar la vista de edición del comentario con los datos del comentario.
        return view('dashboard/Libreria/comentario_ver', ['comentario' => $comentario]);
    }

    // Método para actualizar un comentario en la base de datos.
    public function actualizar($id)
    {
        // Instanciar el modelo de comentarios.
        $comentarioModel = new ComentarioModel();
    
        // Validar los datos del formulario.
        if (!$this->validate('comentarioReglas')) {
            // Si la validación falla, redirigir con errores.
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Obtener los datos actualizados del formulario.
        $contenido = $this->request->getPost('contenido');
        $valoracion = $this->request->getPost('valoracion'); // Asumiendo que es un campo requerido
    
        // Verificar si el comentario existe y si el usuario tiene permiso para actualizarlo.
        $comentario = $comentarioModel->find($id);
        if (!$comentario) {
            // Si el comentario no existe, redirigir con un mensaje de error.
            return redirect()->back()->with('mensaje', 'No existe el comentario.');
        }
    
        // Verificar si el usuario es el autor o un administrador para permitir la actualización.
        $userSession = session()->get('usuario');
        if ($comentario->id_usuario !== $userSession->id && $userSession->rol !== 'admin') {
            // Si no tiene permiso, redirigir con un mensaje de error.
            return redirect()->back()->with('mensaje', 'No tienes permiso para actualizar este comentario.');
        }
    
        // Actualizar el comentario en la base de datos con los nuevos datos.
        $comentarioModel->update($id, [
            'contenido' => $contenido,
            'valoracion' => $valoracion // Añadir esto
        ]);
    
        // Redirigir a la página del libro específico con un mensaje de éxito.
        return redirect()->to('/libreria/ver/' . $comentario->id_libro)->with('mensaje', 'Comentario actualizado correctamente.');
    }

    // Método para borrar un comentario de la base de datos.
    public function borrar($id)
    {
        // Instanciar el modelo de comentarios.
        $comentarioModel = new ComentarioModel();
        // Buscar el comentario por su ID.
        $comentario = $comentarioModel->find($id);

        // Si el comentario existe, verificar si el usuario tiene permiso para borrarlo.
        if ($comentario) {
            $usuarioSesion = session()->get('usuario');
            
            // Si el usuario es el autor o un administrador, proceder a borrar el comentario.
            if ($comentario->id_usuario === $usuarioSesion->id || $usuarioSesion->rol === 'admin') {
                $comentarioModel->delete($id);
                // Redirigir al usuario a la página anterior con un mensaje de éxito.
                return redirect()->back()->with('mensaje', 'Comentario borrado correctamente.');
            }
        }
    }

    // Método para buscar comentarios
    public function buscarComentario()
    {
        $libroId = $this->request->getGet('id_libro');
        $query = $this->request->getGet('q');
        
        $comentarioModel = new ComentarioModel();
        $comentarios = $comentarioModel->buscarComentariosDelLibro($query, $libroId);

        return $this->response->setJSON($comentarios);
    }
}