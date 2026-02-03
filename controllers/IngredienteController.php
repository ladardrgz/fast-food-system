<?php
require_once 'models/IngredienteModel.php';

class IngredienteController
{
    /**
     * Retorna todos los ingredientes con su unidad asociada.
     */
    public function listar()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new IngredienteModel();
            echo json_encode($modelo->obtenerTodos());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener ingredientes: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Crea un nuevo ingrediente.
     * Espera JSON con: nombre, id_unidad
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
        $idUnidad = (int) ($data['id_unidad'] ?? 0);

        if ($nombre === '' || !$idUnidad) {
            echo json_encode([
                'success' => false,
                'message' => 'Nombre y unidad son obligatorios.'
            ]);
            return;
        }

        $modelo = new IngredienteModel();

        if ($modelo->existeIngrediente($nombre)) {
            echo json_encode([
                'success' => false,
                'message' => 'El ingrediente ya existe.'
            ]);
            return;
        }

        $creado = $modelo->crear($nombre, $idUnidad);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Ingrediente creado correctamente.' : 'Error al crear el ingrediente.'
        ]);
    }

    /**
     * Elimina un ingrediente por ID.
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

        $modelo = new IngredienteModel();
        $eliminado = $modelo->eliminar($id);

        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Ingrediente eliminado correctamente.' : 'No se pudo eliminar el ingrediente.'
        ]);
    }

    /**
     * Muestra el formulario principal de gestión de ingredientes.
     */
    public function verFormulario()
    {
        $titulo = 'Gestión de ingredientes';
        $contenido = 'views/masters/ingrediente.php';
        require 'views/layouts/main.php';
    }
}
