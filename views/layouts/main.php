<!-- views/layouts/main.php -->
<?php
require_once 'core/Sesion.php';
require_once 'core/ModuloHelper.php';
$modulos = ModuloHelper::obtenerModulosAutorizados() ?? [];
$titulo = $titulo ?? 'FastFoodSystem';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/alertas.css">
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/navbar.css">
</head>

<body>
    <?php include 'views/layouts/navbar.php'; ?>

    <?php
    if (isset($contenido) && file_exists($contenido)) {
        include $contenido;
    } else {
        echo "<p class='text-danger'>Vista no encontrada.</p>";
    }
    ?>

    <script src="/FastFoodSystem/assets/js/navbar-navigation.js"></script>
    <script src="/FastFoodSystem/assets/js/notificaciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>