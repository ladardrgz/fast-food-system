<?php
require_once 'core/Sesion.php';

class HomeController
{
    public function index()
    {
        Sesion::iniciar();

        // Si ya está logueado, mandarlo al panel
        if (Sesion::usuarioAutenticado()) {
            header('Location: index.php?controller=panel&action=index');
            exit;
        }

        require_once 'views/cliente/home.php';
    }
}
