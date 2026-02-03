<?php
require_once 'models/UnidadMedidaModel.php';

class UnidadMedidaController
{
    /**
     * Lista todas las unidades de medida.
     */
    public function listar()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new UnidadMedidaModel();
            echo json_encode($modelo->obtenerTodas());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener unidades: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Crea una nueva unidad de medida.
     */
    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $nombre = trim($data['nombre'] ?? '');
        $abreviatura = trim($data['abreviatura'] ?? '');

        if ($nombre === '' || $abreviatura === '') {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
            return;
        }

        $modelo = new UnidadMedidaModel();

        if ($modelo->existeUnidad($nombre)) {
            echo json_encode(['success' => false, 'message' => 'Ya existe una unidad con ese nombre.']);
            return;
        }

        $creado = $modelo->crear($nombre, $abreviatura);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Unidad creada correctamente.' : 'Error al crear la unidad.'
        ]);
    }

    /**
     * Elimina una unidad de medida por ID.
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

        $modelo = new UnidadMedidaModel();
        $eliminado = $modelo->eliminar($id);

        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Unidad eliminada correctamente.' : 'No se pudo eliminar la unidad.'
        ]);
    }

    /**
     * Muestra la vista del formulario de gestión de unidades.
     */
    public function verFormulario()
    {
        $titulo = 'Gestión de unidades de medida';
        $contenido = 'views/masters/unidad_medida.php';
        require 'views/layouts/main.php';
    }
}
