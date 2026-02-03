<?php
// models/PerfilModel.php

require_once 'Conexion.php';

class PerfilModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->Conectar();
    }

    /**
     * Devuelve todos los perfiles activos.
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT id_perfil, descripcion_perfil 
                FROM perfiles 
                WHERE activo_perfil = 1 
                ORDER BY descripcion_perfil";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve un perfil activo por su ID.
     */
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT id_perfil, descripcion_perfil 
                FROM perfiles 
                WHERE id_perfil = :id AND activo_perfil = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $perfil = $stmt->fetch(PDO::FETCH_ASSOC);
        return $perfil ?: null;
    }

    /**
     * Verifica si ya existe un perfil activo con ese nombre.
     */
    public function existePerfil(string $nombre): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM perfiles 
                WHERE LOWER(descripcion_perfil) = LOWER(:nombre) 
                AND activo_perfil = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crea un nuevo perfil.
     */
    public function crear(string $nombre): bool
    {
        $sql = "INSERT INTO perfiles (descripcion_perfil) 
                VALUES (:nombre)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nombre' => $nombre]);
    }

    /**
     * Desactiva lógicamente un perfil (soft delete).
     */
    public function desactivar(int $id): bool
    {
        $sql = "UPDATE perfiles 
                SET activo_perfil = 0 
                WHERE id_perfil = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
