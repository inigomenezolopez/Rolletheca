<?php

// Espacio de nombres del controlador, ubicado en la carpeta Controllers/Dashboard.
namespace App\Controllers\Dashboard;

// Importación de clases necesarias.
use CodeIgniter\Files\File;
use Config\Services;
use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\I18n\Time;

// Clase Usuario que extiende de BaseController.
class Usuario extends BaseController
{
    // Método para mostrar la vista de inicio de sesión.
    function login() {
        echo view ('dashboard/login');
    }
    
    // Método POST para el inicio de sesión que procesa los datos enviados desde el formulario.
    public function login_post() {
        $usuarioModel = new UsuarioModel(); // Instancia del modelo UsuarioModel.
        
        // Recuperar el correo y la contraseña del formulario de inicio de sesión.
        $correo = $this->request->getPost('correo');
        $contrasena = $this->request->getPost('contrasena');
        $ipAddress = $this->request->getIPAddress(); // Obtener la dirección IP del cliente.
    
        $session = session(); // Iniciar o continuar la sesión actual.
    
        // Recuperar y manejar intentos previos de inicio de sesión fallidos.
        $login_attempts = $session->get('login_attempts') ?? [];
        $current_time = time();
    
        // Comprobar si se ha excedido el número de intentos de inicio de sesión y aplicar un bloqueo temporal si es necesario.
        if (isset($login_attempts[$ipAddress]) && $login_attempts[$ipAddress]['count'] >= 3) {
            $last_attempt_time = $login_attempts[$ipAddress]['time'];
            if ($current_time - $last_attempt_time < 200) {
                // Si el último intento fue hace menos de 5 minutos, redirige con un mensaje de error.
                return redirect()->back()->with('errors', 'Demasiados intentos fallidos. Por favor, espera 5 minutos antes de intentar nuevamente.');
            }
        }
    
        // Intentar obtener el usuario de la base de datos usando el correo o nombre de usuario proporcionado.
        $usuario = $usuarioModel->select('id, usuario, correo, contrasena, rol, imagen')
            ->orwhere('correo', $correo)
            ->orwhere('usuario', $correo)
            ->first();
    
        // Verificar si el usuario existe y si la contraseña es correcta.
        if (!$usuario || !$usuarioModel->contrasenaVerificar($contrasena, $usuario->contrasena)) {
            // Si la autenticación falla, incrementar el contador de intentos fallidos y devolver un mensaje de error.
            if (!isset($login_attempts[$ipAddress])) {
                $login_attempts[$ipAddress] = ['count' => 1, 'time' => $current_time];
            } else {
                $login_attempts[$ipAddress]['count']++;
                $login_attempts[$ipAddress]['time'] = $current_time;
            }
            $session->set('login_attempts', $login_attempts);
    
            return redirect()->back()->with('mensaje', 'Usuario y/o contraseña incorrectos');
        }
    
        // Si el inicio de sesión es exitoso, resetear el contador de intentos fallidos.
        unset($login_attempts[$ipAddress]);
        $session->set('login_attempts', $login_attempts);
    
        // Eliminar la contraseña del objeto usuario por seguridad antes de guardar en la sesión.
        unset($usuario->contrasena);
        
        // Guardar los datos del usuario en la sesión y redirigir a la página de inicio.
        session()->set('usuario', $usuario);
        return redirect()->to('/inicio');
    }

    

function register() {
    
    //Imprime la vista registrarse
    echo view ('dashboard/register');
    
}
// Método para registrar un nuevo usuario.
function register_post() {
    // Instanciamos el modelo de usuario.
    $usuarioModel = new UsuarioModel();

    // Validamos que los datos enviados desde el formulario cumplan con las reglas definidas en la configuración de validación.
    if ($this->validate('usuarios')) {
        // Si la validación es exitosa, insertamos el nuevo usuario en la base de datos.
        $usuarioModel->insert([
            'usuario' => $this->request->getPost('usuario'), // Nombre de usuario.
            'correo' => $this->request->getPost('correo'), // Correo electrónico.
            // Hash de la contraseña para almacenar de manera segura.
            'contrasena' => $usuarioModel->contrasenaHash($this->request->getPost('contrasena')),
            'fecha_creacion'=> Time::now() // Fecha y hora de creación del usuario.
        ]);

        // Redireccionamos al usuario a la página de inicio de sesión con un mensaje de éxito.
        return redirect()->to(route_to('usuario.login'))->with('mensaje','Registro completado correctamente');
    }
    
    // Si la validación falla, guardamos los errores en la sesión y redireccionamos al formulario con los datos ingresados.
    session()->setFlashdata([
        'validation'=>$this->validator
    ]);
    return redirect()->back()->withInput();
}

// Método para cerrar sesión del usuario.
function logout() {
    // Destruimos la sesión del usuario.
    session()->destroy();

    // Redireccionamos al usuario a la página de inicio de sesión.
    return redirect()->to(route_to('usuario.login'));
}

// Método para mostrar el perfil del usuario.
public function mostrarPerfil()
{
    // Obtenemos el usuario de la sesión actual.
    $usuario = session()->get('usuario');
    
    // Si no hay un usuario en sesión, redireccionamos a la página de inicio de sesión.
    if (!$usuario) {
        return redirect()->to('/usuario/login');
    }

    $usuarioModel = new UsuarioModel();
    
    // Buscamos los datos completos del usuario en la base de datos usando su ID.
    $usuarioDb = $usuarioModel->find($usuario->id);

    // Si no encontramos al usuario, redireccionamos a la página de inicio de sesión.
    if (!$usuarioDb) {
        return redirect()->to('/usuario/login'); 
    }

    // Pasamos los datos del usuario a la vista de perfil y la mostramos.
    return view('/dashboard/Miperfil', ['usuario' => $usuarioDb]);
}

// Método para actualizar los datos del perfil del usuario.
public function actualizarPerfil()
{
    // Instanciamos el modelo de usuario.
    $usuarioModel = new UsuarioModel();
    // Obtenemos el usuario de la sesión actual.
    $usuarioSesion = session()->get('usuario');

    // Verificamos que el método de la solicitud sea POST.
    if ($this->request->getMethod() === 'post') {
        // Instanciamos el servicio de validación.
        $validation = \Config\Services::validation();
        // Definimos las reglas de validación para 'usuario' y 'correo' asegurando que sean únicos en la base de datos excepto para el usuario actual.
        $validation->setRule('usuario', 'Usuario', "required|min_length[5]|max_length[20]|is_unique[usuarios.usuario,id,{$usuarioSesion->id}]");
        $validation->setRule('correo', 'Correo', "valid_email|required|is_unique[usuarios.correo,id,{$usuarioSesion->id}]");

        // Si la validación es exitosa, procesamos la actualización del perfil.
        if ($this->validate($validation->getRules())) {
            // Procesamos la imagen de perfil si fue enviada con el formulario.
            $imagen = $this->request->getFile('imagen');
            $datosActualizar = [
                'usuario' => $this->request->getPost('usuario'), // Nombre de usuario actualizado.
                'correo' => $this->request->getPost('correo'), // Correo electrónico actualizado.
            ];

            // Si hay una imagen y es válida, la procesamos.
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                // Si hay una imagen previa, la eliminamos.
                $imagenActual = $usuarioSesion->imagen;
                if ($imagenActual && file_exists(FCPATH . 'images/usuario/' . $imagenActual)) {
                    unlink(FCPATH . 'images/usuario/' . $imagenActual);
                }
                // Generamos un nombre aleatorio para la nueva imagen y guardamos la imagen recortada.
                $nuevoNombre = $imagen->getRandomName();
                $datosActualizar['imagen'] = $nuevoNombre;
                $imagen->move(FCPATH . 'images/usuario', $nuevoNombre);
            }

            // Actualizamos los datos del usuario en la base de datos.
            $usuarioModel->update($usuarioSesion->id, $datosActualizar);

            // Actualizamos la sesión con los nuevos datos.
            $usuarioSesion->usuario = $datosActualizar['usuario'];
            $usuarioSesion->correo = $datosActualizar['correo'];
            if (isset($datosActualizar['imagen'])) {
                $usuarioSesion->imagen = $datosActualizar['imagen'];
            }
            session()->set('usuario', $usuarioSesion);

            // Redireccionamos al usuario a la vista de perfil con un mensaje de éxito.
            return redirect()->to(route_to('usuario.mostrarPerfil'))->with('mensaje','Perfil actualizado correctamente');
        }
        
        // Si la validación falla, guardamos los errores en la sesión y redireccionamos al formulario con los datos ingresados.
        session()->setFlashdata([
            'validation'=>$this->validator
        ]);
        return redirect()->back()->withInput();
    }

    // Si el método no es POST, redireccionamos al perfil del usuario.
    return redirect()->to(route_to('usuario.mostrarPerfil'));
}



// Función para recortar una imagen subida por el usuario. Requiere coordenadas y dimensiones para el recorte.
public function recortarImagen()
{
    // Recoge el archivo de imagen y las coordenadas y dimensiones para el recorte de la petición HTTP.
    $imagen = $this->request->getFile('imagen');
    
    // Convierte los valores recibidos a enteros.
    $x = (int)$this->request->getPost('x');
    $y = (int)$this->request->getPost('y');
    $width = (int)$this->request->getPost('width');
    $height = (int)$this->request->getPost('height');

    // Comprueba si los valores de las coordenadas y dimensiones son válidos.
    if (!is_numeric($x) || !is_numeric($y) || !is_numeric($width) || !is_numeric($height) ||
        $width <= 0 || $height <= 0) {
        // Devuelve un error si los valores no son válidos.
        return $this->response->setJSON(['mensaje' => 'Valores inválidos para el recorte de la imagen.']);
    }

    // Si la imagen es válida y no ha sido movida aún, procede con el proceso.
    if ($imagen->isValid() && !$imagen->hasMoved()) {
        // Genera un nombre aleatorio para la imagen y la mueve al directorio especificado.
        $nombreImagen = $imagen->getRandomName();
        $imagen->move(FCPATH . 'images/usuario/', $nombreImagen);
        // Construye la ruta completa de la imagen.
        $rutaImagen = FCPATH . 'images/usuario/' . $nombreImagen;

        try {
            // Utiliza la librería de imágenes para recortar la imagen según las dimensiones y coordenadas, y guarda los cambios.
            \Config\Services::image()
                ->withFile($rutaImagen)
                ->crop($width, $height, $x, $y)
                ->save($rutaImagen);

            // Devuelve un mensaje de éxito y el nombre de la imagen si el recorte fue exitoso.
            return $this->response->setJSON(['mensaje' => 'Imagen recortada y guardada exitosamente!', 'imageName' => $nombreImagen]);
        } catch (\Exception $e) {
            // Si ocurre un error durante el recorte, elimina la imagen y devuelve un mensaje de error.
            unlink($rutaImagen);
            return $this->response->setJSON(['mensaje' => 'Error al procesar la imagen: ' . $e->getMessage()]);
        }
    } else {
        // Devuelve un mensaje de error si hubo un problema al subir la imagen.
        return $this->response->setJSON(['mensaje' => 'Error al subir la imagen: ' . $imagen->getErrorString()]);
    }
}

// Función para mostrar la vista de solicitud de restablecimiento de contraseña.
public function solicitarRestablecimientoContrasena()
{
    // Devuelve la vista correspondiente al formulario de solicitud de restablecimiento de contraseña.
    return view('dashboard/solicitar_restablecimiento');
}

// Función para procesar la solicitud de restablecimiento de contraseña.
public function procesarSolicitudRestablecimiento()
{
    // Obtiene el correo electrónico del formulario.
    $email = $this->request->getPost('email');
    // Crea una instancia del modelo de usuario y busca al usuario por correo electrónico.
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->where('correo', $email)->first();

    // Si no se encuentra el usuario, devuelve un error.
    if (!$usuario) {
        session()->setFlashdata('mensaje', 'No pudimos encontrar una cuenta con ese correo electrónico.');
        return redirect()->back();
    }

    // Genera un token de restablecimiento único y guarda en la base de datos junto con la fecha de expiración.
    $token = bin2hex(random_bytes(16));
    $usuarioModel->update($usuario->id, [
        'reset_token' => $token,
        'reset_expiration' => date('Y-m-d H:i:s', time() + 7200) // Establece la expiración para 2 horas en el futuro.
    ]);

    // Envía el correo electrónico con el token de restablecimiento.
    $this->enviarEmailRecuperarContrasena($usuario->correo, $token);

    // Muestra un mensaje de éxito y redirige al usuario.
    session()->setFlashdata('mensaje', 'Tu acción fue exitosa y se completó correctamente.');
    return redirect()->back();
}

// Función para mostrar el formulario de restablecimiento de contraseña.
public function mostrarFormularioRestablecimiento($token)
{
    // Crea una instancia del modelo de usuario y busca al usuario por el token de restablecimiento.
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->where('reset_token', $token)->where('reset_expiration >', date('Y-m-d H:i:s'))->first();

    // Verifica si el token es válido y no ha expirado.
    if (!$usuario) {
        return redirect()->to(route_to('usuario.login'))->with('mensaje', 'El token de restablecimiento de contraseña es inválido o ha expirado.');
    }

    // Muestra la vista para restablecer la contraseña si el token es válido.
    return view('dashboard/restablecer_contrasena', ['token' => $token]);
}
        



// Función para procesar el restablecimiento de contraseña.
public function procesarRestablecimientoContrasena()
{
    // Reglas de validación para la nueva contraseña y su confirmación
    $rules = [
        'nueva_contrasena' => [
            'label' => 'Nueva contraseña',
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
            ],
        ],
        'confirmar_contrasena' => [
            'label' => 'Confirmar nueva contraseña',
            'rules' => 'matches[nueva_contrasena]',
            'errors' => [
                'matches' => 'Las contraseñas no coinciden.',
            ],
        ],
    ];

    // Verifica si las reglas de validación se cumplen
    if (!$this->validate($rules)) {
        // La validación falló, reenviar al formulario con errores y datos antiguos
        session()->setFlashdata($this->validator->getErrors());
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Recupera el token del formulario
    $token = $this->request->getPost('token');
    // Recupera la nueva contraseña del formulario
    $nuevaContrasena = $this->request->getPost('nueva_contrasena');
    
    // Instancia del modelo de usuario y búsqueda de usuario por token
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->where('reset_token', $token)->first();

    // Verifica si el usuario con el token dado existe
    if (!$usuario) {
        session()->setFlashdata('mensaje', 'El token es inválido o ha expirado.');
        return redirect()->back()->withInput();
    }

    // Actualiza la contraseña del usuario en la base de datos
    $usuarioModel->update($usuario->id, [
        'contrasena' => password_hash($nuevaContrasena, PASSWORD_DEFAULT),
        'reset_token' => null, // Elimina el token de restablecimiento
        'reset_expiration' => null // Elimina la fecha de expiración del token
    ]);

    // Redirige al usuario a la página de inicio de sesión con un mensaje de éxito
    return redirect()->to(route_to('usuario.login'))->with('mensaje', 'Tu contraseña ha sido actualizada.');
}

private function enviarEmailRecuperarContrasena($email, $token)
{
    // Configuración del servicio de email
    $emailService = \Config\Services::email();
    
    // Configura el remitente y el destinatario del email
    $emailService->setFrom('no-reply@example.com', 'Your Application Name');
    $emailService->setTo($email);
    // Asunto del email
    $emailService->setSubject('Restablecimiento de contraseña');
    // Mensaje del email utilizando una vista
    $emailService->setMessage(view('dashboard/emails/restablecer_contrasena', ['token' => $token]));

    // Intento de envío del email y manejo de errores en caso de fallo
    if (!$emailService->send()) {
        log_message('error', 'Hubo un error al enviar el email de restablecimiento de contraseña: ' . $emailService->printDebugger(['headers']));
        // ... Manejar error ...
    }
}
}