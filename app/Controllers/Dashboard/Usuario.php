<?php

namespace App\Controllers\Dashboard;
use CodeIgniter\Files\File;
use Config\Services;
use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\I18n\Time;

class Usuario extends BaseController
{
    

    function login() {

        echo view ('dashboard/login');
        
    }
    public function login_post() {
        $usuarioModel = new UsuarioModel();
        
        $correo = $this->request->getPost('correo');
        $contrasena = $this->request->getPost('contrasena');
        $ipAddress = $this->request->getIPAddress(); // Obtener la dirección IP del usuario
    
        $session = session();
    
        // Comprobar intentos de inicio de sesión previos
        $login_attempts = $session->get('login_attempts') ?? [];
        $current_time = time();
    
        // Si ya hay registros de intentos fallidos para esta IP
        if (isset($login_attempts[$ipAddress]) && $login_attempts[$ipAddress]['count'] >= 3) {
            $last_attempt_time = $login_attempts[$ipAddress]['time'];
            // Si han pasado menos de 5 minutos desde el último intento
            if ($current_time - $last_attempt_time < 300) {
                return redirect()->back()->with('mensaje', 'Demasiados intentos fallidos. Por favor, espera 5 minutos antes de intentar nuevamente.');
            }
        }
    
        $usuario = $usuarioModel->select('id, usuario, correo, contrasena, rol, imagen') // Asegúrate de seleccionar la columna de la imagen
            ->orwhere('correo', $correo)
            ->orwhere('usuario', $correo)
            ->first();
    
        if (!$usuario || !$usuarioModel->contrasenaVerificar($contrasena, $usuario->contrasena)) {
            // Registro o actualización del conteo de intentos fallidos
            if (!isset($login_attempts[$ipAddress])) {
                $login_attempts[$ipAddress] = ['count' => 1, 'time' => $current_time];
            } else {
                $login_attempts[$ipAddress]['count']++;
                $login_attempts[$ipAddress]['time'] = $current_time;
            }
            $session->set('login_attempts', $login_attempts);
    
            return redirect()->back()->with('mensaje', 'Usuario y/o contraseña incorrectos');
        }
    
        // Si el inicio de sesión es exitoso, restablece los intentos de inicio de sesión
        unset($login_attempts[$ipAddress]);
        $session->set('login_attempts', $login_attempts);
    
        // El inicio de sesión fue exitoso, continuar con el proceso de inicio de sesión
        unset($usuario->contrasena);
        
        // Guardamos la información del usuario en la sesión
        session()->set('usuario', $usuario);
        
        return redirect()->to('/inicio');
    }
    

function register() {

    echo view ('dashboard/register');
    
}
function register_post() {

    $usuarioModel = new UsuarioModel();


    if ($this->validate('usuarios')) {
        $usuarioModel->insert([
        'usuario' => $this->request->getPost('usuario'),
        'correo' => $this->request->getPost('correo'),
        'contrasena' => $usuarioModel->contrasenaHash($this->request->getPost('contrasena')),
        'fecha_creacion'=> Time::now()
        ]);

        return redirect()->to(route_to('usuario.login'))->with('mensaje','Registro completado correctamente');
    }
    
    session()->setFlashdata([
        'validation'=>$this->validator
    ]);
    return redirect()->back()->withInput();


}
   function logout() {

    session()->destroy();

    return redirect()->to(route_to('usuario.login'));
    
   }

   public function enviarMensaje()
   {
       $nombre = $this->request->getPost('nombre');
       $correo = $this->request->getPost('email');
       $mensaje = $this->request->getPost('mensaje');
   
       $para = 'admin@hotmail.com'; // Reemplaza esto con la dirección de correo a la que quieras enviar el mensaje
       $asunto = 'Nuevo mensaje de ' . $nombre;
   
       $cabeceras = 'Para: ' . $para . "\r\n" .
           'Responder a: ' . $correo . "\r\n";
           
   
       if(mail($para, $asunto, $mensaje, $cabeceras)) {
           return redirect()->back()->with('mensaje', 'Mensaje enviado con éxito');
       } else {
           return redirect()->back()->with('error', 'Hubo un problema al enviar el mensaje');
       }
   }

   public function mostrarPerfil()
   {
       // Obtén el objeto de usuario almacenado en la sesión
       $usuario = session()->get('usuario');
       
       if (!$usuario) {
           return redirect()->to('/usuario/login');
       }
   
       $usuarioModel = new UsuarioModel();
       
       // Obtén el usuario de la base de datos basado en el ID
       $usuarioDb = $usuarioModel->find($usuario->id);
   
       // Verifica que el usuario se haya obtenido correctamente
       if (!$usuarioDb) {
           return redirect()->to('/usuario/login'); 
       }
   
       // Muestra la vista y pasa el usuario como un objeto
       return view('/dashboard/Miperfil', ['usuario' => $usuarioDb]);
   }

  


   public function actualizarPerfil()
{
    $usuarioModel = new UsuarioModel();
    $usuarioSesion = session()->get('usuario');

    if ($this->request->getMethod() === 'post') {
        $validation = \Config\Services::validation();
        $validation->setRule('usuario', 'Usuario', "required|min_length[5]|max_length[20]|is_unique[usuarios.usuario,id,{$usuarioSesion->id}]");
        $validation->setRule('correo', 'Correo', "valid_email|required|is_unique[usuarios.correo,id,{$usuarioSesion->id}]");

        if ($this->validate($validation->getRules())) {
            $imagen = $this->request->getFile('imagen');
            $datosActualizar = [
                'usuario' => $this->request->getPost('usuario'),
                'correo' => $this->request->getPost('correo'),
            ];

            if ($imagen->isValid() && !$imagen->hasMoved()) {
                $imagenActual = $usuarioSesion->imagen;
            if ($imagenActual && file_exists(FCPATH . 'images/usuario/' . $imagenActual)) {
                unlink(FCPATH . 'images/usuario/' . $imagenActual);
            }
                $nuevoNombre = $imagen->getRandomName();
                $rutaTemporal = $imagen->getTempName();

                // Obtén las coordenadas de recorte desde el formulario
                $x = $this->request->getPost('x');
                $y = $this->request->getPost('y');
                $width = $this->request->getPost('width');
                $height = $this->request->getPost('height');

                $imageService = \Config\Services::image()
                    ->withFile($rutaTemporal)
                    ->crop($width, $height, $x, $y)  // Aquí se aplica el recorte
                    ->save(FCPATH . 'images/usuario/' . $nuevoNombre);

                if ($imageService) {
                    $datosActualizar['imagen'] = $nuevoNombre;
                } else {
                    return redirect()->back()->with('mensaje', 'Hubo un problema al procesar la imagen.')->withInput();
                }
            }

            $usuarioModel->update($usuarioSesion->id, $datosActualizar);

            // Actualiza la información del usuario en la sesión
            $usuarioSesion->usuario = $datosActualizar['usuario'];
            $usuarioSesion->correo = $datosActualizar['correo'];
            if (isset($datosActualizar['imagen'])) {
                $usuarioSesion->imagen = $datosActualizar['imagen'];
            }
            session()->set('usuario', $usuarioSesion);

            return redirect()->to('/usuario/mi-perfil')->with('mensaje', 'Cambios realizados con éxito');
        } else {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    }

    $usuarioDb = $usuarioModel->find($usuarioSesion->id);
    return view('/dashboard/Miperfil', ['usuario' => $usuarioDb]);
}


public function recortarImagen()
{
    $imagen = $this->request->getFile('imagen');
    
    $x = (int)$this->request->getPost('x');
    $y = (int)$this->request->getPost('y');
    $width = (int)$this->request->getPost('width');
    $height = (int)$this->request->getPost('height');

    // Validar que las coordenadas y dimensiones son números válidos y mayores que 0
    if (!is_numeric($x) || !is_numeric($y) || !is_numeric($width) || !is_numeric($height) ||
        $width <= 0 || $height <= 0) {
        return $this->response->setJSON(['error' => 'Valores inválidos para el recorte de la imagen.']);
    }

    if ($imagen->isValid() && !$imagen->hasMoved()) {
        $nombreImagen = $imagen->getRandomName();
        $imagen->move(FCPATH . 'images/usuario/', $nombreImagen);
        $rutaImagen = FCPATH . 'images/usuario/' . $nombreImagen;

        try {
            \Config\Services::image()
                ->withFile($rutaImagen)
                ->crop($width, $height, $x, $y)
                ->save($rutaImagen);

            return $this->response->setJSON(['success' => 'Imagen recortada y guardada exitosamente!', 'imageName' => $nombreImagen]);
        } catch (\Exception $e) {
            // Borrar la imagen si hubo un error durante el recorte
            unlink($rutaImagen);
            return $this->response->setJSON(['error' => 'Error al procesar la imagen: ' . $e->getMessage()]);
        }
    } else {
        return $this->response->setJSON(['error' => 'Error al subir la imagen: ' . $imagen->getErrorString()]);
    }
}


}