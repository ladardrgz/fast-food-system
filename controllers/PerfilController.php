<?php
require_once 'models/PerfilModel.php';

class PerfilController
{
    /**
     * Devuelve los perfiles activos en formato JSON.
     */
    public function listar()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new PerfilModel();
            $perfiles = $modelo->obtenerTodos();
            echo json_encode($perfiles);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al cargar los perfiles: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Crea un nuevo perfil si no existe.
     */
    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = trim($data['nombre'] ?? '');

        if ($nombre === '') {
            echo json_encode(['success' => false, 'message' => 'El nombre del perfil es requerido.']);
            return;
        }

        $modelo = new PerfilModel();

        if ($modelo->existePerfil($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El perfil ya existe.']);
            return;
        }

        $creado = $modelo->crear($nombre);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Perfil creado correctamente.' : 'Error al crear el perfil.'
        ]);
    }

    /**
     * Desactiva (elimina lógicamente) un perfil.
     */
    public function eliminar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = (int) ($_DELETE['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID inválido.']);
            return;
        }

        $modelo = new PerfilModel();
        $eliminado = $modelo->desactivar($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Perfil eliminado correctamente.' : 'No se pudo eliminar el perfil.'
        ]);
    }

    /**
     * Muestra el formulario de gestión de perfiles.
     */
    public function verFormulario()
    {
        $titulo = 'Gestión de perfil';
        $contenido = 'views/masters/perfil.php';
        require 'views/layouts/main.php';
    }
}
