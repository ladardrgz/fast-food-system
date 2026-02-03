<?php
class ProvinciaController
{
    public function obtener()
    {
        header('Content-Type: application/json');
        $modelo = new ProvinciaModel();

        if (isset($_GET['id_pais'])) {
            $idPais = (int) $_GET['id_pais'];
            echo json_encode($modelo->obtenerPorPais($idPais));
        } else {
            echo json_encode($modelo->obtenerProvinciasConPais());
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

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre']) || empty($data['id_pais'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Nombre y país son requeridos.'
            ]);
            return;
        }

        $nombre = trim($data['nombre']);
        $idPais = (int) $data['id_pais'];
        $modelo = new ProvinciaModel();

        if ($modelo->existeProvinciaPorNombre($nombre, $idPais)) {
            echo json_encode([
                'success' => false,
                'message' => 'Ya existe una provincia con ese nombre en el país seleccionado.'
            ]);
            return;
        }

        $creado = $modelo->crearProvincia($nombre, $idPais);
        echo json_encode([
            'success' => $creado,
            'message' => $creado ? 'Provincia creada exitosamente.' : 'Error al crear la provincia.'
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
                'message' => 'ID de provincia requerido.'
            ]);
            return;
        }

        $id = (int) $_DELETE['id'];
        $modelo = new ProvinciaModel();

        if ($modelo->provinciaEstaEnUso($id)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se puede eliminar la provincia porque está en uso.'
            ]);
            return;
        }

        $eliminado = $modelo->eliminarProvinciaPorId($id);
        echo json_encode([
            'success' => $eliminado,
            'message' => $eliminado ? 'Provincia eliminada correctamente.' : 'Error al eliminar la provincia.'
        ]);
    }
    public function verFormulario()
    {
        $titulo = 'Gestión de provincias';
        $contenido = 'views/masters/provincia.php';
        require 'views/layouts/main.php';
    }
}
