<?php
require_once 'core/Sesion.php';
require_once 'models/AuthModel.php';

class LoginController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    /**
     * Autentica al usuario por nombre de usuario o contacto
     */
    public function autenticar(string $usuarioOContacto, string $contrasena): array
    {
        $usuario = $this->authModel->verificarCredenciales($usuarioOContacto);

        if (!$usuario || (int)$usuario['estado_usuario'] !== 1) {
            return [
                'success' => false,
                'message' => 'Usuario no encontrado o inactivo.'
            ];
        }

        // Verificar si ya tiene sesión activa
        require_once 'models/SesionModel.php';
        $sesionModel = new SesionModel();
        if ($sesionModel->sesionActiva($usuario['id_usuario'])) {
            return [
                'success' => false,
                'message' => 'Este usuario ya tiene una sesión activa en otro dispositivo.'
            ];
        }

        // Verifica si tiene contraseña temporal válida
        if (!empty($usuario['password_temporal'])) {
            $ahora = new DateTime();
            $expiracion = new DateTime($usuario['expiracion_password_temporal']);

            if ($ahora < $expiracion && password_verify($contrasena, $usuario['password_temporal'])) {
                // Inicia sesión con contraseña temporal
                Sesion::establecerUsuario([
                    'id_usuario'     => $usuario['id_usuario'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'perfil_id'      => $usuario['perfil_id'],
                    'perfil'         => $usuario['perfil'],
                    'temporal'       => true
                ]);

                return [
                    'success' => true,
                    'message' => 'Contraseña temporal válida. Debes actualizar tu contraseña.',
                    'debe_cambiar_contrasena' => true
                ];
            }
        }

        // Verifica contraseña principal
        if (password_verify($contrasena, $usuario['password_usuario'])) {
            Sesion::establecerUsuario([
                'id_usuario'     => $usuario['id_usuario'],
                'nombre_usuario' => $usuario['nombre_usuario'],
                'perfil_id'      => $usuario['perfil_id'],
                'perfil'         => $usuario['perfil'],
                'temporal'       => false
            ]);

            return [
                'success' => true,
                'message' => 'Autenticación exitosa.',
                'debe_cambiar_contrasena' => false
            ];
        }

        return [
            'success' => false,
            'message' => 'Credenciales incorrectas.'
        ];
    }


    /**
     * Punto de entrada para login por API (fetch desde JS)
     */
    public function loginApi(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido.'
            ]);
            return;
        }

        $request = file_get_contents('php://input');
        $data = json_decode($request, true);

        if (!is_array($data) || !isset($data['usuario'], $data['contrasena'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Petición inválida. Faltan datos.'
            ]);
            return;
        }

        $usuario    = trim(filter_var($data['usuario'], FILTER_SANITIZE_STRING));
        $contrasena = trim($data['contrasena']);

        $resultado = $this->autenticar($usuario, $contrasena);

        if (!$resultado['success']) {
            http_response_code(401);
        }

        echo json_encode($resultado);
    }

    /**
     * Redirige según el perfil del usuario autenticado
     */
    public function redirigirPorPerfil()
    {
        $usuario = Sesion::obtenerUsuario();

        if (!$usuario) {
            header('Location: index.php?controller=Login&action=loginView');
            exit;
        }

        $perfil = $usuario['perfil'] ?? '';

        switch ($perfil) {
            case 'Administrador':
            case 'Encargado':
            case 'Empleado':
            case 'Repartidor':
                header('Location: index.php?controller=Panel&action=dashboard');
                break;
            case 'Cliente':
                header('Location: index.php?controller=Cliente&action=inicio');
                break;
            default:
                header('Location: index.php?controller=Home&action=index');
                break;
        }

        exit;
    }

    /**
     * Muestra la vista de login
     */
    public function loginView()
    {
        if (Sesion::usuarioAutenticado()) {
            header('Location: index.php?controller=Panel&action=dashboard');
            exit;
        }

        require_once 'views/login_view.php';
    }

    /**
     * Cierra sesión
     */
    public function logout()
    {
        Sesion::destruir();
        header('Location: index.php?controller=Login&action=loginView');
        exit;
    }
}
