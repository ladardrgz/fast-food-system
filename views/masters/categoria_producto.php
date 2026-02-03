<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar categoría</h2>

        <form id="formCategoria" class="d-flex mb-4 gap-2" novalidate>
            <div class="col-md-11">
                <input type="text" id="nombreCategoria" class="form-control" placeholder="Nombre de la categoría" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaCategorias" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateCategoriaProducto.js"></script>
</body>