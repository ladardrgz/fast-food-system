<?php
require_once 'Conexion.php';

class IngredienteModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene todos los ingredientes con la unidad correspondiente.
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT 
                    i.id_ingrediente, 
                    i.nombre_ingrediente, 
                    u.nombre_unidad_medida AS unidad_nombre, 
                    u.abreviatura_unidad_medida AS abreviatura
                FROM ingredientes i
                INNER JOIN unidades_medida u ON i.rela_unidad = u.id_unidad
                ORDER BY i.nombre_ingrediente";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si ya existe un ingrediente con ese nombre (sin distinguir mayúsculas/minúsculas).
     */
    public function existeIngrediente(string $nombre): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM ingredientes 
                WHERE LOWER(nombre_ingrediente) = LOWER(:nombre)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crea un nuevo ingrediente con nombre e ID de unidad.
     */
    public function crear(string $nombre, int $idUnidad): bool
    {
        $sql = "INSERT INTO ingredientes (nombre_ingrediente, rela_unidad) 
                VALUES (:nombre, :unidad)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':unidad' => $idUnidad
        ]);
    }

    /**
     * Elimina un ingrediente por su ID.
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM ingredientes WHERE id_ingrediente = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
