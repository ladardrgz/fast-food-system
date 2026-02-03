<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar unidad de medida</h2>

        <form id="formUnidad" class="row g-2 mb-4" novalidate>
            <div class="col-md-6">
                <input type="text" id="nombreUnidad" class="form-control" placeholder="Nombre completo (Ej: Gramos)" required>
            </div>
            <div class="col-md-5">
                <input type="text" id="abreviaturaUnidad" class="form-control" placeholder="Abreviatura (Ej: g)" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaUnidades" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateUnidadMedida.js"></script>
</body>

</html>