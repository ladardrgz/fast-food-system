<?php
// Clase encargada de manejar la lógica relacionada con la sesión de usuario
class Sesion
{
    // Inicia la sesión si aún no ha sido iniciada
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Establece los datos del usuario en la sesión y marca su sesión como activa en la base de datos
    public static function establecerUsuario(array $usuario)
    {
        self::iniciar();
        $_SESSION['usuario'] = $usuario;

        // Activar sesión en la base de datos
        require_once 'models/SesionModel.php';
        $modelo = new SesionModel();
        $modelo->marcarSesionActiva($usuario['id_usuario']);
    }

    // Obtiene los datos del usuario almacenados en la sesión, si existen
    public static function obtenerUsuario()
    {
        self::iniciar();
        return $_SESSION['usuario'] ?? null;
    }

    // Verifica si hay un usuario autenticado en la sesión
    public static function usuarioAutenticado(): bool
    {
        self::iniciar();
        return isset($_SESSION['usuario']);
    }

    // Destruye la sesión del usuario, tanto en el sistema como marcándola como inactiva en la base de datos
    public static function destruir()
    {
        self::iniciar();

        // Marcar sesión como inactiva en la base de datos
        if (isset($_SESSION['usuario']['id_usuario'])) {
            require_once 'models/SesionModel.php';
            $modelo = new SesionModel();
            $modelo->marcarSesionInactiva($_SESSION['usuario']['id_usuario']);
        }

        // Limpiar y cerrar la sesión
        $_SESSION = [];
        session_destroy();
    }

    // Redirige al login si el usuario no está autenticado
    public static function requerirLogin()
    {
        if (!self::usuarioAutenticado()) {
            header("Location: index.php?controller=Login&action=loginView");
            exit;
        }
    }
}
?>
