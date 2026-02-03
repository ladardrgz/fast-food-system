<?php
require_once 'models/TipoDocumentoModel.php';

class TipoDocumentoController
{
    /**
     * Devuelve todos los tipos de documento en formato JSON
     */
    public function obtener()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new TipoDocumentoModel();
            $tipos = $modelo->obtenerTodos();

            echo json_encode(array_map(function ($t) {
                return [
                    'id' => $t['id_documento'],
                    'nombre' => $t['nombre_documento']
                ];
            }, $tipos));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener tipos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Crea un nuevo tipo de documento (POST con JSON)
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
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'El nombre no puede estar vacío.']);
            return;
        }

        $modelo = new TipoDocumentoModel();

        if ($modelo->existeDocumento($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El tipo de documento ya existe.']);
            return;
        }

        try {
            $creado = $modelo->crear($nombre);
            echo json_encode([
                'success' => $creado,
                'message' => $creado ? 'Tipo de documento creado correctamente.' : 'No se pudo crear el tipo.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al crear tipo de documento: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Elimina un tipo de documento por ID (POST con id)
     */
    public function eliminar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID inválido.']);
            return;
        }

        $modelo = new TipoDocumentoModel();

        try {
            $eliminado = $modelo->eliminar($id);
            echo json_encode([
                'success' => $eliminado,
                'message' => $eliminado ? 'Tipo de documento eliminado correctamente.' : 'No se pudo eliminar el tipo.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar tipo de documento: ' . $e->getMessage()
            ]);
        }
    }
}
