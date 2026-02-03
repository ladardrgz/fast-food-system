<?php
require_once 'models/GeneroModel.php';

class GeneroController
{
    public function obtener()
    {
        header('Content-Type: application/json');
        $modelo = new GeneroModel();
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
                'message' => 'Nombre del género es requerido.'
            ]);
            return;
        }

        $nombre = trim($data['nombre']);
        $modelo = new GeneroModel();

        if ($modelo->existeNombre($nombre)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya existe un género con ese nombre.'
            ]);
            return;
        }

        $creado = $modelo->crear($nombre);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Género creado correctamente.' : 'Error al crear género.'
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
                'message' => 'ID del género es requerido para eliminar.'
            ]);
            return;
        }

        $id = (int) $_DELETE['id'];
        $modelo = new GeneroModel();

        if ($modelo->estaEnUso($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se puede eliminar el género porque está en uso.'
            ]);
            return;
        }

        $eliminado = $modelo->eliminar($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Género eliminado correctamente.' : 'Error al eliminar género.'
        ]);
    }

    public function verFormulario()
    {
        $titulo = 'Gestión de géneros';
        $contenido = 'views/masters/genero.php';
        require 'views/layouts/main.php';
    }
}
