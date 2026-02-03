<?php
// controllers/LocalidadController.php

class LocalidadController
{
    public function obtener()
    {
        header('Content-Type: application/json');
        $modelo = new LocalidadModel();

        if (isset($_GET['id_provincia'])) {
            $idProvincia = (int) $_GET['id_provincia'];
            echo json_encode($modelo->obtenerPorProvincia($idProvincia));
        } else {
            echo json_encode($modelo->obtenerTodasConProvinciaYPais());
        }
    }

    public function crear()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre']) || empty($data['id_provincia'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Nombre y provincia son requeridos'
            ]);
            return;
        }

        $nombre = trim($data['nombre']);
        $idProvincia = (int) $data['id_provincia'];

        $modelo = new LocalidadModel();

        if ($modelo->existeLocalidad($nombre, $idProvincia)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya existe una localidad con ese nombre en la provincia seleccionada.'
            ]);
            return;
        }

        $creado = $modelo->crearLocalidad($nombre, $idProvincia);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Localidad creada correctamente' : 'Error al crear la localidad'
        ]);
    }

    public function eliminar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_DELETE);

        if (empty($_DELETE['id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'ID requerido para eliminar'
            ]);
            return;
        }

        $id = (int) $_DELETE['id'];
        $modelo = new LocalidadModel();

        if ($modelo->localidadEstaEnUso($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se puede eliminar la localidad porque está en uso.'
            ]);
            return;
        }

        $eliminado = $modelo->eliminarLocalidadPorId($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Localidad eliminada correctamente' : 'Error al eliminar la localidad'
        ]);
    }

    public function verFormulario()
    {
        $titulo = 'Gestión de localidad';
        $contenido = 'views/masters/localidad.php';
        require 'views/layouts/main.php';
    }
}
