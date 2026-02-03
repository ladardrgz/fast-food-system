<?php
class PaisController
{
    public function obtener()
    {
        header('Content-Type: application/json');
        $modelo = new PaisModel();
        echo json_encode($modelo->obtenerTodos());
    }
    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Nombre del país es requerido.'
            ]);
            return;
        }

        $nombre = trim($data['nombre']);
        $modelo = new PaisModel();

        if ($modelo->existeNombre($nombre)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya existe un país con ese nombre.'
            ]);
            return;
        }

        $creado = $modelo->crear($nombre);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'País creado correctamente.' : 'Error al crear país.'
        ]);
    }

    public function eliminar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_DELETE);

        if (empty($_DELETE['id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'ID del país es requerido para eliminar.'
            ]);
            return;
        }

        $id = (int) $_DELETE['id'];
        $modelo = new PaisModel();

        if ($modelo->estaEnUso($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se puede eliminar el país porque está en uso.'
            ]);
            return;
        }

        $eliminado = $modelo->eliminar($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'País eliminado correctamente.' : 'Error al eliminar país.'
        ]);
    }
            public function verFormulario()
    {
        $titulo = 'Gestión de países';
        $contenido = 'views/masters/pais.php';
        require 'views/layouts/main.php';
    }

}
