<?php

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;
/**
 * Summary of HomeController
 */
class Contacto extends BaseController
{
    /**
     * Summary of index
     * @return string
     */
    public function index(): string
    {
        return view('Dashboard/Contacto');
    }
    public function enviarMensaje()
{
    $emailService = \Config\Services::email();

    $nombre = $this->request->getPost('nombre');
    $correo = $this->request->getPost('email');
    $mensaje = $this->request->getPost('mensaje');

    $para = 'admin@hotmail.com'; // Reemplaza esto con la dirección de correo a la que quieras enviar el mensaje
    $asunto = 'Nuevo mensaje de ' . $nombre;

    $emailService->setTo($para);
    $emailService->setFrom($correo, $nombre);
    $emailService->setSubject($asunto);
    $emailService->setMessage($mensaje);

    if ($emailService->send()) {
        return redirect()->back()->with('mensaje', 'Mensaje enviado con éxito');
    } else {
        log_message('error', $emailService->printDebugger(['headers']));
        return redirect()->back()->with('error', 'Hubo un problema al enviar el mensaje');
    }
}
}