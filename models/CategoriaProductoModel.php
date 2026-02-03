<?php
require_once 'Conexion.php';

class CategoriaProductoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    public function obtenerTodas(): array
    {
        $sql = "SELECT id_categoria, nombre_categoria 
                FROM categorias_productos 
                ORDER BY nombre_categoria";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeCategoria(string $nombre): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM categorias_productos 
                WHERE LOWER(nombre_categoria) = LOWER(:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear(string $nombre): bool
    {
        $sql = "INSERT INTO categorias_productos (nombre_categoria) 
                VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nombre' => $nombre]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM categorias_productos WHERE id_categoria = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
