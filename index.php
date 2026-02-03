<?php
// Inicia la sesión de forma centralizada usando la clase "Sesion" e invoca al método iniciar
require_once 'core/Sesion.php';
Sesion::iniciar();

// Autocarga de clases: intenta incluir automáticamente controladores o modelos según el nombre de clase
spl_autoload_register(function ($class) {
    $controllerPath = "controllers/$class.php";
    $modelPath = "models/$class.php";

    if (file_exists($controllerPath)) {
        require_once $controllerPath;  // Si es un controlador
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;       // Si es un modelo
    }
});

// Define el nombre del controlador y la acción a ejecutar, con valores por defecto si no se pasan
$controllerName = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : 'HomeController';
$actionName = $_GET['action'] ?? 'index';

// Previene ataques o errores: elimina cualquier basura tipo JSON pegado
$actionName = preg_replace('/[^a-zA-Z0-9_]/', '', $actionName);


// Verifica si el archivo del controlador existe físicamente
$controllerPath = "controllers/$controllerName.php";
if (!file_exists($controllerPath)) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => "Controlador no encontrado: $controllerName"
    ]);
    exit;
}

// Incluye el archivo del controlador y lo instancia
require_once $controllerPath;
$controller = new $controllerName(); // Crea una instancia dinámica, ej: new PaisController()

// Verifica si la acción/método realmente existe en el controlador instanciado
if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => "Acción no encontrada: $actionName"
    ]);
    exit;
}

// Ejecuta la acción deseada del controlador con una llamada dinámica
call_user_func([$controller, $actionName]);