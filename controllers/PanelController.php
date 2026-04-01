<?php
require_once 'core/Sesion.php';
require_once 'core/ModuloHelper.php';
require_once 'core/DashboardHelper.php'; 

class PanelController
{
    // Acción por defecto: redirige al dashboard
    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        Sesion::requerirLogin();

        $usuario = Sesion::obtenerUsuario();
        $usuarioNombre = $usuario['nombre_usuario'] ?? 'Invitado';
        $perfil = $usuario['perfil'] ?? null;

        if (!$perfil) {
            echo "<p>Error: el perfil del usuario no está definido.</p>";
            exit;
        }

        $modulos = ModuloHelper::obtenerModulosAutorizados();

        // NUEVO: dashboard configurable
        $contenido = DashboardHelper::obtenerDashboardPorPerfil($perfil);

        if (!$contenido || !file_exists($contenido)) {
            echo "<p>Error: contenido no disponible para este perfil.</p>";
            exit;
        }

        $titulo = 'Panel de inicio | FastFoodSystem';
        require 'views/panel/dashboard.php';
    }
}
