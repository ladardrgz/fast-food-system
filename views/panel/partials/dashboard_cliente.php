<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
            border-radius: 16px;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
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
        <h2 class="mb-4 text-center">Panel de cliente</h2>

        <div class="row">
            <!-- Promoción del día -->
            <div class="col-md-6 mb-4">
                <div class="card border-info">
                    <div class="card-header">🎉 Promoción del día</div>
                    <div class="card-body">
                        <h5 class="card-title">2x1 en pizzas 🍕</h5>
                        <p class="card-text">Solo por hoy hasta las 22 hs. ¡No te lo pierdas!</p>
                    </div>
                </div>
            </div>

            <!-- Últimos pedidos -->
            <div class="col-md-6 mb-4">
                <div class="card border-success">
                    <div class="card-header">🧾 Tus últimos pedidos</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">#1001 - Pizza napolitana</li>
                            <li class="list-group-item">#1000 - Hamburguesa especial</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
