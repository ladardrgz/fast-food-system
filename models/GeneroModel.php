<?php
require_once 'Conexion.php';

class GeneroModel {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->Conectar();
    }

    // Obtener todos los géneros ordenados por nombre
    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM generos ORDER BY nombre_genero");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo género
    public function crear($nombre) {
        $stmt = $this->db->prepare("INSERT INTO generos (nombre_genero) VALUES (:nombre)");
        return $stmt->execute([':nombre' => $nombre]);
    }

    // Eliminar un género por ID
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM generos WHERE id_genero = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Verificar si ya existe un género con ese nombre
    public function existeNombre($nombre) {
        $sql = "SELECT COUNT(*) FROM generos WHERE nombre_genero = :nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    // Verificar si el género está en uso por alguna persona
    public function estaEnUso($id) {
        $sql = "SELECT COUNT(*) FROM personas WHERE rela_genero = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }
}
