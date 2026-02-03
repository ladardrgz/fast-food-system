<?php
require_once 'Conexion.php';

class ProvinciaModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene todas las provincias de la base de datos.
     *
     * @return array Array de provincias con id y nombre.
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT id_provincia, nombre_provincia FROM provincias ORDER BY nombre_provincia";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorPais(int $idPais): array
    {
        $sql = "SELECT id_provincia, nombre_provincia 
            FROM provincias 
            WHERE rela_pais = :pais 
            ORDER BY nombre_provincia";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':pais' => $idPais]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function crearProvincia(string $nombre, int $idPais): bool
    {
        $sql = "INSERT INTO provincias (nombre_provincia, rela_pais)
                SELECT :nombre, :pais
                WHERE NOT EXISTS (
                    SELECT 1 FROM provincias WHERE nombre_provincia = :nombre AND rela_pais = :pais
                )";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':pais' => $idPais
        ]);
    }

    public function eliminarProvinciaPorId(int $id): bool
    {
        $sql = "DELETE FROM provincias WHERE id_provincia = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerProvinciasConPais(): array
    {
        $sql = "SELECT p.id_provincia, p.nombre_provincia, ps.nombre_pais
                FROM provincias p
                JOIN paises ps ON p.rela_pais = ps.id_pais
                ORDER BY ps.nombre_pais, p.nombre_provincia";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function existeProvinciaPorNombre(string $nombre, int $idPais): bool
    {
        $sql = "SELECT COUNT(*) FROM provincias 
            WHERE nombre_provincia = :nombre AND rela_pais = :pais";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre, ':pais' => $idPais]);
        return $stmt->fetchColumn() > 0;
    }

    public function provinciaEstaEnUso(int $idProvincia): bool
    {
        // Validar si alguna tabla depende de provincia (ejemplo: localidades, etc.)
        $sql = "SELECT COUNT(*) FROM localidades WHERE rela_provincia = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idProvincia]);
        return $stmt->fetchColumn() > 0;
    }
}
