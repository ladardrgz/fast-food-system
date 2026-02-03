<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel del repartidor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            font-weight: 600;
            color: #333;
        }

        .container-custom {
            padding: 30px 15px;
        }

        .list-group-item {
            background-color: #ffffff;
            margin-bottom: 10px;
            border-radius: 10px;
            border-left: 5px solid #0d6efd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #e9f5ff;
        }

        .badge-time {
            float: right;
            background-color: #0d6efd;
            color: white;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .icon {
            margin-right: 8px;
        }
    </style>
</head>

<body>

    <div class="container container-custom">
        <h2 class="mb-4 text-center">📦 Pedidos asignados</h2>

        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div><span class="icon">🛵</span>Pedido #1023 - Mariano Moreno 2855</div>
                <span class="badge-time">14:30 hs</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div><span class="icon">🛵</span>Pedido #1024 - Maipú 3954</div>
                <span class="badge-time">15:00 hs</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div><span class="icon">🛵</span>Pedido #1025 - Av. 25 de Mayo</div>
                <span class="badge-time">15:45 hs</span>
            </a>
        </div>
    </div>

</body>

</html>