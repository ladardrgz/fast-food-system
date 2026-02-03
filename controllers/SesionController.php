<?php
require_once 'models/SesionModel.php';

class SesionController
{
    /**
     * Devuelve la fecha del último login del usuario actual.
     */
    public function obtenerUltimoLogin()
    {
        header('Content-Type: application/json');

        // Asegúrate de que el ID del usuario esté en sesión
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
            return;
        }

        $usuarioId = $_SESSION['usuario_id'];
        $modelo = new SesionModel();

        $fecha = $modelo->obtenerUltimoLogin($usuarioId);

        if ($fecha) {
            echo json_encode(['success' => true, 'fecha_ultimo_login' => $fecha]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró sesión registrada.']);
        }
    }
}
