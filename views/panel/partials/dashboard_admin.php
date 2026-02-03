<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            font-weight: 600;
            color: #333;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            font-weight: 500;
        }

        .container-custom {
            padding: 40px 20px;
        }

        @media (max-width: 768px) {
            .container-custom {
                padding: 20px 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container container-custom">

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-bg-dark">
                    <div class="card-header">🔒 Seguridad</div>
                    <div class="card-body">
                        <h5 class="card-title">Sin alertas</h5>
                        <p class="card-text">Todos los accesos están controlados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-secondary">
                    <div class="card-header">⚙️ Integridad del sistema</div>
                    <div class="card-body">
                        <h5 class="card-title">Operativo</h5>
                        <p class="card-text">La plataforma funciona sin errores conocidos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-info">
                    <div class="card-header">🧑‍💻 Sesiones activas</div>
                    <div class="card-body">
                        <h5 class="card-title">4 usuarios conectados</h5>
                        <p class="card-text">Último acceso hace 12 minutos.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">📁 Últimos cambios en el sistema</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Actualización de usuarios (hace 3 días)</li>
                            <li class="list-group-item">Nuevo restaurante agregado (hace 1 semana)</li>
                            <li class="list-group-item">Cambios menores en configuración</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">🧩 Módulos activos</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Pedidos en línea ✅</li>
                            <li class="list-group-item">Control de stock ✅</li>
                            <li class="list-group-item">Módulo de reservas ✅</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>