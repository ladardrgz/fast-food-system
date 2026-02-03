<?php
require_once 'models/PermisoModel.php';
require_once 'models/PerfilModel.php';
require_once 'models/ModuloModel.php';

class PermisoController
{
    /**
     * Carga la vista principal para asignar permisos.
     */
    public function verFormulario()
    {
        $titulo = 'Asignación de permisos';
        $contenido = 'views/masters/permisos.php';
        require 'views/layouts/main.php';
    }

    /**
     * Devuelve todos los módulos con su estado (asignado o no) para un perfil.
     * Se usa en JS para mostrar switches activos o inactivos.
     */
    public function modulosPorPerfil()
    {
        header('Content-Type: application/json');

        $perfilId = (int) ($_GET['id'] ?? 0);

        if (!$perfilId) {
            echo json_encode(['success' => false, 'message' => 'ID de perfil inválido']);
            return;
        }

        $permisoModel = new PermisoModel();
        $modulos = $permisoModel->obtenerModulosConEstado($perfilId);

        echo json_encode(['success' => true, 'modulos' => $modulos]);
    }

    /**
     * Asigna un módulo a un perfil (crea relación).
     */
    public function asignar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $perfilId = (int) ($data['perfilId'] ?? 0);
        $moduloId = (int) ($data['moduloId'] ?? 0);

        if (!$perfilId || !$moduloId) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        $modelo = new PermisoModel();
        $resultado = $modelo->asignarModulo($perfilId, $moduloId);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Permiso asignado.' : 'Error al asignar permiso.'
        ]);
    }

    /**
     * Desasigna un módulo de un perfil (elimina relación).
     */
    public function desasignar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_DELETE);
        $perfilId = (int) ($_DELETE['perfilId'] ?? 0);
        $moduloId = (int) ($_DELETE['moduloId'] ?? 0);

        if (!$perfilId || !$moduloId) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        $modelo = new PermisoModel();
        $resultado = $modelo->desasignarModulo($perfilId, $moduloId);

        echo json_encode([
            'success' => $resultado,
            'message' => $resultado ? 'Permiso eliminado.' : 'Error al eliminar permiso.'
        ]);
    }
}
