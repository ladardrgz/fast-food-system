<head>
    <style>
        .container-custom {
            max-width: 800px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 0;
        }

        .info-label {
            font-weight: 500;
            color: #343a40;
        }

        .info-value {
            color: #6c757d;
        }

        .chevron {
            margin-left: 8px;
            color: #6c757d;
        }

        .profile-pic {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #d7d7d7;
            display: inline-block;
            vertical-align: middle;
        }

        a.action-link {
            color: #0d6efd;
            text-decoration: none;
        }

        a.action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container container-custom">
        <h1>Información personal</h1>
        <p class="text-muted">Información sobre vos y tus preferencias en el sistema</p>

        <!-- Información básica -->
        <div class="section mt-4">
            <h4>Información básica</h4>
            <div class="info-row">
                <span class="info-label">Nombre y apellido</span>
                <span class="info-value">
                    <?= htmlspecialchars(($datos['nombre_persona'] ?? '') . ' ' . ($datos['apellido_persona'] ?? 'Sin establecer')) ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de nacimiento</span>
                <span class="info-value">
                    <?= !empty($datos['fecha_nacimiento_persona']) ? date('d/m/Y', strtotime($datos['fecha_nacimiento_persona'])) : 'Sin establecer' ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Género</span>
                <span class="info-value">
                    <?= htmlspecialchars($datos['nombre_genero'] ?? 'Sin establecer') ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
        </div>

        <!-- Información de contacto -->
        <div class="section mt-4">
            <h4>Información de contacto</h4>
            <div class="info-row">
                <span class="info-label">Correo electrónico</span>
                <span class="info-value">
                    <?= htmlspecialchars($datos['correo'] ?? 'Sin establecer') ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono</span>
                <span class="info-value">
                    <?= htmlspecialchars($datos['telefono'] ?? 'Sin establecer') ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
        </div>

        <!-- Direcciones -->
        <div class="section mt-4">
            <h4>Direcciones</h4>
            <div class="info-row">
                <span class="info-label">Domicilio</span>
                <span class="info-value">
                    <?php
                    $direccion = 'Sin establecer';
                    if (!empty($datos['nombre_pais']) && !empty($datos['nombre_provincia']) && !empty($datos['nombre_barrio']) && !empty($datos['calle_direccion'])) {
                        $direccion = "{$datos['nombre_pais']}, {$datos['nombre_provincia']}, {$datos['nombre_barrio']}, {$datos['calle_direccion']} {$datos['numero_direccion']}";
                    }
                    echo htmlspecialchars($direccion);
                    ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
        </div>

        <!-- Seguridad -->
        <div class="section mt-4">
            <h4>Seguridad</h4>
            <div class="info-row">
                <span class="info-label">Nombre de usuario</span>
                <span class="info-value">
                    <?= htmlspecialchars($datos['nombre_usuario'] ?? 'Sin establecer') ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Contraseña</span>
                <span class="info-value">
                    ••••••••
                    <?php
                    if (!empty($datos['fecha_ultimo_login'])) {
                        $fecha = date('d M', strtotime($datos['fecha_ultimo_login']));
                        echo "<small class='text-muted'>(Última modificación: $fecha)</small>";
                    }
                    ?>
                    <span class="chevron">&rsaquo;</span>
                </span>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-4 d-flex justify-content-between flex-wrap gap-2">
            <button id="btnEditarPerfil" class="btn btn-outline-primary">
                Modificar información básica
            </button>
            <button id="btnEditarContrasena" class="btn btn-outline-danger">
                Modificar mi contraseña
            </button>
        </div>

        <!-- Carga del script JS para validaciones futuras -->
        <script src="assets/js/validateAdministrarPerfil.js"></script>
</body>

</html>