<head>

    <style>
        body {
            background-color: #f8f9fa;
        }

        h2 {
            font-weight: 700;
        }

        .carousel-item img {
            height: 450px;
            object-fit: cover;
            border-radius: 10px;
        }

        .carousel-caption {
            background: rgba(255, 1, 1, 0.6);
            padding: 20px;
            border-radius: 10px;
        }

        .menu-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
        }

        .menu-description {
            font-size: 1rem;
            color: #ddd;
        }

        .pedido-btn {
            background-color: #ffc107;
            color: #212529;
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .pedido-btn:hover {
            background-color: #ffca2c;
            transform: scale(1.05);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <div id="menuCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <?php
            $productos = [
                [
                    'nombre' => 'Hamburguesa simple',
                    'descripcion' => 'Panes caseros, huevos, lechuga, tomate, mayonesa, carne y queso',
                    'imagen' => 'https://static.vecteezy.com/system/resources/previews/028/248/175/non_2x/gourmet-affair-a-delectable-burger-with-crispy-veggies-on-a-posh-plate-ai-generated-photo.jpg'
                ],
                [
                    'nombre' => 'Ensalada césar',
                    'descripcion' => 'Lechuga, pollo, croutons, queso y aderezo',
                    'imagen' => 'https://static.vecteezy.com/system/resources/previews/002/981/408/non_2x/fresh-delicious-salad-with-chicken-tomato-cucumber-onions-and-greens-with-olive-oil-photo.JPG'
                ],
                [
                    'nombre' => 'Pizza completa',
                    'descripcion' => 'Masa casera, morrones, aros de cebolla y queso',
                    'imagen' => 'https://static.vecteezy.com/system/resources/previews/016/117/257/non_2x/sausage-and-vegetable-pizza-on-dark-background-photo.jpg'
                ],
                [
                    'nombre' => 'Papas fritas',
                    'descripcion' => 'Papas crocantes con sal',
                    'imagen' => 'https://static.vecteezy.com/system/resources/previews/012/841/970/non_2x/french-fries-in-a-bowl-on-wooden-background-free-photo.jpg'
                ]
            ];

            foreach ($productos as $index => $producto) {
                $active = $index === 0 ? 'active' : '';
                echo <<<HTML
                <div class="carousel-item {$active}">
                    <img src="{$producto['imagen']}" class="d-block w-100" alt="{$producto['nombre']}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="menu-title">{$producto['nombre']}</h5>
                        <p class="menu-description">{$producto['descripcion']}</p>
                        <button class="btn pedido-btn mt-3" onclick="pedirProducto('{$producto['nombre']}')">Pedir</button>
                    </div>
                </div>
HTML;
            }
            ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>
</body>
</html>
