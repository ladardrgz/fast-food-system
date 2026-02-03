<?php
// models/ContactoModel.php
require_once 'Conexion.php';

class ContactoModel {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Crea un detalle de contacto y retorna su ID.
     *
     * @param string $valor
     * @param int $idTipo
     * @return int
     */
    public function crear(string $valor, int $idTipo): int {
        $sql = "INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
                VALUES (:valor, :tipo)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':valor' => $valor,
            ':tipo'  => $idTipo
        ]);
        return (int) $this->db->lastInsertId();
    }
    public function existeContacto(string $valor, int $idTipo): bool
{
    $sql = "SELECT COUNT(*) 
            FROM detalles_contactos 
            WHERE valor_contacto = :valor AND rela_tipo_contacto = :tipo";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':valor' => $valor,
        ':tipo'  => $idTipo
    ]);
    return $stmt->fetchColumn() > 0;
}

}
