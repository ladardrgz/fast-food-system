<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FastFoodSystem</title>

    <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/alertas.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

    <style>
        :root {
            --rojo: #d32b0f;
            --rojo-oscuro: #78120b;
            --dorado: #f2c561;
            --marron-oscuro: #2f1d15;
        }

        body {
            background: url('/FastFoodSystem/assets/images/Login.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.35);
            z-index: -1;
        }

        .login-card {
            background: rgba(30, 30, 30, 0.65);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 400px;
            width: 100%;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .logo-sistema {
            max-width: 140px;
            margin: 0 auto 1rem;
            display: block;
        }

        .nombre-sistema {
            font-size: 2rem;
            color: var(--dorado);
            font-weight: 600;
            text-align: center;
        }

        h2 {
            color: var(--dorado);
            font-size: 1.5rem;
            text-align: center;
            margin: 1.5rem 0;
        }

        input.form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #555;
            border-radius: 10px;
            color: #fff;
            font-size: 0.95rem;
        }

        input.form-control::placeholder {
            color: #ccc;
        }

        input.form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--dorado);
            color: #fff;
            box-shadow: none;
        }

        .btn-login {
            width: 100%;
            padding: 0.6rem;
            background-color: var(--rojo);
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1rem;
            text-transform: uppercase;
            margin-top: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--rojo-oscuro);
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .form-links a {
            color: var(--dorado);
            text-decoration: none;
        }

        .form-links a:hover {
            color: #e3b250;
            text-decoration: underline;
        }

        .btn-volver-inicio {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: var(--rojo);
            color: #fff;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 9999;
        }

        .btn-volver-inicio:hover {
            background-color: var(--rojo-oscuro);
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="background-overlay"></div>

    <div class="login-card">
        <div class="text-center">
            <img src="/FastFoodSystem/assets/images/Logo-Hamburguesa.png" alt="Logo del sistema" class="logo-sistema">
            <h1 class="nombre-sistema">FastFoodSystem</h1>
        </div>

        <h2>Iniciar sesión</h2>
        <form id="loginForm" autocomplete="off" novalidate>
            <div class="mb-3">
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario o correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn-login">Ingresar</button>

            <div class="form-links">
                <a href="index.php?controller=Registro&action=cliente">Registrarse</a>
                <a href="/FastFoodSystem/index.php?controller=Usuario&action=recuperarContrasena">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
    <a href="index.php?controller=Cliente&action=home" class="btn-volver-inicio">← Volver al inicio</a>
    <!-- JavaScript modular -->
    <script type="module" src="/FastFoodSystem/assets/js/login.js"></script>
    <!-- Librerías necesarias -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>