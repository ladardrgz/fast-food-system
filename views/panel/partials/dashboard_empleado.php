<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            font-weight: bold;
            color: #343a40;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
            border-radius: 16px;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            background: linear-gradient(90deg, #198754 0%, #20c997 100%);
            color: white;
            font-weight: 500;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .list-group-item {
            border: none;
            background-color: #f1f1f1;
            margin-bottom: 4px;
            border-radius: 8px;
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
        <h2 class="mb-4 text-center">Panel de empleado</h2>

        <div class="row">
            <!-- Turno de hoy -->
            <div class="col-md-4 mb-4">
                <div class="card border-primary">
                    <div class="card-header">🕒 Tu turno de hoy</div>
                    <div class="card-body">
                        <p class="card-text">⏰ 14:00 - 22:00 hs</p>
                        <p class="card-text">📍 Sucursal: Centro</p>
                    </div>
                </div>
            </div>

            <!-- Tareas asignadas -->
            <div class="col-md-4 mb-4">
                <div class="card border-warning">
                    <div class="card-header">📝 Tareas del día</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Preparar estación de trabajo</li>
                            <li class="list-group-item">Control de stock de bebidas</li>
                            <li class="list-group-item">Supervisar limpieza de cocina</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pedidos en curso -->
            <div class="col-md-4 mb-4">
                <div class="card border-danger">
                    <div class="card-header">🍽️ Pedidos en curso</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">#1052 - En preparación</li>
                            <li class="list-group-item">#1051 - En espera de entrega</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>