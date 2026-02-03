<?php
require_once 'Conexion.php';

class BarrioModel {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->Conectar();
    }

    public function obtenerTodos(): array {
        $sql = "SELECT id_barrio, nombre_barrio, rela_localidad 
                FROM barrios 
                ORDER BY nombre_barrio";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorLocalidad(int $idLocalidad): array {
        $sql = "SELECT id_barrio, nombre_barrio 
                FROM barrios 
                WHERE rela_localidad = :loc 
                ORDER BY nombre_barrio";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':loc' => $idLocalidad]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ NUEVO: obtiene todos los barrios con localidad, provincia y país
    public function obtenerTodosConLocalidad(): array {
        $sql = "SELECT 
                    b.id_barrio,
                    b.nombre_barrio,
                    l.nombre_localidad,
                    p.nombre_provincia,
                    pais.nombre_pais
                FROM barrios b
                INNER JOIN localidades l ON b.rela_localidad = l.id_localidad
                INNER JOIN provincias p ON l.rela_provincia = p.id_provincia
                INNER JOIN paises pais ON p.rela_pais = pais.id_pais
                ORDER BY pais.nombre_pais, p.nombre_provincia, l.nombre_localidad, b.nombre_barrio";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeNombre(string $nombre, int $idLocalidad): bool {
        $sql = "SELECT COUNT(*) 
                FROM barrios 
                WHERE nombre_barrio = :nombre AND rela_localidad = :loc";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':loc'    => $idLocalidad
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear(string $nombre, int $idLocalidad): bool {
        $sql = "INSERT INTO barrios (nombre_barrio, rela_localidad) 
                VALUES (:nombre, :loc)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':loc'    => $idLocalidad
        ]);
    }

    public function estaEnUso(int $idBarrio): bool {
        $sql = "SELECT COUNT(*) 
                FROM direcciones 
                WHERE rela_barrios = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idBarrio]);
        return $stmt->fetchColumn() > 0;
    }

    public function eliminar(int $id): bool {
        $sql = "DELETE FROM barrios WHERE id_barrio = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
