<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon" />
    <title>Crear usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('/FastFoodSystem/assets/images/ImageForm.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: transform 0.3s ease;
        }

        .card-header {
            background-color: transparent;
            border-bottom: none;
        }

        .card-header h3 {
            color: #77231F;
            font-weight: bold;
        }

        label {
            font-weight: 500;
            color: #343a40;
        }

        .btn-success {
            background-color: #77231F;
            border-color: #77231F;
        }

        .btn-success:hover {
            background-color: #5e1b19;
            border-color: #5e1b19;
        }

        .is-valid {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, .25);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card">
                    <div class="card-header text-center">
                        <h3>Crear usuario</h3>
                    </div>
                    <div class="card-body">
                        <form id="registroForm" method="post" action="index.php?controller=usuario&action=crear">
                            <!-- Datos personales -->
                            <h5>Datos personales</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" minlength="2" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" minlength="2" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required min="1924-01-01" max="2007-12-31">
                            </div>

                            <!-- Género -->
                            <div class="mb-3">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" id="genero" name="genero" required>
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <!-- Dirección -->
                            <h5 class="mt-4">Dirección</h5>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="pais" class="form-label">País</label>
                                    <select class="form-select" id="pais" name="pais" required></select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="provincia" class="form-label">Provincia</label>
                                    <select class="form-select" id="provincia" name="provincia" required></select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="localidad" class="form-label">Localidad</label>
                                    <select class="form-select" id="localidad" name="localidad" required></select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="barrio" class="form-label">Barrio</label>
                                    <select class="form-select" id="barrio" name="barrio" required></select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="calle" class="form-label">Calle</label>
                                    <input type="text" class="form-control" id="calle" name="calle" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="piso" class="form-label">Piso</label>
                                    <input type="text" class="form-control" id="piso" name="piso">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dpto" class="form-label">Departamento</label>
                                    <input type="text" class="form-control" id="dpto" name="dpto">
                                </div>
                            </div>

                            <!-- Documento -->
                            <h5 class="mt-4">Documento</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipoDoc" class="form-label">Tipo</label>
                                    <select class="form-select" id="tipoDoc" name="tipoDoc" required></select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="valorDoc" class="form-label">Número de documento</label>
                                    <input type="text" class="form-control" id="valorDoc" name="valorDoc" required>
                                </div>
                            </div>

                            <!-- Contacto -->
                            <h5 class="mt-4">Contacto</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="tipoCont" class="form-label">Tipo</label>
                                    <select class="form-select" id="tipoCont" name="tipoCont" required></select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="valorCont" class="form-label">Ingrese el valor</label>
                                    <input type="text" class="form-control" id="valorCont" name="valorCont" required>
                                </div>
                            </div>

                            <!-- Credenciales -->
                            <h5 class="mt-4">Credenciales</h5>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contrasena" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="8">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmContrasena" class="form-label">Confirmar contraseña</label>
                                    <input type="password" class="form-control" id="confirmContrasena" name="confirmContrasena" required minlength="8">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="perfil" class="form-label">Perfil</label>
                                <select class="form-select" id="perfil" name="perfil" required></select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/alertas.js"></script>
    <script type="module" src="/FastFoodSystem/assets/js/direcciones.js"></script>
    <script type="module" src="/FastFoodSystem/assets/js/documentos.js"></script>
    <script type="module" src="/FastFoodSystem/assets/js/contactos.js"></script>
    <script type="module" src="/FastFoodSystem/assets/js/perfiles.js"></script>
    <script type="module" src="/FastFoodSystem/assets/js/generos.js"></script>
    <script type="module" src="/GastroSystem/assets/js/validateUsuario.js"></script>
</body>

</html>