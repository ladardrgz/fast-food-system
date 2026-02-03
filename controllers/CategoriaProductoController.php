<?php
require_once 'models/CategoriaProductoModel.php';

class CategoriaProductoController
{
    public function listar()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new CategoriaProductoModel();
            echo json_encode($modelo->obtenerTodas());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener categorías: ' . $e->getMessage()
            ]);
        }
    }

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
            echo json_encode(['success' => false, 'message' => 'El nombre de la categoría es requerido.']);
            return;
        }

        $modelo = new CategoriaProductoModel();

        if ($modelo->existeCategoria($nombre)) {
            echo json_encode(['success' => false, 'message' => 'La categoría ya existe.']);
            return;
        }

        $creado = $modelo->crear($nombre);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Categoría creada correctamente.' : 'Error al crear la categoría.'
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
        $id = (int) ($_DELETE['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID inválido.']);
            return;
        }

        $modelo = new CategoriaProductoModel();
        $eliminado = $modelo->eliminar($id);

        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Categoría eliminada correctamente.' : 'No se pudo eliminar la categoría.'
        ]);
    }

    public function verFormulario()
    {
        $titulo = 'Gestión de categoría de productos';
        $contenido = 'views/masters/categoria_producto.php';
        require 'views/layouts/main.php';
    }
}
