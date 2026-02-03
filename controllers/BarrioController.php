<?php
// controllers/BarrioController.php

class BarrioController
{
    public function obtener()
    {
        header('Content-Type: application/json');
        $modelo = new BarrioModel();

        if (isset($_GET['id_localidad'])) {
            $idLoc = (int) $_GET['id_localidad'];
            echo json_encode($modelo->obtenerPorLocalidad($idLoc));
        } else {
            echo json_encode($modelo->obtenerTodosConLocalidad());
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

        if (empty($data['nombre']) || empty($data['id_localidad'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Nombre y localidad son requeridos.'
            ]);
            return;
        }

        $nombre = trim($data['nombre']);
        $idLocalidad = (int) $data['id_localidad'];
        $modelo = new BarrioModel();

        if ($modelo->existeNombre($nombre, $idLocalidad)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya existe un barrio con ese nombre en la localidad seleccionada.'
            ]);
            return;
        }

        $creado = $modelo->crear($nombre, $idLocalidad);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Barrio creado correctamente.' : 'Error al crear el barrio.'
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
            echo json_encode(['success' => false, 'message' => 'ID del barrio requerido.']);
            return;
        }

        $id = (int) $_DELETE['id'];
        $modelo = new BarrioModel();

        if ($modelo->estaEnUso($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se puede eliminar el barrio porque está en uso.'
            ]);
            return;
        }

        $eliminado = $modelo->eliminar($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Barrio eliminado correctamente.' : 'Error al eliminar el barrio.'
        ]);
    }

    public function verFormulario()
    {
        $titulo = 'Gestión de barrio';
        $contenido = 'views/masters/barrio.php';
        require 'views/layouts/main.php';
    }
}
