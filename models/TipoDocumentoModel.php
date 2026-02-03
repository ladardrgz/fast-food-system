<?php
require_once 'Conexion.php';

class TipoDocumentoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene todos los tipos de documento
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT id_documento, nombre_documento 
                FROM tipos_documentos 
                ORDER BY nombre_documento";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si un tipo de documento ya existe
     */
    public function existeDocumento(string $nombre): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM tipos_documentos 
                WHERE LOWER(nombre_documento) = LOWER(:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crea un nuevo tipo de documento
     */
    public function crear(string $nombre): bool
    {
        $sql = "INSERT INTO tipos_documentos (nombre_documento) VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nombre' => $nombre]);
    }

    /**
     * Elimina un tipo de documento por su ID
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM tipos_documentos WHERE id_documento = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
