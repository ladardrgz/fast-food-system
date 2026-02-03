<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar ingrediente</h2>

        <form id="formIngrediente" class="row g-2 mb-4" novalidate>
            <div class="col-md-6">
                <input type="text" id="nombreIngrediente" class="form-control" placeholder="Nombre del ingrediente" required>
            </div>
            <div class="col-md-5">
                <select id="unidadMedida" class="form-select" required>
                    <option value="">Seleccione unidad</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaIngredientes" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateIngrediente.js"></script>
</body>

</html>