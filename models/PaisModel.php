<?php
require_once 'Conexion.php';

class PaisModel {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->Conectar();
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM paises ORDER BY nombre_pais");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre) {
        $stmt = $this->db->prepare("INSERT INTO paises (nombre_pais) VALUES (:nombre)");
        return $stmt->execute([':nombre' => $nombre]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM paises WHERE id_pais = :id");
        return $stmt->execute([':id' => $id]);
    }
    public function existeNombre($nombre) {
    $sql = "SELECT COUNT(*) FROM paises WHERE nombre_pais = :nombre";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':nombre' => $nombre]);
    return $stmt->fetchColumn() > 0;
}

public function estaEnUso($id) {
    $sql = "SELECT COUNT(*) FROM provincias WHERE rela_pais = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetchColumn() > 0;
}

}
