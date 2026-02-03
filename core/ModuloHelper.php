<?php
require_once 'models/ModuloModel.php';
require_once 'core/Sesion.php';
// Clase que permite obtener los módulos autorizados según el perfil del usuario en sesión.
// Es útil para cargar dinámicamente solo los módulos a los que un perfil tiene permiso de acceso.
class ModuloHelper
{
    public static function obtenerModulosAutorizados(): array
    {
        $usuario = Sesion::obtenerUsuario();
        if (!$usuario || empty($usuario['perfil_id'])) {
            return [];
        }

        $moduloModel = new ModuloModel();
        return $moduloModel->obtenerModulosPorPerfil($usuario['perfil_id']);
    }
}
