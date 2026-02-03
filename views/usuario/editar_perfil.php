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
            color: rgb(253, 13, 13);
            text-decoration: none;
        }

        a.action-link:hover {
            text-decoration: underline;
        }

        .is-valid {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, .25);
        }

        .btn-primary {
            background-color: rgb(173, 54, 54);
            border: none;
        }

        .btn-primary:hover {
            background-color: rgb(154, 54, 54);
            border: none;
        }
    </style>
</head>
<div class="container container-custom">
    <h1>Editar información personal</h1>
    <p class="text-muted">Modificá tus datos básicos en el sistema</p>

    <form id="formEditarPerfil" novalidate>
        <!-- Nombre y apellido -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre"
                value="<?= htmlspecialchars($datos['nombre_persona'] ?? '') ?>">
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido"
                value="<?= htmlspecialchars($datos['apellido_persona'] ?? '') ?>">
            <div class="invalid-feedback"></div>
        </div>

        <!-- Fecha de nacimiento -->
        <div class="mb-3">
            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento"
                value="<?= htmlspecialchars($datos['fecha_nacimiento_persona'] ?? '') ?>">
            <div class="invalid-feedback"></div>
        </div>

        <!-- Género -->
        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <select class="form-select" id="genero" name="genero">
                <option value="">Seleccionar</option>
                <?php foreach ($generos as $genero): ?>
                    <option value="<?= $genero['id_genero'] ?>"
                        <?= isset($datos['id_genero']) && $datos['id_genero'] == $genero['id_genero'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genero['nombre_genero']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <!-- Usuario -->
        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario"
                value="<?= htmlspecialchars($datos['nombre_usuario'] ?? '') ?>">
            <div class="invalid-feedback"></div>
        </div>

        <!-- Botón -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>

<script type="module" src="assets/js/validateEditarPerfil.js"></script>