<?php
require_once 'Conexion.php';

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Crea un nuevo usuario con contraseña encriptada
     */
    public function crearUsuario(string $usuarioNombre, string $contrasena, int $idPersona, int $idPerfil): bool
    {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO usuarios 
                (nombre_usuario, password_usuario, rela_persona, rela_perfil) 
                VALUES (:user, :pass, :persona, :perfil)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user'    => $usuarioNombre,
            ':pass'    => $hash,
            ':persona' => $idPersona,
            ':perfil'  => $idPerfil
        ]);
    }

    /**
     * Verifica si el nombre de usuario ya existe
     */
    public function existeUsuario(string $usuario): bool
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Cambia la contraseña de forma segura, validando la anterior
     */
    public function cambiarContrasenaSegura(int $id, string $nuevaContrasena, string $actualContrasena): bool
    {
        $sql = "SELECT password_usuario FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $hashActual = $stmt->fetchColumn();

        if (!$hashActual || !password_verify($actualContrasena, $hashActual)) {
            throw new Exception("La contraseña actual no es válida.");
        }

        if (password_verify($nuevaContrasena, $hashActual)) {
            throw new Exception("La nueva contraseña no puede ser igual a la anterior.");
        }

        $nuevoHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password_usuario = :pass WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':pass' => $nuevoHash,
            ':id' => $id
        ]);
    }

    /**
     * Devuelve el usuario por su ID (usado en la edición de perfil)
     */
    public function obtenerUsuarioPorId(int $id): array|false
    {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Verifica credenciales (usuario o correo)
     */
    public function verificarCredenciales(string $usuarioOEmail): array|false
    {
        $sql = "
            SELECT u.*, p.nombre AS nombre_persona, per.nombre_perfil AS perfil
            FROM usuarios u
            JOIN personas p ON u.rela_persona = p.id_persona
            JOIN perfiles per ON u.rela_perfil = per.id_perfil
            LEFT JOIN detalles_contactos dc ON p.rela_contacto = dc.id_contacto AND dc.rela_tipo_contacto = 1
            WHERE u.nombre_usuario = :valor OR dc.valor_contacto = :valor
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':valor' => $usuarioOEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un usuario por correo electrónico
     */
    public function obtenerPorCorreo($email)
    {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            $stmt = $this->db->prepare("
            SELECT * FROM usuarios u 
            JOIN personas p ON u.rela_persona = p.id_persona 
            JOIN detalles_contactos dc ON p.rela_contacto = dc.id_contacto
            WHERE dc.valor_contacto = ? AND dc.rela_tipo_contacto = 1 
            LIMIT 1
        ");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerPorCorreo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Guarda una contraseña temporal encriptada con vencimiento
     */
    public function guardarTemporal($idUsuario, $tempPass, $expira)
    {
        try {
            // Hashear la contraseña temporal
            $hashTemp = password_hash($tempPass, PASSWORD_DEFAULT);

            // Guardar tanto el hash como la versión visible
            $stmt = $this->db->prepare("
            UPDATE usuarios 
            SET password_temporal = ?, 
                password_temporal_visible = ?, 
                expiracion_password_temporal = ?
            WHERE id_usuario = ?
        ");

            return $stmt->execute([$hashTemp, $tempPass, $expira, $idUsuario]);
        } catch (PDOException $e) {
            error_log("Error en guardarTemporal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Devuelve todos los datos relevantes del perfil de un usuario,
     * incluyendo información personal, dirección, contacto y género.
     */
    public function obtenerDatosCompletosPerfil(int $idUsuario): array|false
    {
        $sql = "
            SELECT 
                u.nombre_usuario,
                p.nombre_persona,
                p.apellido_persona,
                p.fecha_nacimiento_persona,
                g.nombre_genero,
                
                dc_email.valor_contacto AS correo,
                dc_tel.valor_contacto AS telefono,
                
                d.calle_direccion,
                d.numero_direccion,
                b.nombre_barrio,
                l.nombre_localidad,
                pr.nombre_provincia,
                pa.nombre_pais

            FROM usuarios u
            JOIN personas p ON u.rela_persona = p.id_persona
            LEFT JOIN generos g ON p.rela_genero = g.id_genero
            LEFT JOIN direcciones d ON p.rela_direccion = d.id_direccion
            LEFT JOIN barrios b ON d.rela_barrios = b.id_barrio
            LEFT JOIN localidades l ON b.rela_localidad = l.id_localidad
            LEFT JOIN provincias pr ON l.rela_provincia = pr.id_provincia
            LEFT JOIN paises pa ON pr.rela_pais = pa.id_pais
            
            LEFT JOIN detalles_contactos dc_email 
                ON p.rela_contacto = dc_email.id_contacto AND dc_email.rela_tipo_contacto = 1
            LEFT JOIN detalles_contactos dc_tel 
                ON p.rela_contacto = dc_tel.id_contacto AND dc_tel.rela_tipo_contacto = 2

            WHERE u.id_usuario = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza el nombre de usuario de un usuario específico
     */
    public function actualizarNombreUsuario(int $idUsuario, string $nuevoNombre): bool
    {
        $sql = "UPDATE usuarios SET nombre_usuario = :nombre WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nuevoNombre,
            ':id' => $idUsuario
        ]);
    }
    public function actualizarClaveUsuario(int $idUsuario, string $hash): bool
    {
        $sql = "UPDATE usuarios SET password_usuario = :clave WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':clave' => $hash,
            ':id' => $idUsuario
        ]);
    }
}
