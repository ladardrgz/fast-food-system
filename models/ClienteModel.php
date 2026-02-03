<?php

class ClienteModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    public function crearCliente($idPersona)
    {
        $stmt = $this->db->prepare("INSERT INTO clientes (rela_persona) VALUES (:id)");
        return $stmt->execute([':id' => $idPersona]);
    }

    public function obtenerClientePorPersona($idPersona)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE rela_persona = :id");
        $stmt->execute([':id' => $idPersona]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Puedes agregar más métodos aquí, como actualizar o desactivar un cliente
}
