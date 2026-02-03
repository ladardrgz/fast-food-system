<?php
require_once 'models/TipoContactoModel.php';

class TipoContactoController
{
    public function obtener()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new TipoContactoModel();
            $tipos = $modelo->obtenerTodos();

            echo json_encode(array_map(function ($t) {
                return [
                    'id' => $t['id_tipo_contacto'],
                    'nombre' => $t['nombre_contacto']
                ];
            }, $tipos));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener tipos de contacto: ' . $e->getMessage()
            ]);
        }
    }

    public function listar()
    {
        header('Content-Type: application/json');

        try {
            $modelo = new TipoContactoModel();
            echo json_encode($modelo->obtenerTodos());
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener tipos de contacto: ' . $e->getMessage()
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

        // Leer JSON del cuerpo
        $data = json_decode(file_get_contents("php://input"), true);
        $descripcion = trim($data['nombre'] ?? '');

        if ($descripcion === '') {
            echo json_encode(['success' => false, 'message' => 'La descripción es requerida.']);
            return;
        }

        $modelo = new TipoContactoModel();

        if ($modelo->existeTipo($descripcion)) {
            echo json_encode(['success' => false, 'message' => 'El tipo de contacto ya existe.']);
            return;
        }

        $creado = $modelo->crear($descripcion);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Tipo de contacto creado correctamente.' : 'Error al crear el tipo.'
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

        // Leer datos desde DELETE (simulado con URLSearchParams)
        parse_str(file_get_contents("php://input"), $data);
        $id = (int) ($data['id'] ?? 0);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID inválido.']);
            return;
        }

        $modelo = new TipoContactoModel();
        $eliminado = $modelo->eliminar($id);

        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Tipo de contacto eliminado.' : 'No se pudo eliminar.'
        ]);
    }

    public function verFormulario()
    {
        $titulo = 'Gestión de tipos de contacto';
        $contenido = 'views/masters/tipo_contacto.php';
        require 'views/layouts/main.php';
    }
}
