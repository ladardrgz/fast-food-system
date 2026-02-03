<?php
require_once 'core/Sesion.php';
require_once 'models/NotificacionModel.php';

class NotificacionController
{
    private $model;

    public function __construct()
    {
        $this->model = new NotificacionModel();
    }

    /**
     * Retorna las notificaciones del usuario actual en formato JSON,
     * incluyendo la fecha del último login.
     */
    public function listar()
    {
        header('Content-Type: application/json');
        Sesion::requerirLogin();

        $usuario = Sesion::obtenerUsuario();
        $notificaciones = $this->model->obtenerPorUsuario($usuario['id_usuario']);

        echo json_encode([
            'success' => true,
            'data' => $notificaciones
        ]);
    }

    /**
     * Devuelve la cantidad de notificaciones no leídas del usuario actual.
     */
    public function contar()
    {
        header('Content-Type: application/json');
        Sesion::requerirLogin();

        $usuario = Sesion::obtenerUsuario();
        $cantidad = $this->model->contarNoLeidas($usuario['id_usuario']);

        echo json_encode([
            'success' => true,
            'count' => $cantidad
        ]);
    }

    /**
     * Marca todas las notificaciones como leídas para el usuario actual.
     */
    public function marcarLeidas()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        Sesion::requerirLogin();
        $usuario = Sesion::obtenerUsuario();

        $this->model->marcarLeidas($usuario['id_usuario']);

        echo json_encode(['success' => true]);
    }

    /**
     * Crea una nueva notificación para el usuario actual (usada por scripts o AJAX).
     */
    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        Sesion::requerirLogin();
        $usuario = Sesion::obtenerUsuario();

        $titulo = $_POST['titulo'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';

        if (empty($titulo) || empty($mensaje)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Título y mensaje son obligatorios']);
            return;
        }

        $resultado = $this->model->crear($usuario['id_usuario'], $titulo, $mensaje);

        echo json_encode(['success' => $resultado]);
    }
}
