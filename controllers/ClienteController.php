<?php

class ClienteController
{
    public function registrar()
    {
        // Cargar modelos necesarios
        $paisModel       = new PaisModel();
        $provinciaModel  = new ProvinciaModel();
        $localidadModel  = new LocalidadModel();
        $barrioModel     = new BarrioModel();
        $tipoDocModel    = new TipoDocumentoModel();
        $tipoContModel   = new TipoContactoModel();
        $generoModel     = new GeneroModel();

        // Obtener datos
        $generos        = $generoModel->obtenerTodos();
        $paises         = $paisModel->obtenerTodos();
        $provincias     = $provinciaModel->obtenerTodos();
        $localidades    = $localidadModel->obtenerTodos();
        $barrios        = $barrioModel->obtenerTodos();
        $tiposDocumento = $tipoDocModel->obtenerTodos();
        $tiposContacto  = $tipoContModel->obtenerTodos();

        // Mostrar la vista
        require_once 'views/cliente/registrar.php';
    }

    public function guardar()
    {
        $isJson = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
        $data = $isJson
            ? json_decode(file_get_contents('php://input'), true)
            : $_POST;

        $camposObligatorios = [
            'nombre',
            'apellido',
            'fechaNacimiento',
            'genero',
            'calle',
            'numero',
            'barrio',
            'tipoDoc',
            'valorDoc',
            'tipoCont',
            'valorCont',
            'contrasena'
        ];

        foreach ($camposObligatorios as $campo) {
            if (empty($data[$campo])) {
                return $this->responder($isJson, false, "Falta el campo: $campo");
            }
        }

        try {
            $personaModel = new PersonaModel();
            $usuarioModel = new UsuarioModel();

            // Verificar documento duplicado
            if ($personaModel->existeDocumento($data['valorDoc'], (int)$data['tipoDoc'])) {
                return $this->responder($isJson, false, "Ya existe una persona con ese número de documento.");
            }

            // Crear persona
            $idPersona = $personaModel->crearPersona([
                'nombre'          => $data['nombre'],
                'apellido'        => $data['apellido'],
                'fechaNacimiento' => $data['fechaNacimiento'],
                'genero'          => $data['genero'],
                'calle'           => $data['calle'],
                'numero'          => $data['numero'],
                'piso'            => $data['piso'] ?? null,
                'dpto'            => $data['dpto'] ?? null,
                'barrio'          => $data['barrio'],
                'tipoDoc'         => $data['tipoDoc'],
                'valorDoc'        => $data['valorDoc'],
                'tipoCont'        => $data['tipoCont'],
                'valorCont'       => $data['valorCont']
            ]);

            // Insertar cliente
            $db = (new Conexion())->Conectar();
            $stmt = $db->prepare("INSERT INTO clientes (rela_persona) VALUES (:id)");
            $stmt->execute([':id' => $idPersona]);

            // 🔁 Generar nombre de usuario automáticamente a partir del contacto
            $usuarioBase = $this->generarUsuarioDesdeContacto($data['valorCont']);
            $usuarioFinal = $usuarioBase;
            $contador = 1;
            while ($usuarioModel->existeUsuario($usuarioFinal)) {
                $usuarioFinal = $usuarioBase . $contador;
                $contador++;
            }

            // Crear usuario
            $creado = $usuarioModel->crearUsuario(
                $usuarioFinal,
                $data['contrasena'],
                $idPersona,
                5
            );

            if ($creado) {
                return $this->responder($isJson, true, "Cliente registrado correctamente");
            } else {
                return $this->responder($isJson, false, "Error al crear el usuario cliente");
            }
        } catch (Exception $e) {
            return $this->responder($isJson, false, "Error interno: " . $e->getMessage());
        }
    }
    private function generarUsuarioDesdeContacto(string $contacto): string
    {
        // Limpia caracteres especiales y genera base
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $contacto));

        // En caso de que quede vacío por algún motivo, usa un prefijo genérico
        return $base !== '' ? $base : 'cliente';
    }
    private function responder($esJson, $exito, $mensaje)
    {
        if ($esJson) {
            echo json_encode([
                'success' => $exito,
                'message' => $mensaje
            ]);
        } else {
            if ($exito) {
                header('Location: index.php?controller=Cliente&action=registrar&exito=1');
            } else {
                echo "<script>alert('{$mensaje}'); window.history.back();</script>";
            }
        }
    }
    public function home()
    {
        require_once 'views/cliente/home.php';
    }
    public function verCarta()
    {
        require_once 'views/cliente/carta.php';
    }
        public function verMenu()
    {
        $titulo = 'Menú de comidas';
        $contenido = 'views/cliente/menu.php';
        require 'views/layouts/main.php';
    }
}
