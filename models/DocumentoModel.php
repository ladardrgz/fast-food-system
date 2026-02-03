<?php
require_once 'Conexion.php';

class DocumentoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Inserta un nuevo documento con valor y tipo
     */
    public function crear(string $valorDocumento, int $idTipoDocumento): int
    {
        $sql = "INSERT INTO detalle_documentos 
                (valor_documento, rela_tipo_documento)
                VALUES (:valor, :tipo)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':valor' => $valorDocumento,
            ':tipo'  => $idTipoDocumento
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Verifica si existe un documento con ese número y tipo
     */
    public function existeDocumento(string $valor, int $tipo): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM detalle_documentos 
                WHERE valor_documento = :valor AND rela_tipo_documento = :tipo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':valor' => $valor,
            ':tipo'  => $tipo
        ]);
        return $stmt->fetchColumn() > 0;
    }
    // Obtener todos los documentos con su tipo
    public function obtenerTodos(): array
    {
        $sql = "SELECT d.id_detalle_documento, d.valor_documento, 
            t.id_documento, t.nombre_documento
            FROM detalle_documentos d
            JOIN tipos_documentos t ON d.rela_tipo_documento = t.id_documento
            ORDER BY d.id_detalle_documento";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar documento por ID
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM detalle_documentos WHERE id_detalle_documento = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
}
