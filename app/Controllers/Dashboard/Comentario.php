<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Comentario extends BaseController
{
public function editar($id)
{
    // Buscar el comentario por ID
    $comentarioModel = new \App\Models\ComentarioModel();
    $comentario = $comentarioModel->find($id);

    // Verifica si el comentario existe y si el usuario logueado es el autor
    if ($comentario && $comentario['id_usuario'] === session()->get('id_usuario')) {
        // Muestra el formulario de edición con los datos del comentario
        return view('comentarios/editar', ['comentario' => $comentario]);
    } else {
        return redirect()->to('/'); // o la página que prefieras
    }
}

public function actualizar($idComentario) {
    if ($this->request->isAJAX()) {
        $jsonData = $this->request->getJSON();
        $contenido = $jsonData->contenido ?? '';

        $data = [
            'contenido' => $contenido,
        ];

        if ($comentarioModel->update($idComentario, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el comentario.']);
        }
        
}
public function borrar($id)
{
    $comentarioModel = new \App\Models\ComentarioModel();
    $comentario = $comentarioModel->find($id);

    if ($comentario && $comentario['id_usuario'] === session()->get('id_usuario')) {
        // Borrar el comentario
        $comentarioModel->delete($id);

        return redirect()->back(); // Redireccionar a la lista de comentarios
    } else {
        return redirect()->to('/');
    }
}

}