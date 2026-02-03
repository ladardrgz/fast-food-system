<?php
require_once 'Conexion.php';

class NotificacionModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene todas las notificaciones de un usuario, incluyendo la fecha de último login,
     * ordenadas por fecha de creación descendente.
     *
     * @param int $idUsuario
     * @return array
     */
    public function obtenerPorUsuario(int $idUsuario): array
    {
        $sql = "SELECT 
                    n.id_notificacion,
                    n.titulo_notificacion AS titulo,
                    n.mensaje_notificacion AS mensaje,
                    n.leida_notificacion AS leida,
                    n.fecha_creacion_notificacion AS fecha_creacion,
                    s.fecha_ultimo_login
                FROM notificaciones n
                LEFT JOIN sesiones s ON s.id_usuario = n.rela_usuario
                WHERE n.rela_usuario = :id
                ORDER BY n.fecha_creacion_notificacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUsuario]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta las notificaciones no leídas de un usuario.
     *
     * @param int $idUsuario
     * @return int
     */
    public function contarNoLeidas(int $idUsuario): int
    {
        $sql = "SELECT COUNT(*) 
                FROM notificaciones 
                WHERE rela_usuario = :id AND leida_notificacion = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUsuario]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Marca todas las notificaciones como leídas para un usuario.
     *
     * @param int $idUsuario
     * @return void
     */
    public function marcarLeidas(int $idUsuario): void
    {
        $sql = "UPDATE notificaciones 
                SET leida_notificacion = 1 
                WHERE rela_usuario = :id AND leida_notificacion = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUsuario]);
    }

    /**
     * Crea una nueva notificación para un usuario.
     *
     * @param int $idUsuario
     * @param string $titulo
     * @param string $mensaje
     * @return bool
     */
    public function crear(int $idUsuario, string $titulo, string $mensaje): bool
    {
        $sql = "INSERT INTO notificaciones (
                    rela_usuario, titulo_notificacion, mensaje_notificacion, leida_notificacion
                ) VALUES (:usuario, :titulo, :mensaje, 0)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':usuario' => $idUsuario,
            ':titulo'  => $titulo,
            ':mensaje' => $mensaje
        ]);
    }

    /**
     * Elimina todas las notificaciones de un usuario (opcional).
     *
     * @param int $idUsuario
     * @return void
     */
    public function eliminarPorUsuario(int $idUsuario): void
    {
        $sql = "DELETE FROM notificaciones WHERE rela_usuario = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUsuario]);
    }
}
