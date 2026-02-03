<?php
require_once 'Conexion.php';

class PermisoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Devuelve todos los módulos con información de si están asignados al perfil.
     * @param int $perfilId
     * @return array
     */
    public function obtenerModulosConEstado(int $perfilId): array
    {
        $sql = "
            SELECT 
                m.id_modulo,
                m.descripcion_modulo,
                CASE WHEN mp.rela_perfil IS NOT NULL THEN 1 ELSE 0 END AS asignado
            FROM modulos m
            LEFT JOIN modulos_perfiles mp
                ON m.id_modulo = mp.rela_modulo AND mp.rela_perfil = :perfil
            WHERE m.activo_modulo = 1
            ORDER BY m.descripcion_modulo
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':perfil' => $perfilId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Asigna un módulo a un perfil (crea la relación si no existe).
     * @param int $perfilId
     * @param int $moduloId
     * @return bool
     */
    public function asignarModulo(int $perfilId, int $moduloId): bool
    {
        // Verificar si ya está asignado
        $verificar = "SELECT COUNT(*) FROM modulos_perfiles WHERE rela_perfil = :perfil AND rela_modulo = :modulo";
        $stmt = $this->db->prepare($verificar);
        $stmt->execute([':perfil' => $perfilId, ':modulo' => $moduloId]);

        if ($stmt->fetchColumn() > 0) {
            return true; 
        }

        $sql = "INSERT INTO modulos_perfiles (rela_perfil, rela_modulo) VALUES (:perfil, :modulo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':perfil' => $perfilId, ':modulo' => $moduloId]);
    }

    /**
     * Desasigna un módulo de un perfil (elimina la relación).
     * @param int $perfilId
     * @param int $moduloId
     * @return bool
     */
    public function desasignarModulo(int $perfilId, int $moduloId): bool
    {
        $sql = "DELETE FROM modulos_perfiles WHERE rela_perfil = :perfil AND rela_modulo = :modulo";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':perfil' => $perfilId, ':modulo' => $moduloId]);
    }
}
