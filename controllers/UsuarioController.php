<?php

class UsuarioController
{
    public function registrar()
    {
        $titulo = 'Crear usuario';
        $contenido = 'views/usuario/registrar.php';
        require 'views/layouts/main.php';
    }

    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        // Leer y decodificar el JSON del cuerpo
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        // Validar JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos JSON malformados']);
            return;
        }

        // Validar campos obligatorios
        $campos = [
            'nombre',
            'apellido',
            'fechaNacimiento',
            'genero',
            'calle',
            'numero',
            'barrio',
            'tipoDoc',
            'valorDoc',
            'tipoCont',
            'valorCont',
            'usuario',
            'contrasena',
            'perfil'
        ];

        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "Falta el campo requerido: $campo"]);
                return;
            }
        }

        try {
            $personaModel = new PersonaModel();
            $usuarioModel = new UsuarioModel();

            // Validación: documento duplicado
            if ($personaModel->existeDocumento($data['valorDoc'], (int)$data['tipoDoc'])) {
                http_response_code(409);
                echo json_encode([
                    'success' => false,
                    'message' => 'Ya existe una persona con ese número de documento.'
                ]);
                return;
            }

            // Validación: usuario duplicado
            if ($usuarioModel->existeUsuario($data['usuario'])) {
                http_response_code(409);
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre de usuario ya está en uso.'
                ]);
                return;
            }

            // Crear persona con género incluido
            $idPersona = $personaModel->crearPersona([
                'nombre'          => $data['nombre'],
                'apellido'        => $data['apellido'],
                'fechaNacimiento' => $data['fechaNacimiento'],
                'genero'          => $data['genero'],
                'calle'           => $data['calle'],
                'numero'          => $data['numero'],
                'piso'            => $data['piso'] ?? null,
                'dpto'            => $data['dpto'] ?? null,
                'barrio'          => $data['barrio'],
                'tipoDoc'         => $data['tipoDoc'],
                'valorDoc'        => $data['valorDoc'],
                'tipoCont'        => $data['tipoCont'],
                'valorCont'       => $data['valorCont']
            ]);

            // Crear usuario
            $creado = $usuarioModel->crearUsuario(
                $data['usuario'],
                $data['contrasena'],
                $idPersona,
                (int)$data['perfil']
            );

            if ($creado) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
            }
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
        }
    }

    private function validarFechaNacimiento(string $fecha): bool
    {
        if (!strtotime($fecha)) return false;

        $fecha = new DateTime($fecha);
        $min = new DateTime('1925-01-01');
        $max = new DateTime('2007-12-31');

        return $fecha >= $min && $fecha <= $max;
    }
    public function recuperarContrasena()
    {
        require_once 'views/usuario/recuperar_contrasena.php';
    }

    public function enviarRecuperacion()
    {
        header('Content-Type: application/json');
        require_once 'models/UsuarioModel.php';

        $email = $_POST['email'] ?? '';
        $usuarioModel = new UsuarioModel();

        $usuario = $usuarioModel->obtenerPorCorreo($email);

        if (!$usuario) {
            echo json_encode([
                'status' => 'error',
                'title' => 'Correo no encontrado',
                'message' => 'No se encontró ninguna cuenta con ese correo.'
            ]);
            return;
        }

        $tempPass = bin2hex(random_bytes(4));
        $expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $usuarioModel->guardarTemporal($usuario['id_usuario'], $tempPass, $expiracion);

        // Aquí deberías enviar $tempPass por correo (omisión intencional)
        echo json_encode([
            'status' => 'success',
            'title' => 'Correo enviado',
            'message' => 'Se ha enviado una contraseña temporal a tu correo. Tiene 15 minutos de validez.'
        ]);
    }

    /**
     * Muestra la vista principal de "Administrar cuenta"
     */
    public function administrarCuenta()
    {
        Sesion::requerirLogin();
        $idUsuario = Sesion::obtenerUsuario()['id_usuario'];

        $modelo = new UsuarioModel();
        $datos = $modelo->obtenerDatosCompletosPerfil($idUsuario);

        $titulo = 'Administrar mi cuenta';
        $contenido = 'views/usuario/administrar_mi_perfil.php';
        require 'views/layouts/main.php';
    }

    /**
     * Muestra el formulario para editar el perfil personal
     */
    public function editarPerfil()
    {
        Sesion::requerirLogin();

        $idUsuario = Sesion::obtenerUsuario()['id_usuario'];

        $usuarioModel = new UsuarioModel();
        $personaModel = new PersonaModel();

        // Obtener usuario y datos personales relacionados
        $usuario = $usuarioModel->obtenerUsuarioPorId($idUsuario);
        $persona = $personaModel->obtenerPersonaPorId($usuario['rela_persona']);

        // Combinar datos para la vista
        $datos = array_merge($usuario, $persona);

        // Obtener opciones de género desde el modelo
        $generos = $personaModel->obtenerGeneros();

        $titulo = 'Editar perfil';
        $contenido = 'views/usuario/editar_perfil.php';
        require 'views/layouts/main.php';
    }

    /**
     * Procesa y guarda los cambios enviados desde el formulario de edición de perfil
     */
    public function guardarEdicionPerfil()
    {
        Sesion::requerirLogin();
        $idUsuario = Sesion::obtenerUsuario()['id_usuario'];

        // Leer JSON desde fetch
        $entrada = json_decode(file_get_contents('php://input'), true);

        $usuarioModel = new UsuarioModel();
        $personaModel = new PersonaModel();

        $usuario = $usuarioModel->obtenerUsuarioPorId($idUsuario);
        $idPersona = $usuario['rela_persona'];

        // Validaciones del lado del servidor
        $errores = [];

        $nombre    = trim($entrada['nombre'] ?? '');
        $apellido  = trim($entrada['apellido'] ?? '');
        $fechaNac  = $entrada['fechaNacimiento'] ?? '';
        $genero    = $entrada['genero'] ?? '';
        $nombreUsuario = trim($entrada['usuario'] ?? '');

        if (!$nombre || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/u', $nombre)) {
            $errores['nombre'] = 'El nombre es obligatorio y solo debe contener letras';
        }

        if (!$apellido || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/u', $apellido)) {
            $errores['apellido'] = 'El apellido es obligatorio y solo debe contener letras';
        }

        if (!$fechaNac || !strtotime($fechaNac) || $fechaNac < '1925-01-01' || $fechaNac > '2007-12-31') {
            $errores['fechaNacimiento'] = 'Debe ingresar una fecha válida entre 1925 y 2007';
        }

        if (!$genero || !ctype_digit($genero)) {
            $errores['genero'] = 'Debe seleccionar un género válido';
        }

        if (!$nombreUsuario || strlen($nombreUsuario) < 4 || strlen($nombreUsuario) > 20) {
            $errores['usuario'] = 'El nombre de usuario debe tener entre 4 y 20 caracteres';
        }

        // Si hay errores, se devuelve como JSON
        if (!empty($errores)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'errores' => $errores]);
            exit;
        }

        // Guardar datos en la base
        $personaModel->actualizarPersona($idPersona, [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fechaNacimiento' => $fechaNac,
            'genero' => $genero
        ]);

        $usuarioModel->actualizarNombreUsuario($idUsuario, $nombreUsuario);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente.']);
    }
    public function editarContrasena()
    {
        $titulo = 'Editar perfil';
        $contenido = 'views/usuario/editar_contrasena.php';
        require 'views/layouts/main.php';
    }
    public function guardarCambioContrasena()
    {
        Sesion::requerirLogin();
        header('Content-Type: application/json'); // Esto va al principio por consistencia

        $idUsuario = Sesion::obtenerUsuario()['id_usuario'];

        // Leer y decodificar entrada JSON
        $data = json_decode(file_get_contents('php://input'), true);

        $actual    = trim($data['actual'] ?? '');
        $nueva     = trim($data['nueva'] ?? '');
        $confirmar = trim($data['confirmar'] ?? '');

        $errores = [];

        // 🔒 Validaciones básicas de campos
        if (strlen($actual) < 8 || strlen($actual) > 32) {
            $errores['actual'] = 'La contraseña actual es obligatoria y debe tener entre 8 y 32 caracteres';
        }

        if (strlen($nueva) < 8 || strlen($nueva) > 32) {
            $errores['nueva'] = 'La nueva contraseña debe tener entre 8 y 32 caracteres';
        }

        if ($nueva !== $confirmar) {
            $errores['confirmar'] = 'La confirmación no coincide con la nueva contraseña';
        }

        if (!empty($errores)) {
            echo json_encode(['exito' => false, 'errores' => $errores]);
            return;
        }

        // 🔐 Verificar contraseña actual contra la base
        require_once 'models/UsuarioModel.php';
        $modelo = new UsuarioModel();
        $usuario = $modelo->obtenerUsuarioPorId($idUsuario);

        if (!$usuario || !password_verify($actual, $usuario['password_usuario'])) {
            echo json_encode([
                'exito' => false,
                'errores' => ['actual' => 'La contraseña actual no es correcta']
            ]);
            return;
        }

        // ✅ Guardar nueva contraseña hasheada
        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        $modelo->actualizarClaveUsuario($idUsuario, $hash);

        echo json_encode([
            'exito' => true,
            'mensaje' => 'La contraseña fue cambiada correctamente.'
        ]);
    }
}
