<?php
// controllers/ContactoController.php

class ContactoController
{
    /**
     * Crea un nuevo detalle de contacto (email, teléfono, etc.).
     * Espera un JSON con 'valor' y 'id_tipo'.
     */
    public function crear()
    {
        header('Content-Type: application/json');

        // Solo se permite método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido.'
            ]);
            return;
        }

        // Obtener y validar datos del cuerpo JSON
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['valor']) || empty($data['id_tipo'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Tipo y valor de contacto son requeridos.'
            ]);
            return;
        }

        $valor = trim($data['valor']);
        $idTipo = (int) $data['id_tipo'];

        $modelo = new ContactoModel();

        // Validar si ya existe el contacto
        if ($modelo->existeContacto($valor, $idTipo)) {
            echo json_encode([
                'success' => false,
                'message' => 'Este contacto ya está registrado.'
            ]);
            return;
        }

        // Crear el contacto
        $id = $modelo->crear($valor, $idTipo);

        echo json_encode([
            'success' => true,
            'id' => $id,
            'message' => 'Contacto creado correctamente.'
        ]);
    }
}
