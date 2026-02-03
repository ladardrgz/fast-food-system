<?php
require_once 'Conexion.php';
require_once 'DireccionModel.php';
require_once 'DocumentoModel.php';
require_once 'ContactoModel.php';
require_once 'GeneroModel.php';

class PersonaModel
{
    private $db;
    private $dirModel;
    private $docModel;
    private $contactModel;
    private $generoModel;

    public function __construct()
    {
        $this->db           = (new Conexion())->Conectar();
        $this->dirModel     = new DireccionModel();
        $this->docModel     = new DocumentoModel();
        $this->contactModel = new ContactoModel();
        $this->generoModel = new GeneroModel();
    }

    /**
     * Crea una nueva persona junto con dirección, documento y contacto.
     * El campo `rela_genero` es obligatorio y debe estar presente en $datos['genero'].
     */
    public function crearPersona(array $datos): int
    {
        try {
            $this->db->beginTransaction();

            // Crear registros relacionados
            $idDir  = $this->dirModel->crearDireccion(
                $datos['calle'],
                $datos['numero'],
                $datos['piso'] ?? null,
                $datos['dpto'] ?? null,
                $datos['barrio']
            );
            $idDoc  = $this->docModel->crear($datos['valorDoc'], $datos['tipoDoc']);
            $idCont = $this->contactModel->crear($datos['valorCont'], $datos['tipoCont']);

            // Crear persona principal
            $sql = "INSERT INTO personas (
                        nombre_persona, 
                        apellido_persona, 
                        fecha_nacimiento_persona,
                        rela_direccion, 
                        rela_documento, 
                        rela_contacto, 
                        rela_genero
                    )
                    VALUES (:nombre, :apellido, :fnac, :dir, :doc, :cont, :genero)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre'   => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':fnac'     => $datos['fechaNacimiento'],
                ':dir'      => $idDir,
                ':doc'      => $idDoc,
                ':cont'     => $idCont,
                ':genero'   => $datos['genero']
            ]);

            $idPersona = (int)$this->db->lastInsertId();

            $this->db->commit();
            return $idPersona;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    /**
     * Verifica si existe una persona con un documento específico.
     */
    public function existeDocumento(string $numero, int $tipo): bool
    {
        $sql = "SELECT COUNT(*) FROM personas p
                JOIN detalle_documentos d ON p.rela_documento = d.id_detalle_documento
                WHERE d.valor_documento = :numero AND d.rela_tipo_documento = :tipo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':numero' => $numero,
            ':tipo'   => $tipo
        ]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Actualiza datos básicos de una persona.
     *
     * Campos esperados: nombre, apellido, fechaNacimiento,
     * [genero, direccion, documento, contacto] (opcionales)
     */
    public function actualizarPersona(int $idPersona, array $datos): bool
    {
        $camposSql = "
        nombre_persona = :nombre,
        apellido_persona = :apellido,
        fecha_nacimiento_persona = :fecha
    ";

        $params = [
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':fecha' => $datos['fechaNacimiento'],
            ':id' => $idPersona
        ];

        if (isset($datos['genero'])) {
            $camposSql .= ", rela_genero = :genero";
            $params[':genero'] = $datos['genero'];
        }

        if (isset($datos['direccion'])) {
            $camposSql .= ", rela_direccion = :direccion";
            $params[':direccion'] = $datos['direccion'];
        }

        $sql = "UPDATE personas SET $camposSql WHERE id_persona = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Devuelve los datos de una persona por ID
     */
    public function obtenerPersonaPorId(int $idPersona): array|false
    {
        $sql = "SELECT * FROM personas WHERE id_persona = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idPersona]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerGeneros(): array
{
    return $this->generoModel->obtenerTodos();
}

}
