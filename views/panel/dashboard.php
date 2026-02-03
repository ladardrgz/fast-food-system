<?php
// Variables requeridas: $usuarioNombre, $contenido, $titulo
$titulo = $titulo ?? 'Dashboard | FastFoodSystem';

// Inicia buffer de salida para capturar el contenido
ob_start();
?>

<!-- Diseño visual del dashboard -->
<div class="container mt-4">
    <?php
    if (isset($contenido) && file_exists($contenido)) {
        include $contenido;
    } else {
        echo "<p class='text-danger'>Contenido no disponible.</p>";
    }
    ?>
</div>

<?php
// Guarda el HTML generado como contenido temporal
$contenido = tempnam(sys_get_temp_dir(), 'vista');
file_put_contents($contenido, ob_get_clean());

// ✅ Inyectar CSS global SOLO para dashboard
$extraStyles = '<link rel="stylesheet" href="/FastFoodSystem/assets/css/global.css">';

// Llama al layout principal (main.php), que puede incluir estos estilos opcionales
require 'views/layouts/main.php';

// Limpieza del archivo temporal
unlink($contenido);
