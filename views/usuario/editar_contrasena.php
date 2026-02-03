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
        .btn-primary {
            background-color:rgb(173, 54, 54);
            border: none;
        }
        .btn-primary:hover {
            background-color:rgb(154, 54, 54);
            border: none;
        }
    </style>
</head>
<div class="container container-custom">
    <h1>Cambiar contraseña</h1>
    <p class="text-muted">Actualizá tu contraseña para mayor seguridad</p>

    <form id="formEditarContrasena" novalidate>
        <!-- Contraseña actual -->
        <div class="mb-3">
            <label for="actual" class="form-label">Contraseña actual</label>
            <input type="password" class="form-control" id="actual" name="actual">
            <div class="invalid-feedback"></div>
        </div>

        <!-- Nueva contraseña -->
        <div class="mb-3">
            <label for="nueva" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="nueva" name="nueva">
            <div class="invalid-feedback"></div>
        </div>

        <!-- Confirmar nueva contraseña -->
        <div class="mb-3">
            <label for="confirmar" class="form-label">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="confirmar" name="confirmar">
            <div class="invalid-feedback"></div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
        </div>
    </form>
</div>

<script type="module" src="assets/js/validateEditarContrasena.js"></script>