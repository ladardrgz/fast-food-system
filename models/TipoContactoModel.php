<?php
require_once 'Conexion.php';

class TipoContactoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT id_tipo_contacto, nombre_contacto 
                FROM tipos_contactos 
                ORDER BY nombre_contacto";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeTipo(string $descripcion): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM tipos_contactos 
                WHERE LOWER(nombre_contacto) = LOWER(:desc)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':desc' => $descripcion]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear(string $descripcion): bool
    {
        $sql = "INSERT INTO tipos_contactos (nombre_contacto) VALUES (:desc)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':desc' => $descripcion]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM tipos_contactos WHERE id_tipo_contacto = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
