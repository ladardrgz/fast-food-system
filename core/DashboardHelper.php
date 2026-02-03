<?php
// Clase DashboardHelper.php que ayuda a determinar qué vista de dashboard cargar según el perfil del usuario
class DashboardHelper
{
    // Mapeo estático de perfiles de usuario a rutas de archivos de vistas correspondientes
    private static array $dashboardsPorPerfil = [
        'Administrador' => 'views/panel/partials/dashboard_admin.php',
        'Encargado'     => 'views/panel/partials/dashboard_estadisticas.php',
        'Empleado'      => 'views/panel/partials/dashboard_empleado.php',
        'Repartidor'    => 'views/panel/partials/dashboard_repartidor.php',
        'Cliente'       => 'views/panel/partials/dashboard_cliente.php',
    ];

    // Método público y estático que recibe un perfil como parámetro
    // Retorna la ruta del dashboard correspondiente, o null si el perfil no existe en el mapeo
    public static function obtenerDashboardPorPerfil(string $perfil): ?string
    {
        return self::$dashboardsPorPerfil[$perfil] ?? null;
    }
}
?>