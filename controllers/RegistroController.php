<?php
class RegistroController
{
    public function cliente()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit;
        }

        require_once 'views/cliente/registrar.php';
    }
}
