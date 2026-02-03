<?php
require_once 'Conexion.php';

class AuthModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Obtiene los datos básicos de un usuario por su nombre de usuario.
     * Este método es simple y no incluye relaciones con perfiles o contacto.
     *
     * @param string $nombreUsuario
     * @return array|false
     */
    public function obtenerUsuarioParaLogin(string $nombreUsuario): array|false
    {
        $sql = "SELECT id_usuario, nombre_usuario, password_usuario, estado_usuario
                FROM usuarios 
                WHERE nombre_usuario = :nombre_usuario 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica las credenciales de un usuario para login, aceptando nombre de usuario o email (tipo contacto = 1).
     * Devuelve datos del usuario incluyendo su perfil, estado y contraseñas (temporal y principal).
     *
     * @param string $usuarioOEmail Nombre de usuario o correo electrónico
     * @return array|false Datos del usuario o false si no se encuentra
     */
    public function verificarCredenciales(string $usuarioOEmail): array|false
    {
        $sql = "SELECT 
                    u.id_usuario, 
                    u.nombre_usuario, 
                    u.password_usuario, 
                    u.password_temporal, 
                    u.expiracion_password_temporal, 
                    u.estado_usuario,
                    p.id_perfil AS perfil_id,
                    p.descripcion_perfil AS perfil
                FROM usuarios u
                INNER JOIN perfiles p ON u.rela_perfil = p.id_perfil
                INNER JOIN personas per ON u.rela_persona = per.id_persona
                INNER JOIN detalles_contactos dc ON per.rela_contacto = dc.id_contacto
                WHERE (
                    u.nombre_usuario = :usuario
                    OR (dc.valor_contacto = :usuario AND dc.rela_tipo_contacto = 1)
                )
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':usuario', $usuarioOEmail, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
