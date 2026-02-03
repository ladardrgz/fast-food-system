<?php
// models/LocalidadModel.php
require_once 'Conexion.php';

class LocalidadModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }
    
    public function obtenerPorProvincia(int $idProvincia): array
{
    $sql = "SELECT id_localidad, nombre_localidad 
            FROM localidades 
            WHERE rela_provincia = :prov 
            ORDER BY nombre_localidad";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':prov' => $idProvincia]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /**
     * Obtiene todas las localidades con su provincia y país.
     *
     * @return array Lista de localidades con datos completos.
     */
    public function obtenerTodasConProvinciaYPais(): array
    {
        $sql = "SELECT l.id_localidad,
                l.nombre_localidad,
                p.id_provincia,
                p.nombre_provincia,
                ps.id_pais,
                ps.nombre_pais
                FROM localidades l
                JOIN provincias p ON l.rela_provincia = p.id_provincia
                JOIN paises ps ON p.rela_pais = ps.id_pais
                ORDER BY ps.nombre_pais, p.nombre_provincia, l.nombre_localidad";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva localidad si no existe ya en la provincia.
     *
     * @param string $nombre
     * @param int $idProvincia
     * @return bool True si se insertó correctamente, false si ya existía.
     */
    public function crearLocalidad(string $nombre, int $idProvincia): bool
    {
        // Verificar existencia previa
        if ($this->existeLocalidad($nombre, $idProvincia)) {
            return false;
        }

        $sql = "INSERT INTO localidades (nombre_localidad, rela_provincia)
                VALUES (:nombre, :provincia)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':provincia' => $idProvincia
        ]);
    }

    /**
     * Elimina una localidad por su ID.
     *
     * @param int $idLocalidad
     * @return bool True si se eliminó, false en caso contrario.
     */
    public function eliminarLocalidadPorId(int $idLocalidad): bool
    {
        $sql = "DELETE FROM localidades WHERE id_localidad = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $idLocalidad]);
    }

    /**
     * Verifica si ya existe una localidad con ese nombre en la provincia.
     *
     * @param string $nombre
     * @param int $idProvincia
     * @return bool
     */
    public function existeLocalidad(string $nombre, int $idProvincia): bool
    {
        $sql = "SELECT COUNT(*) FROM localidades
                WHERE nombre_localidad = :nombre
                  AND rela_provincia = :provincia";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':provincia' => $idProvincia
        ]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Verifica si la localidad está en uso en otras tablas (ejemplo futuro).
     *
     * @param int $idLocalidad
     * @return bool
     */
    public function localidadEstaEnUso(int $idLocalidad): bool
    {
        // En este caso no hay dependencias definidas,
        // pero si existieran otras tablas referenciando localidad,
        // aquí se implementaría la comprobación.
        return false;
    }
    public function obtenerTodos() {
    $stmt = $this->db->prepare("
        SELECT id_localidad, nombre_localidad 
        FROM localidades 
        ORDER BY nombre_localidad
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
