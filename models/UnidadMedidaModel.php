<?php
require_once 'Conexion.php';

class UnidadMedidaModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene todas las unidades de medida.
     */
    public function obtenerTodas(): array
    {
        $sql = "SELECT 
                id_unidad, 
                nombre_unidad_medida AS nombre, 
                abreviatura_unidad_medida AS abreviatura
            FROM unidades_medida 
            ORDER BY nombre_unidad_medida ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si ya existe una unidad con ese nombre (sin distinguir mayúsculas/minúsculas).
     */
    public function existeUnidad(string $nombre): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM unidades_medida 
                WHERE LOWER(nombre_unidad_medida) = LOWER(:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crea una nueva unidad de medida.
     */
    public function crear(string $nombre, string $abreviatura): bool
    {
        $sql = "INSERT INTO unidades_medida (nombre_unidad_medida, abreviatura_unidad_medida) 
                VALUES (:nombre, :abreviatura)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':abreviatura' => $abreviatura
        ]);
    }

    /**
     * Elimina una unidad por ID.
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM unidades_medida WHERE id_unidad = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
