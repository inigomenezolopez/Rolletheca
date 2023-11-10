<?php

// Declara el espacio de nombres para el controlador, lo que ayuda a evitar conflictos de nombres con otras clases.
namespace App\Controllers\Dashboard;

// Importa la clase BaseController, que es la clase base para todos los controladores en CodeIgniter 4.
use App\Controllers\BaseController;

/**
 * Resumen de HomeController
 * La clase Contacto extiende de BaseController y se ocupa de las funciones relacionadas con el contacto.
 */
class Contacto extends BaseController
{
    /**
     * Resumen del método index
     * Este método carga y muestra la vista del contacto.
     * @return string La función view() devuelve una vista que es un archivo de plantilla en la carpeta de vistas de CodeIgniter.
     */
    public function index(): string
    {
        // Carga y devuelve la vista 'Dashboard/Contacto'.
        return view('Dashboard/Contacto');
    }

    /**
     * Este método maneja el envío de mensajes desde un formulario de contacto.
     */
    public function enviarMensaje()
    {
        // Carga el servicio de correo electrónico configurado en la aplicación.
        $emailService = \Config\Services::email();

        // Recupera el nombre, correo electrónico y mensaje del formulario de contacto mediante POST.
        $nombre = $this->request->getPost('nombre');
        $correo = $this->request->getPost('email');
        $mensaje = $this->request->getPost('mensaje');

        // Dirección de correo electrónico del destinatario del mensaje.
        $para = 'admin@hotmail.com'; // Se debe reemplazar con la dirección de correo real del administrador.

        // Asunto del correo electrónico.
        $asunto = 'Nuevo mensaje de ' . $nombre;

        // Configura los detalles del correo electrónico a enviar.
        $emailService->setTo($para); // Destinatario del mensaje.
        $emailService->setFrom($correo, $nombre); // Remitente del mensaje.
        $emailService->setSubject($asunto); // Asunto del mensaje.
        $emailService->setMessage($mensaje); // Cuerpo del mensaje.

        // Intenta enviar el correo electrónico.
        if ($emailService->send()) {
            // Si el correo electrónico se envía con éxito, redirige al usuario a la página anterior con un mensaje de éxito.
            return redirect()->back()->with('mensaje', 'Mensaje enviado con éxito');
        } else {
            // Si el envío falla, registra el error y redirige al usuario a la página anterior con un mensaje de error.
            log_message('error', $emailService->printDebugger(['headers']));
            return redirect()->back()->with('mensaje', 'Hubo un problema al enviar el mensaje');
        }
    }
}