<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="icon" href="/FastFoodSystem/assets/images/Logo-Hamburguesa.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('/FastFoodSystem/assets/images/Formularios.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #444;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005f7a;
        }

        a {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #555;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Recuperar contraseña</h2>
        <form id="recuperarForm" method="post" novalidate>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
            <input type="submit" value="Enviar enlace de recuperación">
        </form>
        <a href="/FastFoodSystem/index.php?controller=Login&action=loginView">Volver al inicio de sesión</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('recuperarForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const emailInput = document.getElementById('email');
        const email = emailInput.value.trim();

        // Desactivar el botón mientras se procesa
        const submitButton = this.querySelector('input[type="submit"]');
        submitButton.disabled = true;

        // Validaciones

        // 1. Campo vacío
        if (!email) {
            Swal.fire('Campo requerido', 'Por favor, proporciona un correo electrónico.', 'warning');
            submitButton.disabled = false;
            return;
        }

        // 2. Longitud mínima y máxima
        if (email.length < 6 || email.length > 100) {
            Swal.fire('Correo inválido', 'El correo debe tener entre 6 y 100 caracteres.', 'warning');
            submitButton.disabled = false;
            return;
        }

        // 3. Caracteres prohibidos (protección extra contra inyecciones)
        const invalidChars = /[<>"'`;(){}\[\]]/;
        if (invalidChars.test(email)) {
            Swal.fire('Correo inválido', 'El correo contiene caracteres no permitidos.', 'warning');
            submitButton.disabled = false;
            return;
        }

        // 4. Formato básico válido
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!emailRegex.test(email)) {
            Swal.fire('Correo inválido', 'El formato del correo electrónico no es válido.', 'warning');
            submitButton.disabled = false;
            return;
        }

        // Enviar solicitud al servidor
        const params = new URLSearchParams();
        params.append('email', email);

        fetch(`/FastFoodSystem/index.php?controller=Usuario&action=enviarRecuperacion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: params
            })
            .then(async res => {
                const data = await res.json();
                Swal.fire(data.title || 'Respuesta', data.message || '', data.status || 'info');
            })
            .catch(() => {
                Swal.fire('Error', 'Algo salió mal al procesar la solicitud.', 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
            });
    });
</script>

</body>

</html>