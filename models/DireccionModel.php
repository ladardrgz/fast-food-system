<?php
require_once 'Conexion.php';

class DireccionModel {
    private $db;
    public function __construct() {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Inserta una dirección y devuelve el id insertado.
     */
    public function crearDireccion(string $calle, string $numero, string $piso = null, string $dpto = null, int $idBarrio): int {
        $sql = "INSERT INTO direcciones 
                (calle_direccion, numero_direccion, piso_direccion, dpto_direccion, rela_barrios)
                VALUES (:calle, :numero, :piso, :dpto, :barrio)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':calle'  => $calle,
            ':numero' => $numero,
            ':piso'   => $piso,
            ':dpto'   => $dpto,
            ':barrio' => $idBarrio
        ]);
        return (int)$this->db->lastInsertId();
    }
}
?>
