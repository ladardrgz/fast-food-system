<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar localidad</h2>

        <form id="formLocalidad" class="d-flex mb-4 gap-2" novalidate>
            <div class="col-md-4">
                <select id="selectPais" class="form-select" required>
                    <option value="">Seleccione país</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="selectProvincia" class="form-select" required>
                    <option value="">Seleccione provincia</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" id="nombreLocalidad" class="form-control" placeholder="Nombre localidad" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaLocalidades" class="list-group"></ul>

        <script type="module" src="/FastFoodSystem/assets/js/validateLocalidad.js"></script>

</body>