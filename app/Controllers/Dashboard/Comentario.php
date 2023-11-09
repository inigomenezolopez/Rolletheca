<?php

namespace App\Controllers\Dashboard;
use App\Models\ComentarioModel;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
class Comentario extends BaseController
{
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
            if (!$this->validate('comentarioReglas')) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }else{
            $comentarioModel->insert($data);
            }
            return redirect()->to('/libreria/ver/'. $data['id_libro'])->with('mensaje', 'Comentaria añadido con exito');
        } 
        
    }

    public function editar($id)
    {
        $comentarioModel = new ComentarioModel();
        $comentario = $comentarioModel->find($id);
        $usuarioSesion = session()->get('usuario');
        
        if (!$comentario || ($comentario->id_usuario !== $usuarioSesion->id && $usuarioSesion->rol !== 'admin')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar este comentario.');
        }

        return view('dashboard/Libreria/comentario_ver', ['comentario' => $comentario]);
    }

    public function actualizar($id)
    {
        $comentarioModel = new ComentarioModel();
    
        // Añadir 'valoracion' a las reglas si necesitas validarla
       
       

        if (!$this->validate('comentarioReglas')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $contenido = $this->request->getPost('contenido');
        $valoracion = $this->request->getPost('valoracion'); // Asumiendo que es un campo requerido
    
        // Asegúrate de que el comentario existe y que el usuario tiene permiso para actualizarlo
        $comentario = $comentarioModel->find($id);
        if (!$comentario) {
            return redirect()->back()->with('error', 'No existe el comentario.');
        }
    
        $userSession = session()->get('usuario');
        if ($comentario->id_usuario !== $userSession->id && $userSession->rol !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permiso para actualizar este comentario.');
        }
    
        // Actualizar el comentario
        $comentarioModel->update($id, [
            'contenido' => $contenido,
            'valoracion' => $valoracion // Añadir esto
        ]);
    
        // Redirigir a la página específica de la librería utilizando el id_libro del comentario
        return redirect()->to('/libreria/ver/' . $comentario->id_libro)->with('mensaje', 'Comentario actualizado correctamente.');
    }

public function borrar($id)
{
    $comentarioModel = new ComentarioModel();
    $comentario = $comentarioModel->find($id);

    if ($comentario) {
        $usuarioSesion = session()->get('usuario');
        
        // Verifica si el usuario de la sesión es el autor del comentario o si es un administrador
        if ($comentario->id_usuario === $usuarioSesion->id || $usuarioSesion->rol === 'admin') {
            $comentarioModel->delete($id);
            return redirect()->back()->with('mensaje', 'Comentario borrado con éxito.');
        } else {
            return redirect()->back()->with('error', 'No se pudo eliminar el comentario');
        }
}

}
}