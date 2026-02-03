<?php
// models/SesionModel.php
require_once 'Conexion.php';

class SesionModel
{
    private $db;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->db = $conexion->Conectar();
    }

    public function marcarSesionActiva($idUsuario)
    {
        $stmt = $this->db->prepare("
            INSERT INTO sesiones (id_usuario, activa, fecha_ultimo_login)
            VALUES (?, 1, NOW())
            ON DUPLICATE KEY UPDATE activa = 1, fecha_ultimo_login = NOW()
        ");
        $stmt->execute([$idUsuario]);
    }

    public function marcarSesionInactiva($idUsuario)
    {
        $stmt = $this->db->prepare("UPDATE sesiones SET activa = 0 WHERE id_usuario = ?");
        $stmt->execute([$idUsuario]);
    }

    public function sesionActiva($idUsuario): bool
    {
        $stmt = $this->db->prepare("SELECT activa FROM sesiones WHERE id_usuario = ? LIMIT 1");
        $stmt->execute([$idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && (int)$row['activa'] === 1;
    }
    /**
     * Obtiene la fecha del último inicio de sesión del usuario.
     * @param int $usuarioId
     * @return string|null
     */
    public function obtenerUltimoLogin($usuarioId)
    {
        $sql = "SELECT fecha_ultimo_login 
                FROM sesiones 
                WHERE id_usuario = :id 
                ORDER BY fecha_ultimo_login DESC 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $usuarioId]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['fecha_ultimo_login'] : null;
    }
}
