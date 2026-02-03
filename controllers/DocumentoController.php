<?php
require_once 'models/DocumentoModel.php';

class DocumentoController
{
    /**
     * Inserta un nuevo documento (detalle_documentos)
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
        $valor = trim($data['valor'] ?? '');
        $tipo  = (int)($data['tipo'] ?? 0);

        if ($valor === '' || !$tipo) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        $modelo = new DocumentoModel();

        if ($modelo->existeDocumento($valor, $tipo)) {
            echo json_encode([
                'success' => false,
                'message' => 'El documento ya existe.'
            ]);
            return;
        }

        try {
            $id = $modelo->crear($valor, $tipo);
            echo json_encode([
                'success' => true,
                'message' => 'Documento creado correctamente.',
                'id'      => $id
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al crear el documento: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Listado general (si implementás un obtenerTodos de detalle_documentos)
     */
public function listar()
{
    header('Content-Type: application/json');

    try {
        $modelo = new TipoDocumentoModel(); // Cambiado acá
        $tipos = $modelo->obtenerTodos();

        echo json_encode([
            'success' => true,
            'data' => $tipos
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al obtener tipos de documento: ' . $e->getMessage()
        ]);
    }
}

    /**
     * Elimina un documento por ID
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

        try {
            $modelo = new DocumentoModel();
            $eliminado = $modelo->eliminar($id); 

            echo json_encode([
                'success' => $eliminado,
                'message' => $eliminado ? 'Documento eliminado correctamente.' : 'No se pudo eliminar el documento.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ]);
        }
    }
        public function verFormulario()
    {
        $titulo = 'Gestión de documentos';
        $contenido = 'views/masters/documento.php';
        require 'views/layouts/main.php';
    }
}
