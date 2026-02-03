<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
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

        .list-group-item {
            border: none;
            background: #fff;
            padding: 10px 16px;
            border-left: 4px solid #ffc107;
            margin-bottom: 8px;
            border-radius: 8px;
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
        <h2 class="mb-4 text-center">Panel del encargado</h2>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-bg-primary">
                    <div class="card-header">💰 Ventas hoy</div>
                    <div class="card-body">
                        <h5 class="card-title">$12.340</h5>
                        <p class="card-text">Resumen de ingresos diarios.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-success">
                    <div class="card-header">📦 Pedidos en curso</div>
                    <div class="card-body">
                        <h5 class="card-title">27</h5>
                        <p class="card-text">Pedidos activos actualmente.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning">
                    <div class="card-header">⚠️ Productos bajos en stock</div>
                    <div class="card-body">
                        <h5 class="card-title">5</h5>
                        <p class="card-text">Productos que requieren reposición.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secciones adicionales -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-secondary">
                    <div class="card-header bg-secondary text-white">📈 Rendimiento semanal</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Lunes: $9.450</li>
                            <li class="list-group-item">Martes: $11.020</li>
                            <li class="list-group-item">Miércoles: $10.300</li>
                            <li class="list-group-item">Jueves: $12.900</li>
                            <li class="list-group-item">Viernes: $15.100</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">🚨 Alertas recientes</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Falta de stock: Pan de hamburguesa</li>
                            <li class="list-group-item">Pedido #1034 retrasado 15 min</li>
                            <li class="list-group-item">Refrigerador 2 sin revisión</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado del personal -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">👥 Estado del personal</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Juan Pérez - En cocina</li>
                            <li class="list-group-item">María Gómez - Caja</li>
                            <li class="list-group-item">Lucas Ruiz - Delivery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
